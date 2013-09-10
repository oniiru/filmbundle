<?php
class Pwyw_Widgets
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
        }
        return self::$instance;
    }

    /** Singleton Constructor */
    private function __construct()
    {
        new Pwyw_WidgetBundles;
        new Pwyw_WidgetCheckout;
        add_action(
            'widgets_init',
            function() { register_widget('Pwyw_WidgetBundles'); }
        );

        add_action(
            'widgets_init',
            function() { register_widget('Pwyw_WidgetCheckout'); }
        );

        add_action('wp_enqueue_scripts', array(&$this, 'scripts'));
    }

    /**
     * Load scripts used by the widgets on the frontend.
     */
    public function scripts()
    {
        if (!is_home()) {
            return;
        }

        wp_enqueue_style(
            'pwyw-widget-bundle',
            plugins_url('/assets/stylesheets/widget-bundle.css', Pwyw::FILE),
            false,
            self::SCRIPT_VERSIONS,
            'all'
        );
        wp_enqueue_script(
            'pwyw-widget-bundle',
            plugins_url('/assets/javascripts/widget-bundle.js', Pwyw::FILE),
            array('jquery', 'jquery-ui-core', 'jquery-effects-core'),
            self::SCRIPT_VERSIONS,
            true
        );

        wp_enqueue_style(
            'pwyw-widget-checkout',
            plugins_url('/assets/stylesheets/widget-checkout.css', Pwyw::FILE),
            false,
            self::SCRIPT_VERSIONS,
            'all'
        );

        wp_register_script(
            'pubnub',
            'http://cdn.pubnub.com/pubnub-3.5.3.min.js',
            array(),
            '3.5.3',
            true
        );

        wp_register_script(
            'linked-sliders',
            plugins_url('/assets/javascripts/jquery.linkedsliders.js', Pwyw::FILE),
            array('jquery', 'jquery-ui-core', 'jquery-ui-slider'),
            '1.1.0',
            true
        );

        wp_enqueue_script(
            'pwyw-widget-checkout',
            plugins_url('/assets/javascripts/widget-checkout.js', Pwyw::FILE),
            array('pubnub', 'linked-sliders'),
            self::SCRIPT_VERSIONS,
            true
        );
    }
}
