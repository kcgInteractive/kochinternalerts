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
define('DB_NAME', 'i1890639_wp8');

/** MySQL database username */
define('DB_USER', 'i1890639_wp8');

/** MySQL database password */
define('DB_PASSWORD', 'A.(499mEv@~RkpiDOY&31&#9');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'T5YcxJzd2LoQL602mBZG2WTV7QJ8EHibns2HVP7ub0eDcikuqvmqHlJ1a4X3wxnr');
define('SECURE_AUTH_KEY',  'elN0hy9Xud5iO2NILE1deO6N9UTVAj3zKBUcYM1EM45GepEmvjLEdNYDbjBWImsl');
define('LOGGED_IN_KEY',    'RWUOuirlwSyoqpwdzWElab4KmAEAlKUNVldTNTa8N0LbOsiTjjJGEFE7zHMIwJDB');
define('NONCE_KEY',        'VZOOOi2rWtQHDNKkShjXvI4uGMRdKNXoWPhag3c2b6zBJStKkrfAubYJLoHU8vIq');
define('AUTH_SALT',        'lMEJYiC9kSEapEUDOPZk4yHa5BpSbHjyAh07wpPhLmMq5dMGcMffI2vkE88o9H1h');
define('SECURE_AUTH_SALT', 'EJQaPbyK6rzeWpfanQ8xZ165CVUWhqRjE9jk0oyZYM0vZPCo3S0ia57Oy4jryl5q');
define('LOGGED_IN_SALT',   'qfb6mVpw1NBgnWveL2WfabkUOn3R1YYK6yPHws7DVTaLpY5ilm51IRueWX6ipeTE');
define('NONCE_SALT',       'JS2eUa8Tdxjp9SrE7pAFNCW2JOJuZzMIKpXSUF3xvdXz9LcwMUUTHMeB7GK7bjHH');

/**
 * Other customizations.
 */
define('FS_METHOD','direct');define('FS_CHMOD_DIR',0755);define('FS_CHMOD_FILE',0644);
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');

/**
 * Turn off automatic updates since these are managed upstream.
 */
define('AUTOMATIC_UPDATER_DISABLED', true);


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
