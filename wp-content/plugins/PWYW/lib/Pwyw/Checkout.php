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
        // $this->addPayment(376);

        add_action('init', array(&$this, 'checkout'));
        add_action('edd_insert_payment', array(&$this, 'savePwywMeta'), 10, 2);
    }

    /**
     * Handles checkout and integrated with EDD:
     */
    public function checkout()
    {
        // If no bundle has been posted for checkout, return
        if (!$_POST['bundle_checkout']) {
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



}
