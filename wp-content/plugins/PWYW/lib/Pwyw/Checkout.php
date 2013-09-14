<?php
/**
 * Handle checkout of bundles and integration with EDD.
 */
class Pwyw_Checkout
{
    /** Holds the class instance */
    protected static $instance = false;

    /** Singleton class */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->construct();
        }
        return self::$instance;
    }

    /** Singleton Constructor */
    public function __construct() {}

    /** Custom constructor */
    private function construct()
    {
        add_action('init', array(&$this, 'checkout'));
        add_action('edd_insert_payment', array(&$this, 'savePwywMeta'), 10, 2);
        add_action('edd_complete_purchase', array(&$this, 'addPayment'));

        // Register actions that replaces PayPal Digital Goods' actions
        add_action('wp_ajax_pwyw_ppdg', array(&$this, 'handlePpdg'));
        add_action('wp_ajax_nopriv_pwyw_ppdg', array(&$this, 'handlePpdg'));
        if (class_exists('EDD_PayPal_Digital_Goods')) {
            add_action('init', array('Pwyw_PpdgIpn', 'check_paypal_return'));
        }
    }

    /**
     * Handles checkout and integrated with EDD:
     */
    public function checkout()
    {
        // If no bundle has been posted for checkout, return
        if (!$_POST['bundleCheckout']) {
            return;
        }

        /* We have a checkout, let's validate and set up the data */
        // Must have an amount
        if ((float) $_POST['total_amount'] == 0) {
            $_POST['pwyw-checkout-error'] = '$0.00 is not a valid checkout price.';
            return;
        }

        // If we did not have a logged in user, let's create one!
        if (!is_user_logged_in()) {
            $username = $_POST['email'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $user_id = wp_create_user($username, $password, $email);

            // Failed to create user, so let's exit!
            if(is_wp_error($user_id)) {
                $_POST['pwyw-checkout-error'] = $user_id->get_error_message();
                return;
            }

            // We have a new user, make he/she a subscriber
            $user = new WP_User($user_id);
            $user->set_role('subscriber');

            // And finally, let's log in the new user
            $creds = array();
            $creds['user_login'] = $username;
            $creds['user_password'] = $password;
            $creds['remember'] = true;
            $user = wp_signon($creds, false);

            // If we could not sign in, let's exit!
            if (is_wp_error($user)) {
                $_POST['pwyw-checkout-error'] = $user->get_error_message();
                return;
            } else {
                // Make WordPress aware of the new user being logged in.
                wp_set_current_user($user->ID);
            }
        } else {
            $user = wp_get_current_user();
        }

        // Do some final, just in case validation.
        if (!isset($_POST['edd-gateway'])) {
            $_POST['pwyw-checkout-error'] = 'Payment method not selected.';
            return;
        }
        if (!isset($_POST['download_id'])) {
            $_POST['pwyw-checkout-error'] = 'No product selected.';
            return;
        }

        // We have our user, so let's populate the $_POST array for EDD.
        $_POST['edd_email'] = $user->user_email;
        $_POST['edd_first'] = $user->display_name;


        /** Start the checkout process */
        // Empty the cart, just in case
        edd_empty_cart();

        // Add the relevant product to the cart
        edd_add_to_cart($_POST['download_id']);

        // Create a filter to adjust the amount for the checkout
        add_filter('edd_cart_item_price',
            function($price) { return $_POST['total_amount']; }
        );

        // And go to the gateway!
        edd_process_purchase_form();
    }


    /**
     * Store PWYW data.
     *
     * Called when recording the payment as pending, before sending the customer
     * to the gateway. Here we store all the data relating to the purchase as
     * meta data in the database, so it can be safely retrieved when the order
     * is completed and paid.
     *
     * @param integer $payment
     * @param array $payment_data
     * @return void
     */
    public function savePwywMeta($payment, $payment_data)
    {
        $data = array();

        // Store user twitter/alias information
        $data['is_twitter_alias'] = null;
        $data['pwyw_user_alias'] = null;

        $is_twitter = 0;
        if ($_POST['twitterhandle'] != '') {
            $alias = $_POST['twitterhandle'];
            $is_twitter = 1;
        } elseif ($_POST['username'] != '') {
            $alias = $_POST['username'];
        }

        if (isset($alias) and strlen($alias) < 200) {
            $data['is_twitter_alias'] = $is_twitter;
            $data['pwyw_user_alias'] = strip_tags(trim($alias));
        }

        // Store the Bundle Daata
        $bid = (int) $_POST['bid'];
        $data['pwyw_bundle'][$bid]['categories'] = $_POST['categories'];
        $data['pwyw_bundle'][$bid]['user'] = get_current_user_id();
        $data['pwyw_bundle'][$bid]['avg_price'] = $_POST['average_price'];
        $data['pwyw_bundle'][$bid]['bundle_level'] = $_POST['download_id'];
        $data['pwyw_bundle_price'] = (float) $_POST['total_amount'];

        // Store the meta data
        update_post_meta($payment, '_edd_pwyw_data', $data);
    }


    /**
     * Adds the Payment to the PWYW customer table and payment info table.
     *
     * Called when the payment is marked as complete, either automatically
     * by the payment gateway, or manually by an administrator.
     *
     * @param integer $payment_id
     */
    public function addPayment($payment_id)
    {
        // Get the meta data and the user id for the payment
        $meta = get_post_meta($payment_id, '_edd_pwyw_data', true);
        $user_id = edd_get_payment_user_id($payment_id);

        global $wpdb;
        // Look up the WP user in the PWYW customers table
        $users = $wpdb->prefix.'pwyw_customers';
        $sql = "SELECT `id` FROM {$users} WHERE `cid`=%d";
        $user = $wpdb->query(
            $wpdb->prepare($sql, $user_id)
        );

        // If the wp user has no PWYW customer create one. Else update existing.
        if (!$user) {
            $wpdb->query(
                $wpdb->prepare(
                    "INSERT INTO {$users} (cid, alias, is_twitter)
                     VALUES (%d, %s, %d)",
                    $user_id,
                    $meta['pwyw_user_alias'],
                    $meta['is_twitter_alias']
                )
            );
        } else {
            if (isset($meta['pwyw_user_alias'])
                && !empty($meta['pwyw_user_alias'])
            ) {
                $wpdb->query(
                    $wpdb->prepare(
                        "UPDATE {$users}
                        SET alias = %s,is_twitter=%d
                        WHERE `cid`= {$user_id}",
                        $meta['pwyw_user_alias'],
                        $meta['is_twitter_alias']
                    )
                );
            }
        }

        // Add the payment to the payment info and allocation tables
        $payment_info = $wpdb->prefix.'pwyw_payment_info';
        $price_allocation = $wpdb->prefix.'pwyw_price_allocation';
        foreach ($meta['pwyw_bundle'] as $key => $data) {
            $res = $wpdb->query(
                $wpdb->prepare(
                    "INSERT INTO {$payment_info} (cid,order_id,sum,average_price,bundle,bundle_level)
                     VALUES (%d,%d,%f,%f,%d,%d)",
                    $user_id,
                    $payment_id,
                    $meta['pwyw_bundle_price'],
                    $data['avg_price'],
                    $key,
                    $data['bundle_level']
                )
            );
            $payment_info_id = $wpdb->insert_id;

            if ($res) {
                foreach ($meta['pwyw_bundle'][$key]['categories'] as $id => $val) {
                    $wpdb->query(
                        $wpdb->prepare(
                            "INSERT INTO {$price_allocation} (payment_id,cat_id,bundle,allocate_percent)
                             VALUES (%d,%d,%d,%d) ",
                            $payment_info_id,
                            $id,
                            $key,
                            $val
                        )
                    );
                }
            }
        }

        // And now, let's update the PubNub channel with the latest information.
        $pwyw = Pwyw::getInstance();
        $pwyw->pubNubPublish();
    }


    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Forces the cart to be set to a specific product and a specific price.
     *
     * @return void
     */
    private function setCart()
    {
        // Empty the cart, just in case
        edd_empty_cart();

        // Add the relevant product to the cart
        edd_add_to_cart($_POST['download_id']);

        // Create a filter to adjust the amount for the checkout
        add_filter('edd_cart_item_price',
            function($price) { return $_POST['total_amount']; }
        );
    }


    // -------------------------------------------------------------------------
    // Ajax
    // -------------------------------------------------------------------------

    /**
     * Handle creation of the PayPal Digital Goods link via Ajax call.
     *
     * Replaces edd-paypal-digital-goods.php -> show_paypal_button() with
     * the additional functionality of setting cart and amount on the fly.
     *
     * @return void
     */
    public function handlePpdg()
    {
        // First, let's set the cart
        $this->setCart();

        if ( !edd_get_errors() ) {
            $obj = $this->findEddPaypalDigitalGoodsObject();
            $purchase_details = $obj->create_purchase_details();
            $html = $obj->print_paypal_button($purchase_details);
            echo $html;
        }

        die;
    }


    // -------------------------------------------------------------------------
    // Hacks
    // -------------------------------------------------------------------------

    /**
     * Find the EDD PayPal Digital Goods object, so we can access it.
     *
     * Parse the registered actions in WordPress, as the plugin has no hooks
     * into it, or assigns itself to a variable (as it should). So we do this
     * hack to trace it down.
     *
     * @return object
     */
    private function findEddPaypalDigitalGoodsObject()
    {
        global $wp_filter;
        $arr = $wp_filter['wp_ajax_paypal_digital'];
        $key1 = key($arr);
        $key2 = key($arr[$key1]);

        return $arr[$key1][$key2]['function'][0];
    }
}
