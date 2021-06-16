<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
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
define( 'DB_NAME', 'my_db' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?95f~?rmnd!kHOFB`H](+P0VHB7-QO:CHfjB KGFoeX%X QrW};)h%&Uzag 5e<u' );
define( 'SECURE_AUTH_KEY',  '-[XeJI 04Yk<e$5cP$}ZrKaru@bZl6-!OX P6e30A}NoB&(3O;@<1MmXDqH(XRSP' );
define( 'LOGGED_IN_KEY',    '@-S<wjW|?Rk=q*@P*AgN*R*`zR9t:0MFwU+<4H|oYK-9,{;e3$.p4E:]Vq#rABi8' );
define( 'NONCE_KEY',        'H;mVIp.(QD1CbI-+sX<Y$=mix?nM>+u8F%Nb@h&yup[JTY%eN*s.SxkDNn/x0t8L' );
define( 'AUTH_SALT',        'DU$1K1F#$*IvN/A)(XCRwa.qeOyeo3qc2<;kow?#G$bSNhdGPS`L8rt%cq`4O[hv' );
define( 'SECURE_AUTH_SALT', '<F90cp^/8(Udkkn,RU(;g2^Z1*PZ%kTTrk@@7Xx,7+zO6fAvD-:AQ5X*.DLXRQZP' );
define( 'LOGGED_IN_SALT',   'n ,bA$i.D$N6Q^`L7UM<_@E(s|iKzw-+.#TIH|B-lQ3`K6pVh`Q5cI/!c|_fvk{#' );
define( 'NONCE_SALT',       '*vq/3](6Zh0OBAN#XsgQ7}(cr^z7z$wOlS4i?DN1pT[n:]s{&(fLrMM?$.WN[wF3' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
