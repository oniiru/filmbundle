<?php
/**
 * Handle tip the filmmaker and its integration with EDD.
 */
class Pwyw_Tip
{
    /** Holds the class instance */
    protected static $instance = false;

    /** Define class constants */
    const SCRIPT_VERSIONS = '1.0';

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
        add_action('wp_enqueue_scripts', array(&$this, 'scripts'));
    }

    /**
     * Load scripts used by the film tipping.
     */
    public function scripts()
    {
        // Only load the script on the films post type
        if (!is_singular('films')) {
            return;
        }

        wp_enqueue_script(
            'pwyw-tip-filmmaker',
            plugins_url('/assets/javascripts/tip-filmmaker.js', Pwyw::FILE),
            array('jquery'),
            self::SCRIPT_VERSIONS,
            true
        );
    }

    /**
     * Handles checkout and integrated with EDD PayPal Digital Goods Gateway
     */
    public function checkout()
    {
        // If no tip has been posted for checkout, return
        if (!$_POST['tipCheckout']) {
            return;
        }

        // Let's populate the $_POST array for EDD.
        $user = wp_get_current_user();
        $_POST['edd_email'] = $user->user_email;
        $_POST['edd_first'] = $user->display_name;


        /** Start the checkout process */
        // Empty the cart, just in case
        edd_empty_cart();

        // Add the relevant product to the cart
        edd_add_to_cart($_POST['download_id']);

        // Create a filter to adjust the amount for the checkout
        add_filter('edd_cart_item_price',
            function($price) { return $_POST['tipAmount']; }
        );

        // And go to the gateway!
        edd_process_purchase_form();
    }
}
