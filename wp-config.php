<?php

if(file_exists(ABSPATH.'wp-env.php')){
    require_once (ABSPATH.'wp-env.php');
}

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
define( 'DB_NAME', 'vinaweb_ken' );

/** MySQL database username */
define( 'DB_USER', 'vinaweb_test' );

/** MySQL database password */
define( 'DB_PASSWORD', 'Test@12345' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/** MySQL hostname */
define( 'DEV_ENVIRONMENT', true );

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
define('AUTH_KEY',         '-LnP42be<=q;]*S%|W>BkOg &c^c][IGr/ZV=9_/I?P8^i?bczUbL>)`t^./]d-d');
define('SECURE_AUTH_KEY',  ',r}s>P.o7V69UP}vvM[2qMzKvuxysGL2W?-y@_ G7|Ekp,8yy0xB?O-O7m-9&Vqw');
define('LOGGED_IN_KEY',    '-pNqn5|:|GeH@.UmSzmHfCwPbC+nDLyMA^&^>hill?S}o-}(|X}sH%|NHK;I7%}-');
define('NONCE_KEY',        '68F()Ns`UdE;y[?|G41kzp*=jj!|q`eX0<v 4$+_7C#$m2n&NQ( ]+lK^:MN5%E(');
define('AUTH_SALT',        'E3v*0V6GV!lC&<3UXhwz6(C|)/,A!=Y^aLuyK|ydR0I)sJ4+hiB&7/{v=^I5]$fO');
define('SECURE_AUTH_SALT', ':sc_>[.l^h@K4$.^N2Hj5?f|-J<oC|Q$J,|7Gs *4u++-qtn:6AoESE>HS$4S)El');
define('LOGGED_IN_SALT',   '::UMduo894w.a^cwdG.^0Sw8t2=dW<B}CK0i|-g]0iY+}6/w*sMk.wYer<icV*P#');
define('NONCE_SALT',       'x!$,|{JRJgjaHc!]YWz~PI-!tlK<o,c+(e>n;%:F83p0!{^wXKU}DOU@LW&#JH7 ');

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

define('WP_ALLOW_REPAIR', true);
