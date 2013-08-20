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
            }
        }

        // If we still don't have a user, let's exit
        if (!is_user_logged_in()) {
            $_POST['pwyw-checkout-error'] = 'You need to login before checkout.';
            return;
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
        $current_user = wp_get_current_user();
        $_POST['edd_email'] = $current_user->user_email;
        $_POST['edd_first'] = $current_user->display_name;


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
}

/*



$pwyw = Pwyw::getInstance();
$pwyw_data = $pwyw->pwyw_get_bundle_info();
$nonce = wp_create_nonce('pwyw_bundle_checkout');
$nonce2 = wp_create_nonce('pwyw_ajax');
?>

<script type='text/javascript'>
jQuery(document).ready(function($) {
    var pwyw_data = {};
    var main_cat = [];
    var alias;
    var user_alias,twitter_alias;

*/

/*
    $('.btn-success').click(function(){
        user_alias = $('input[placeholder="username"]').val();
        twit_alias = $('input[placeholder="twitterhandle"]').val();

        var is_twitter = 0;

        if(twit_alias!=''){
            alias = twit_alias;
            is_twitter = 1
        }else if(user_alias!=''){
            alias = user_alias;
        }


        $('input[name="alias"]').val(alias);
        $('input[name="is_twitter"]').val(is_twitter);

          var btn = $('.buttonslidegroup').find('button.active');
          if(!btn.length||$(btn).attr('id') == 'custom_price'){
              c_price = $('input.custompricefield').val();
          }else{
             c_price = $(btn).val();
          }

          $('input[name="c_price"]').val(c_price);

          if(c_price >= 0.01){
              check = true;
          }

          $('#bundle_checkout').submit();
          return false;
    });
*/

/*
});
</script>

<div class="container">
    <div class="bodyhome">
        <form id="bundle_checkout" method="POST" action="<?php echo $pwyw->plugin_url ?>bundle_checkout.php">
                    <input type="hidden" name="c_price" value=""/>
                    <input type="hidden" name="alias" value=""/>
                    <input type="hidden" name="action" value="checkout"/>
                    <input type="hidden" name="is_twitter" value=""/>
                    <input type="hidden" name="_ajax_nonce" value="<?php echo $nonce ?>"/>
                    <input type="hidden" name="bid" value="<?php echo $pwyw_data['bundle']->id?>"/>
<!--
        <div class="content2">
            <div class="step2">
                <a href="#" class="btn btn-large btn-success"> Checkout </a>
            </div>
        </div>
-->
    </div>

</form>

*/

