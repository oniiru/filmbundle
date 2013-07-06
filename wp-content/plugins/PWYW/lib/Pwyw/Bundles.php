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

    /**
     * Get the activated bundle, include all films, film meta and charities
     * associated with the bundle.
     *
     * @return object
     */
    public function getActiveBundle()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.Pwyw_Database::BUNDLES;
        $sql = "SELECT * FROM {$table}
                WHERE activated = 1";

        $bundle = $wpdb->get_row($sql, OBJECT);

        // Now let's collect all movies associated with the bundle
        $table = $prefix.Pwyw_Database::FILMS;
        $sql = "SELECT * FROM {$table}
                WHERE bundle_id = {$bundle->id}";

        $films = $wpdb->get_results($sql, OBJECT);

        // Insert the films object in the bundle object
        $bundle->films = $films;

        return $bundle;
    }
}
