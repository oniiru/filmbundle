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
    }
}
