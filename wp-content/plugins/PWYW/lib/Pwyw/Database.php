<?php
/**
 * Static Database Class.
 */
class Pwyw_Database
{
    /** Table names */
    const CHARITIES = 'charities';
    const FILMS     = 'films';
    const REVIEWS   = 'reviews';
    const FEATURES  = 'features';

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

        $table = $prefix.self::FILMS;
        $sql =
        "CREATE TABLE IF NOT EXISTS `$table` (
            id INT AUTO_INCREMENT NOT NULL,
            bundle_id INT NOT NULL,
            title VARCHAR(255) NOT NULL,
            image VARCHAR(255) NOT NULL,
            rating VARCHAR(255) NOT NULL,
            embed TEXT NOT NULL,
            logline TEXT NOT NULL,
            genre VARCHAR(255) NOT NULL,
            runtime VARCHAR(255) NOT NULL,
            director VARCHAR(255) NOT NULL,
            writers VARCHAR(255) NOT NULL,
            stars VARCHAR(255) NOT NULL,
            website VARCHAR(255) NOT NULL,
            note TEXT NOT NULL,
            user_reviews TINYINT(1) NOT NULL,
            PRIMARY KEY id (id)
        );";
        dbDelta($sql);

        $table = $prefix.self::REVIEWS;
        $sql =
        "CREATE TABLE IF NOT EXISTS `$table` (
            id INT AUTO_INCREMENT NOT NULL,
            film_id INT NOT NULL,
            review TEXT NOT NULL,
            author VARCHAR(255) NOT NULL,
            publication VARCHAR(255) NOT NULL,
            image VARCHAR(255) NOT NULL,
            link VARCHAR(255) NOT NULL,
            PRIMARY KEY id (id)
        );";
        dbDelta($sql);

        $table = $prefix.self::FEATURES;
        $sql =
        "CREATE TABLE IF NOT EXISTS `$table` (
            id INT AUTO_INCREMENT NOT NULL,
            film_id INT NOT NULL,
            image VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255) NOT NULL,
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
        $table1 = $prefix.self::CHARITIES;
        $table2 = $prefix.self::FILMS;
        $table3 = $prefix.self::REVIEWS;
        $table4 = $prefix.self::FEATURES;

        $sql = "DROP TABLE IF EXISTS {$table1}, {$table2}, {$table3}, {$table4};";
        $wpdb->query($sql);
    }
}
