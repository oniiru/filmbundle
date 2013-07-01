<?php
/**
 * Static Database Class.
 */
class Pwyw_Database
{
    /** Table names */
    const CHARITIES = 'charities';

    /** Make the class static */
    private function __construct()
    {
    }

    /**
     * Creates the tables.
     */
    public static function createTables()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $prefix.self::CHARITIES;

        $sql =
        "CREATE TABLE IF NOT EXISTS `$table` (
            id INT AUTO_INCREMENT NOT NULL,
            bundle_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            image VARCHAR(255) NOT NULL,
            embed TEXT NOT NULL,
            description TEXT NOT NULL,
            PRIMARY KEY id (id)
        );";
        dbDelta($sql);
    }

    /**
     * Drops the tables, to use for uninstall.
     */
    public static function dropTables()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        $table = $prefix.self::CHARITIES;

        $sql = "DROP TABLE IF EXISTS $table;";

        $wpdb->query($sql);
    }
}
