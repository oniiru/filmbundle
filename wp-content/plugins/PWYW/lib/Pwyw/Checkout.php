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
        $this->checkout();
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

        var_dump($_POST);

        var_dump('We have a checkout...');
        die;
    }
}
