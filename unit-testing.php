<?php
/**
 * Plugin Name:       Unit Testing
 * Plugin URI:        https://example.com/unit-testing
 * Description:       A demo plugin for testing WordPress plugin development initialization workflow.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      8.1
 * Author:            Your Name
 * Author URI:        https://example.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       unit-testing
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 */
define( 'UNIT_TESTING_VERSION', '1.0.0' );

/**
 * Plugin directory path.
 */
define( 'UNIT_TESTING_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Plugin directory URL.
 */
define( 'UNIT_TESTING_URL', plugin_dir_url( __FILE__ ) );

/**
 * Composer autoloader.
 */
if ( file_exists( UNIT_TESTING_PATH . 'vendor/autoload.php' ) ) {
	require_once UNIT_TESTING_PATH . 'vendor/autoload.php';
}

/**
 * The code that runs during plugin activation.
 */
function activate_unit_testing() {
	// Activation code here
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'activate_unit_testing' );

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_unit_testing() {
	// Deactivation code here
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'deactivate_unit_testing' );

/**
 * Initialize the plugin.
 */
function run_unit_testing() {
	// Initialize plugin components
	if ( class_exists( 'UnitTesting\Plugin' ) ) {
		$plugin = new UnitTesting\Plugin();
		$plugin->run();
	}
}
add_action( 'plugins_loaded', 'run_unit_testing' );
