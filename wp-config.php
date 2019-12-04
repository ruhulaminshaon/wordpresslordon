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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpresslordon');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         ';JfNS1{:dFg(A{8JeiJACU.9)7=(w.cn|$-GmCTY{!)d76X`$iYeruM&,K!2*>So');
define('SECURE_AUTH_KEY',  '{Vy*G%&+jd[IWpsHHyRp^J:_nS7P+q9yxvZ^9:-d*Gx/t[LNn{,pwM:@G#8WHD^3');
define('LOGGED_IN_KEY',    'xViR9Y>r*JwG.iv+T9y.@}mi=C&3[YxEIqq(NK7vH^jRY[5l2~]7/~;TOB`#wTvR');
define('NONCE_KEY',        '{I%4}rUCAaE;~dgm7CcF4:.NhP0x@u.qM3Ip?EaQ~.aTI4|4%,3ot%4v3c]W^ZtX');
define('AUTH_SALT',        ' Fu ,d/+ w$y81:8prCU@4O-LCL|AW6aci3Y<Xaau,EH_(_&?Q/1G%5TI^Ub-Gy2');
define('SECURE_AUTH_SALT', 'Gq9;q nW>TK&Rp(EI8]2|?b4,GW/EbzW0z3R{{UC]Ll)Cx=55#/]M#%|FMNw8)TW');
define('LOGGED_IN_SALT',   'g}ON1|dw/O@[c?+6]/+D3_o6&a(fT/7dj#`~T^|`[Z2tH]40#EF0Ot(OD>Wgxgt,');
define('NONCE_SALT',       'fY$Sj2B)Z4{Q[#_oHM,,Xw)u<Ww-EXc/^zT@]L^4{&amvZ}7^uR!9o1p4*[[ng/!');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
