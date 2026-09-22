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
define( 'DB_NAME', 'wordpress_NguyenThiNhi' );

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
define( 'AUTH_KEY',         '`!eA1^YSDhb~f}Y6->ilzc{uGDmEf.Ku~x9hXn>S%K4XG?zRKw+P3pmx9 rw(id-' );
define( 'SECURE_AUTH_KEY',  '(`L07UQZ+#.,4fX7&%*ZP.01`:V(ayx(z5#+A<L73BERUAx];_BTiGbq^eU>}Bz#' );
define( 'LOGGED_IN_KEY',    '~8^7[67/A.4F?&/Yy&exj^R$n zg.Eg*(H.7oyhSta>-S3oI5e<}3.wmI`_(;}EA' );
define( 'NONCE_KEY',        'E?1RA(>,yVfo[FGm5vJKOF[>s qweM^!7tJ7,[&P<hsDh+c8pI,iiZ_?#/$8]DuC' );
define( 'AUTH_SALT',        'GH.!_L8Ic&f_*`/Sq]bH51K.>1%9>Fo&`[lNxJD2tm%6foNk~8ifbJDIPp^yaQ} ' );
define( 'SECURE_AUTH_SALT', 'mAz0E(RV69Y,[)RYU(8u4oPzg3Pj{rlO>_R,rdp2L<$Up>C@eu.*%@|IR^Qki+@k' );
define( 'LOGGED_IN_SALT',   'XkvR2D BquCPkIG<v=7+A/B>V$&BNrE/3lR]itzWOvI$G2UDh$rc5,Xc1WH_d?:.' );
define( 'NONCE_SALT',       's%KW]s0A2%F.2}Qxo!Bn9.J9pfv]#/e;w?62^li&Xhv>.vrx(;*y%ATUT;dz- 7X' );

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

if ( isset( $_SERVER['HTTP_HOST'] ) ) {
	$schema = ( isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
	define( 'WP_HOME', $schema . $_SERVER['HTTP_HOST'] );
	define( 'WP_SITEURL', $schema . $_SERVER['HTTP_HOST'] );
} else {
	define( 'WP_HOME', 'http://wordpress.local' );
	define( 'WP_SITEURL', 'http://wordpress.local' );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
