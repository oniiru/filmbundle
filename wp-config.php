<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'FilmBundle');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'XXhV7S3cw2OyVSVBMUYscZ8tTtCJn6YJHPTtrEFbosGf36taPd9ZAOInc8PsOPc3');
define('SECURE_AUTH_KEY',  'H5tbjuaZr46yObu2Jca5k2C8XUHUi6Vwm6EJ0CiT3aIoKAS6e1acaoS4d6nC2ft8');
define('LOGGED_IN_KEY',    'PVXO4IDQ3K8Be6QgZbY9PX8IecXq62rG2lOGtxbtlkMyDbmKAkaT3fShQbTiYf5I');
define('NONCE_KEY',        'DgzvCi9BE2d26oQjlmkmY1ppTZrvbkL7mZcpNp7DOk8qAyA6Ats5d4yZS357C5qG');
define('AUTH_SALT',        'wHhT3qhI7fGabVJvEdOEEjKIAXekVqDd4WITlofwZXbCAPYnPBFE1YAv2N2Bpuqn');
define('SECURE_AUTH_SALT', 'eoPKlWhig9LKia8PwUFnLURRhCeELej7YdlaLITVK1Dbf9vKwBNDxl0eFg5z9mxv');
define('LOGGED_IN_SALT',   'iBQFd0b1EkWGiSQ9lzz92uzT7kVF67DBX1qz6FPG2vm9921AnLPDxbfMLcJn2cbU');
define('NONCE_SALT',       'xIZurGVpakOWp6iZnRTtE4nnelsHHxdll3Hi0Ne6vqFuSwO7CIzCSYBTmLnasxFw');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);
ini_set('display_errors', 1);error_reporting(E_ALL);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
