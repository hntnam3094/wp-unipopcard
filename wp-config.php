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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hoangva1_kennguyen' );

/** MySQL database username */
define( 'DB_USER', 'hoangva1_kennguyen' );

/** MySQL database password */
define( 'DB_PASSWORD', '113114115@' );

/** MySQL hostname */
define( 'DB_HOST', '45.252.250.36' );

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
define( 'AUTH_KEY',         'Kia. <fe{Ax3H<,gM@U[0s_F,H{BiqerQwqq,[ZmzQ%Uv8td4LED?-^c#C#3M>47' );
define( 'SECURE_AUTH_KEY',  '^zh8HFG`uLpgFP>>)wn{6uc]A)}s*jf.4@kqX.w90s^!|[(kka6D|*}43pP!Q,|{' );
define( 'LOGGED_IN_KEY',    'D.+;mY~D{CC1,g(890 bl4[r0AQC(;wLWVG|FXas<^KUWc>|t3{D)h0?@ NAjPu5' );
define( 'NONCE_KEY',        ',A7UI`EGS*Ti)EuWlisg&k)NFHytv1M(&J%&5-}7eH6FrA@U!G*3&L;H+QQM2;bE' );
define( 'AUTH_SALT',        '?T*T>c.ZPJ9^zru4rEUrteXOqN5n[6@r ~3zKL Bf/}V|0l2L!]X|L}1fO+l9RD_' );
define( 'SECURE_AUTH_SALT', '`m8X,DW|C+ai/.d(Wn<MuXops=m[.!*cs]oRYj?s4vNwgXUDdz&KmV{ahYpYD`$d' );
define( 'LOGGED_IN_SALT',   'H!EYhA)-~#r[l7s5A_w(%rj}C**{`Pmm,EHnMA{*[sqYp.%#) P,Jc{.QpP-M51D' );
define( 'NONCE_SALT',       '8LgGy8(iY.SO5=eeJ4_+n8PbxlT4i~jL]5(>{O5u{&0!+u2FhBa#S7` ~=Laqo#^' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
