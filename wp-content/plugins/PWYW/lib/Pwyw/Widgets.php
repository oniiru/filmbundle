<?php
class Pwyw_Widgets
{
    /** Holds the class instance */
    protected static $instance = false;

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
        add_action(
            'widgets_init',
            function() { register_widget('Pwyw_WidgetBundles'); }
        );

        add_action('wp_enqueue_scripts', array(&$this, 'scripts'));
    }

    /**
     * Load scripts used by the widgets on the frontend.
     */
    public function scripts()
    {
        wp_enqueue_script(
            'pwyw-widget-bundle',
            plugins_url('/assets/javascripts/widget-bundle.js', Pwyw::FILE),
            array('jquery'),
            '1.0',
            true
        );
    }
}
