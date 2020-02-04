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
define( 'DB_NAME', 'kelvin_grove' );

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
define( 'AUTH_KEY',         '-=%?Al:EELozu|*>yX.h>hvaCT_#&cVDgZPk.`YNW;9;r>n2:Q]q0,4!O7!8{3hj' );
define( 'SECURE_AUTH_KEY',  'S|eIV>[7uZqdv?fw<`>Iu5LU]t_cnATls`98]jbgd{>R(cqp0lOK-#UL31EVRoiL' );
define( 'LOGGED_IN_KEY',    'k(>*aSTTzT C)N6UX$IZIOd6,IBp@UBkU0qnHWtbdd4v5qShoK5XXR)z#Kw-R%C_' );
define( 'NONCE_KEY',        '*=%lY[h=& mUC)_Uw9GU;D3%v:h;6;/-xK-9{ed=,kPA{JsuI7oE1%l;u+bso}:#' );
define( 'AUTH_SALT',        '`%EV(wwBjE/).Bl YyskI1n),Ci$:$XV<?T[xA|w1.u`~=C ?xm&w]GWWl,JvL?4' );
define( 'SECURE_AUTH_SALT', 'z~bikia)vS9E0@aTI%-bn+#6TYQe^v;6.G.qPE^1*o}rUM}-_~`qAjO~IyF_5/[0' );
define( 'LOGGED_IN_SALT',   '7fU_NG(<G#bgkb28UpT&=}I_}yDLLo~kFj.W;,fJ/C]b9kEG/K!Y[o>n*W=yEmDM' );
define( 'NONCE_SALT',       '/^s@=V{f5)gu&ph@%P^<._V+!4%%d3AU*]bk)Uj3J>4DORe}uTJJ~r`SEY`.8fp;' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpkg_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );
