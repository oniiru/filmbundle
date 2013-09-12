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
    const BUNDLES   = 'bundles';

    /** Track the installed DB version */
    const OPTION_KEY = 'pwyw_db_version';

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
      	  	altimage VARCHAR(255) NOT NULL,
			
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
        linkedpage VARCHAR(255) NOT NULL,

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

        // Set the DB version as 1.0.
        update_option(self::OPTION_KEY, '1.0');
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

    /**
     * Upgrade database.
     */
    public static function upgrade()
    {
        $option = 'pwyw_db_version';
        $version = get_option($option);

        if (version_compare('1.1', $version, '>')) {
            self::migrateTo11();
            update_option(self::OPTION_KEY, '1.1');
        }

        if (version_compare('1.2', $version, '>')) {
            self::migrateTo12();
            update_option(self::OPTION_KEY, '1.2');
        }

        if (version_compare('1.3', $version, '>')) {
            self::migrateTo13();
            update_option(self::OPTION_KEY, '1.3');
        }

        if (version_compare('1.4', $version, '>')) {
            self::migrateTo14();
            update_option(self::OPTION_KEY, '1.4');
        }

        if (version_compare('1.5', $version, '>')) {
            self::migrateTo15();
            update_option(self::OPTION_KEY, '1.5');
        }

        if (version_compare('1.6', $version, '>')) {
            self::migrateTo16();
            update_option(self::OPTION_KEY, '1.6');
        }
    }

    /**
     * Database migrations.
     */
    public static function migrateTo11()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $prefix.self::FILMS;

        $sql =
            "ALTER TABLE {$table}
                CHANGE note filmmaker_note  TEXT NOT NULL,
                ADD COLUMN  filmmaker_image VARCHAR(255) AFTER filmmaker_note,
                ADD COLUMN  filmmaker_name  VARCHAR(255) AFTER filmmaker_image,
                ADD COLUMN  curator_note    TEXT         AFTER filmmaker_name,
                ADD COLUMN  curator_image   VARCHAR(255) AFTER curator_note,
                ADD COLUMN  curator_name    VARCHAR(255) AFTER curator_image
            ;";
        $wpdb->query($sql);
    }

    public static function migrateTo12()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $prefix.self::BUNDLES;

        $sql =
            "ALTER TABLE {$table}
                ADD COLUMN description TEXT AFTER title
            ;";
        $wpdb->query($sql);
    }

    public static function migrateTo13()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $prefix.self::BUNDLES;

        $sql =
            "ALTER TABLE {$table}
                ADD COLUMN bg_image VARCHAR(255) NOT NULL AFTER description
            ;";
        $wpdb->query($sql);
    }

    public static function migrateTo14()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $charities = $prefix.self::CHARITIES;
        $features = $prefix.self::FEATURES;

        $sql =
            "ALTER TABLE {$charities}
                ADD COLUMN url VARCHAR(255) NOT NULL AFTER image
            ";
        $wpdb->query($sql);

        $sql =
             "ALTER TABLE {$features}
                ADD COLUMN runtime VARCHAR(255) NOT NULL AFTER subtitle
            ;";
        $wpdb->query($sql);
    }

    public static function migrateTo15()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $prefix.self::BUNDLES;

        $sql =
            "ALTER TABLE {$table}
                ADD COLUMN end_time DATETIME AFTER bg_image
            ;";
        $wpdb->query($sql);
    }

    public static function migrateTo16()
    {
        global $wpdb;
        $prefix = $wpdb->prefix.'pwyw_';
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        $table = $prefix.self::FILMS;

        $sql =
            "ALTER TABLE {$table}
                ADD COLUMN sort INT DEFAULT 0 AFTER bundle_id,
                ADD COLUMN meta TEXT NOT NULL
            ;";
        $wpdb->query($sql);
    }
}
