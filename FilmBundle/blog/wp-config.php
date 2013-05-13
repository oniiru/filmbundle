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
define('DB_NAME', 'filmbundleblog');

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
define('AUTH_KEY',         'Ec`,82Orf;NTLO#2UV]fR=,3CQ2Zv?^]?/i.Fm,dM96^||0`O+{N&+5S}U @*s7u');
define('SECURE_AUTH_KEY',  'dwukO<F[]w 4o=g.$3|4*3.geTS-g-LMsUxD_,> I5``|s=<7-wG-]{uoT xvS08');
define('LOGGED_IN_KEY',    'h@S$`|$POOaKXbojLITgxJbh#hTui@sF]rZ1BTg5(:G9vUx1!X;hU;$3L#hf6=yS');
define('NONCE_KEY',        '*U`H$CTK_@ bVJ,A%/kU4V FacE>kj7O@LfS(/RZnzLo7HHAY,c0|_/#vXi:yw$}');
define('AUTH_SALT',        '.#w({WYJ|$J5.%$evyab-0LGuiZ;N:e9%|7kO`$Lw$^.ykC16)F:(6N6A*n,z)&P');
define('SECURE_AUTH_SALT', 'h.0C&g&5tw0g`%{u|X*V=yhlbK-c<vi^/2HS,p}l&G=^h!7=$C+]I,S4eGBdb2L=');
define('LOGGED_IN_SALT',   'JfL1|wv%Igw*Tk!~SmC24SrAUq(6p(8!&pkJEu{,-:RXY[;Q{2|Xhbd{x],5/{VC');
define('NONCE_SALT',       '0 Vo|_Pho0Rrzd- qOS3piWU#_s+rz|H7|Kb|3p/y:pY[}59TC|n%Ae!Jo Z7_e<');

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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
