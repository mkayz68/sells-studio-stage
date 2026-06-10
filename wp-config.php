<?php

// BEGIN Solid Security - Do not modify or remove this line
// Solid Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END Solid Security - Do not modify or remove this line

define( 'ITSEC_ENCRYPTION_KEY', 'S31CRkRuMEFtcnckLE9iX0p4KlF8IXc8aypwWVBENHhSWXI7e3BSIGxoO0ErciNeMGtvTkN7aHR0W2dWWjo1KQ==' );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'sells_studio' );
// define( 'DB_NAME', 'ex2f45_sells_studio' );

/** Database username */
define( 'DB_USER', 'root' );
// define( 'DB_USER', 'ex2f45_k_burdlof' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );
// define( 'DB_HOST', 'ex2f45.myd.infomaniak.com' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'WF|0#QhLqff$>kt~d:n;o-nA21X4AGnND{H<4S|Sda 0nQ@?V=p+=2}zA(s^OT%E' );
define( 'SECURE_AUTH_KEY',  'T{ |Aj>LGOKuCc8kZ3r^pU;W4Hb7bp7|j2>5!OkoTW9 cW5JRdAh!H%dy<MgaX~}' );
define( 'LOGGED_IN_KEY',    '4t$0<$K,=:c:}l>@7wra3owfpCDdo2(prepFXNOP~mP^<sz_zb-S;sxk7ZM;?r{Q' );
define( 'NONCE_KEY',        '*a&vZC^)|1:/?RLx_$172#wr}F=2A>pv>E~Nu]+^>cm*qtcBu=:A.~xdKS{=J,?*' );
define( 'AUTH_SALT',        'h|~l=;@p&D?Wd*J$bs,25We2b<9<HC4#%N|.6XnbQ{/TzFf%+~7l)mTos]%y:NC`' );
define( 'SECURE_AUTH_SALT', '7Dsb0I*7OM11Y&y>[^(:=gJ%.Qv9Z&nfp:v12@Xuqag-LB1er;q&U}E(b7L0ZmP<' );
define( 'LOGGED_IN_SALT',   '=+4(v_}v*+/b0tFLkAzSoL0:9R~s!u|~c7`0,D5|N1$SKQg)[tUvV];~2]2S7h+u' );
define( 'NONCE_SALT',       '9$o$>m9p,4r)_}x|iT]xGv%,:UX4~g^Yrf5&YlWXG(JNtd>>Ao#pk!GI1QQ6[(5T' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
