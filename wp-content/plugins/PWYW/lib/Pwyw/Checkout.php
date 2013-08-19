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
    }
}
