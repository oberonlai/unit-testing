<?php
/**
 * Main Plugin Class
 *
 * @package UnitTesting
 */

namespace UnitTesting;

/**
 * Class Plugin
 *
 * Main plugin class that initializes all components.
 */
class Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var Plugin
	 */
	private static $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Initialize components
	}

	/**
	 * Run the plugin.
	 */
	public function run() {
		// Register hooks
		add_action( 'init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_admin_menu' ) );
		
		// Initialize demo module
		$demo = new Demo();
		$demo->init();
	}

	/**
	 * Initialize plugin.
	 */
	public function init() {
		// Load text domain
		load_plugin_textdomain(
			'unit-testing',
			false,
			dirname( plugin_basename( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Add admin menu.
	 */
	public function add_admin_menu() {
		add_menu_page(
			__( 'Unit Testing', 'unit-testing' ),
			__( 'Unit Testing', 'unit-testing' ),
			'manage_options',
			'unit-testing',
			array( $this, 'render_admin_page' ),
			'dashicons-admin-generic',
			30
		);
	}

	/**
	 * Render admin page.
	 */
	public function render_admin_page() {
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<p><?php esc_html_e( 'Welcome to Unit Testing plugin!', 'unit-testing' ); ?></p>
			
			<h2><?php esc_html_e( 'Demo Features', 'unit-testing' ); ?></h2>
			<ul>
				<li><?php esc_html_e( 'Custom shortcode: [unit_testing_demo]', 'unit-testing' ); ?></li>
				<li><?php esc_html_e( 'Custom widget available in Appearance > Widgets', 'unit-testing' ); ?></li>
				<li><?php esc_html_e( 'REST API endpoint: /wp-json/unit-testing/v1/demo', 'unit-testing' ); ?></li>
			</ul>
		</div>
		<?php
	}
}
