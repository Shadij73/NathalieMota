<?php
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
define( 'DB_NAME', 'nathalie-mota' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'Q>xgHADpWOW5J84guME8wI>3HXowC~$/Qko~46JB_}+WIi4P:5aapNoG/LGRl;&l' );
define( 'SECURE_AUTH_KEY',  '3`qJ]y9K]NFN-9brp*T?=HSzPh_7^psgPT=VLs.XV46Hi{HF*6xu@*mBtbvjGJp6' );
define( 'LOGGED_IN_KEY',    '8//NW6BWg zg!qR+/9Osmr>Lr.sf7^>S2o1v/(4JVJt*W#Oc!D:muRXfUikY]zC%' );
define( 'NONCE_KEY',        'o!+I7%I~@!F0~`Gzx,/k&X#x~~xb)ba/oQ3X$t%`<Xa95SEUp.-w,j3$&6@g/v/I' );
define( 'AUTH_SALT',        'yH*sm!m>*BgbdsA)<VCwQW(dM MJBj]N3:5JhvC6k$Nj8#5E6O}N)Y4mmVETYAb2' );
define( 'SECURE_AUTH_SALT', 'oS4QghM9Lh_l1>kX;YJoGr !spUE<W}`Ws;/AubJ,v8Vko7kL5?yh,$tGw-XU=)x' );
define( 'LOGGED_IN_SALT',   'fR_CFq+LTA[:;dk}x<E3|]e=]46`*KP&o3J}UtJU(H21_UKw`VLV@Xg]yzF5kss=' );
define( 'NONCE_SALT',       's,2ReR?FX*Zg2BCPm&BYe1-At} av:&U<vd5jQJuWWgh0rd1. giA3j2 JZ_2,5c' );

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
