<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'passwork' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'l%FW).F{tH2@ciS#*#Zk5O7*D/0~*o.{<ok8!U_rN+_|$JQ~kG`J]YC@GZ)3R7#!' );
define( 'SECURE_AUTH_KEY',  '+.*hsltbZ2L,78(~X&EEet8O*E3Rw_v%vwDMrKIw>+me%9>l;8SROuh0.mG{Mwen' );
define( 'LOGGED_IN_KEY',    'E.]5aIo%MKu)TA~uw5hEW50wZ,]*3;sH:j->p/^#Ao]t&I?v7|+M-;$YsLvQCHgP' );
define( 'NONCE_KEY',        '&:i+vJ{=sn.562bA;j}5hrb;WhZ+I&zPB^t+]pD|g;;T;U&V39(^&nY;CMU~@Km&' );
define( 'AUTH_SALT',        '$Ih.6`F9{$rM$&s~|_AHY;VV0kh.$T<rWC9TJLEprI0kBlq.ya0Wa]q]$}7^l};&' );
define( 'SECURE_AUTH_SALT', 'kUGBmMOC_)Oj}JO7rRxupK]nYSK=Fq/mR<l^#oQKqv(v$P(O*A^J 8zF6Z+*H,e&' );
define( 'LOGGED_IN_SALT',   '7^zeU=KzUEHV>N+)9]XV0n}Qej+9Z62>b~Jw@Fyp%&jQTP#fxVAFaOba9$Aj9t><' );
define( 'NONCE_SALT',       'DSig~JnnQ2yvow)/5&&(>kzqS-Apo/XP@dd<}d|>m)M+$7,v]b0J&BcXe&Fc#9!^' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
