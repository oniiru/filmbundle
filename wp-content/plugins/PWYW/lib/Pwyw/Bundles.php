<?php
/**
 * Class to handle bundles.
 */
class Pwyw_Bundles
{
    /** Holds the class instance */
    private static $instance = false;

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
    }

    /**
     * Retrieve all available bundles in the system.
     *
     * @return object
     */
    public function all()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::BUNDLES;
        $sql = "SELECT * FROM {$table}
                ORDER BY title ASC";

        return $wpdb->get_results($sql, OBJECT);
    }
}
