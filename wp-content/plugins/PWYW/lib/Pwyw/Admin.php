<?php

class Pwyw_Admin
{
    /** Holds the class instance */
    private static $instance = false;

    /** Singleton class */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** Singleton Constructor */
    private function __construct()
    {
        $this->handlePostData();
    }

    /**
     * Handles form submissions.
     */
    private function handlePostData()
    {
        if (isset($_REQUEST['action'])) {
            $pwyw = Pwyw::getInstance();
            switch ($_REQUEST['action']) {
                case 'edit':
                    $pwyw->pwyw_edit_bundle();
                    break;
                case 'create':
                    $pwyw->pwyw_create_bundle();
                    break;
            }
        }

        // var_dump($_POST);
        // die;
    }
}
