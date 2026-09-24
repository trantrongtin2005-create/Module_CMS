
<?php
/**
 * WordPress configuration for XAMPP local development.
 */

// ** Database settings ** //
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', 'root' );
define( 'DB_HOST', 'db' );

define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

/** Authentication unique keys and salts. */
define( 'AUTH_KEY',         'edf4faef40430f6fd184190239812b384e99b6fe' );
define( 'SECURE_AUTH_KEY',  'd501191bbf5e9970d11136af87b4dc5d22063c1b' );
define( 'LOGGED_IN_KEY',    'cdc2211d057b1b0d40be3f7c3a30766d8d105ad8' );
define( 'NONCE_KEY',        '1c6b4455fa1fd8503009a40b42dd5498f443db57' );
define( 'AUTH_SALT',        '4a147f0e4144ef9a441a826fc1ee8e0de5e23b5d' );
define( 'SECURE_AUTH_SALT', '5ecf67f2eb8952061c2aa1ae50ab146391388f65' );
define( 'LOGGED_IN_SALT',   'b9fd5dcb634d0bd7aabf00f15541d12d8c048a31' );
define( 'NONCE_SALT',       'b9aa046d33b12bad4718199b8400401d44964a70' );

/** WordPress database table prefix. */
$table_prefix = 'wp_';

/** Debug mode. */
define( 'WP_DEBUG', true );

/** Local domain. */
define( 'WP_HOME', 'http://wordpress.local' );
define( 'WP_SITEURL', 'http://wordpress.local' );

/* That's all, stop editing! */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
