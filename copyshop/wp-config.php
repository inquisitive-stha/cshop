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
define('DB_NAME', 'copyshop_db');

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
define('AUTH_KEY',         '#@fv3IB0j)^,:Epxe|u<i$*l`wVJ_3xN/c_`xF2}gbq% ttge&P}XfapHFhus}hL');
define('SECURE_AUTH_KEY',  'a@6`$vDsfVE*I.d9j=t_~c27oWsGk,^`8`d#>Pfyi>ZFe_,zv.-hVm$Wca&bUyI#');
define('LOGGED_IN_KEY',    'O>T8Un{q=]zRO<J+i~>jmDVO&E1;2V0(XDEF}_fu + g5<}YDmTZaL().[f>)y2f');
define('NONCE_KEY',        ')jZ`1x+XmW_lUug_0}>)@CR5c:$Pk ^WI6%HMTo$_Fj`x_h@wPc!jNXpf(8j%5Qd');
define('AUTH_SALT',        'CN4r_k6_>Tld%e31)uLDg$j[NkP]!+R`v1ep_MQneZ&)3f|mn*<,KVZubqe]tJ|l');
define('SECURE_AUTH_SALT', '^PC)&);-MR&W|7kf/glCwD[lwsDOqKN#F=[3t)Bi<dLSy X^~2_L6sKX{Eh0E{]_');
define('LOGGED_IN_SALT',   'Hn^:A k)m2Q$whA8Fso2l]<FvIjOr7M?ydVW*Yx4>`olYeZ9s Ri&*%9,v$c`F>*');
define('NONCE_SALT',       'W=aJ3#2R>O0dR)8?$!*Gk[pu$vqA#{r|@TKKMEG}/5Du&;LSrzp]buOMQ[1f1a]q');

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
