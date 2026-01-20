<?php
/**
 * Demo Module
 *
 * @package UnitTesting
 */

namespace UnitTesting;

/**
 * Class Demo
 *
 * Demonstrates various WordPress plugin features.
 */
class Demo {

	/**
	 * Initialize demo module.
	 */
	public function init() {
		// Register shortcode
		add_shortcode( 'unit_testing_demo', array( $this, 'render_shortcode' ) );
		
		// Register REST API endpoint
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
		
		// Register custom post type
		add_action( 'init', array( $this, 'register_post_type' ) );
	}

	/**
	 * Render shortcode.
	 *
	 * @param array $atts Shortcode attributes.
	 * @return string
	 */
	public function render_shortcode( $atts ) {
		$atts = shortcode_atts(
			array(
				'title' => __( 'Demo Title', 'unit-testing' ),
				'content' => __( 'This is a demo shortcode from Unit Testing plugin.', 'unit-testing' ),
			),
			$atts,
			'unit_testing_demo'
		);

		ob_start();
		?>
		<div class="unit-testing-demo">
			<h3><?php echo esc_html( $atts['title'] ); ?></h3>
			<p><?php echo esc_html( $atts['content'] ); ?></p>
			<p><em><?php esc_html_e( 'Generated at:', 'unit-testing' ); ?> <?php echo esc_html( current_time( 'mysql' ) ); ?></em></p>
		</div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Register REST API routes.
	 */
	public function register_rest_routes() {
		register_rest_route(
			'unit-testing/v1',
			'/demo',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_demo_data' ),
				'permission_callback' => '__return_true',
			)
		);
	}

	/**
	 * Get demo data via REST API.
	 *
	 * @param \WP_REST_Request $request Request object.
	 * @return \WP_REST_Response
	 */
	public function get_demo_data( $request ) {
		$data = array(
			'message' => __( 'Hello from Unit Testing plugin!', 'unit-testing' ),
			'version' => UNIT_TESTING_VERSION,
			'time'    => current_time( 'mysql' ),
		);

		return rest_ensure_response( $data );
	}

	/**
	 * Register custom post type.
	 */
	public function register_post_type() {
		$labels = array(
			'name'               => __( 'Demo Items', 'unit-testing' ),
			'singular_name'      => __( 'Demo Item', 'unit-testing' ),
			'menu_name'          => __( 'Demo Items', 'unit-testing' ),
			'add_new'            => __( 'Add New', 'unit-testing' ),
			'add_new_item'       => __( 'Add New Demo Item', 'unit-testing' ),
			'edit_item'          => __( 'Edit Demo Item', 'unit-testing' ),
			'new_item'           => __( 'New Demo Item', 'unit-testing' ),
			'view_item'          => __( 'View Demo Item', 'unit-testing' ),
			'search_items'       => __( 'Search Demo Items', 'unit-testing' ),
			'not_found'          => __( 'No demo items found', 'unit-testing' ),
			'not_found_in_trash' => __( 'No demo items found in trash', 'unit-testing' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'demo-item' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'menu_position'      => 20,
			'menu_icon'          => 'dashicons-star-filled',
			'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
			'show_in_rest'       => true,
		);

		register_post_type( 'demo_item', $args );
	}

	/**
	 * Get greeting message.
	 *
	 * @param string $name Name to greet.
	 * @return string
	 */
	public function get_greeting( $name = 'World' ) {
		return sprintf(
			/* translators: %s: name */
			__( 'Hello, %s!', 'unit-testing' ),
			$name
		);
	}

	/**
	 * Calculate sum of two numbers.
	 *
	 * @param int|float $a First number.
	 * @param int|float $b Second number.
	 * @return int|float
	 */
	public function calculate_sum( $a, $b ) {
		return $a + $b;
	}

	/**
	 * Check if user has permission.
	 *
	 * @param int $user_id User ID.
	 * @return bool
	 */
	public function check_user_permission( $user_id ) {
		$user = get_user_by( 'id', $user_id );
		
		if ( ! $user ) {
			return false;
		}

		return user_can( $user, 'manage_options' );
	}
}
