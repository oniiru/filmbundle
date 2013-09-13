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
        add_action('wp_enqueue_scripts', array(&$this, 'scripts'));

        add_action('wp_ajax_pwyw_tip', array(&$this, 'handlePpdg'));
        add_action('wp_ajax_nopriv_pwyw_tip', array(&$this, 'handlePpdg'));

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

        // Create the ajax script variable
        wp_localize_script(
            'pwyw-tip-filmmaker',
            'pwyw_ajax',
            array('url' => admin_url('admin-ajax.php' ))
        );
    }

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
        echo 'foobar';
        die;
    }
}
