<?php
/**
 * Class DemoTest
 *
 * @package Unit_Testing
 */

/**
 * Demo module test case.
 */
class DemoTest extends WP_UnitTestCase {

	/**
	 * Demo instance.
	 *
	 * @var \UnitTesting\Demo
	 */
	private $demo;

	/**
	 * Set up test.
	 */
	public function setUp(): void {
		parent::setUp();
		$this->demo = new \UnitTesting\Demo();
	}

	/**
	 * Test get_greeting method with default parameter.
	 */
	public function test_get_greeting_default() {
		$result = $this->demo->get_greeting();
		$this->assertEquals( 'Hello, World!', $result );
	}

	/**
	 * Test get_greeting method with custom name.
	 */
	public function test_get_greeting_custom_name() {
		$result = $this->demo->get_greeting( 'John' );
		$this->assertEquals( 'Hello, John!', $result );
	}

	/**
	 * Test get_greeting method with empty string.
	 */
	public function test_get_greeting_empty_string() {
		$result = $this->demo->get_greeting( '' );
		$this->assertEquals( 'Hello, !', $result );
	}

	/**
	 * Test calculate_sum with positive numbers.
	 */
	public function test_calculate_sum_positive_numbers() {
		$result = $this->demo->calculate_sum( 5, 3 );
		$this->assertEquals( 8, $result );
	}

	/**
	 * Test calculate_sum with negative numbers.
	 */
	public function test_calculate_sum_negative_numbers() {
		$result = $this->demo->calculate_sum( -5, -3 );
		$this->assertEquals( -8, $result );
	}

	/**
	 * Test calculate_sum with mixed numbers.
	 */
	public function test_calculate_sum_mixed_numbers() {
		$result = $this->demo->calculate_sum( 10, -3 );
		$this->assertEquals( 7, $result );
	}

	/**
	 * Test calculate_sum with zero.
	 */
	public function test_calculate_sum_with_zero() {
		$result = $this->demo->calculate_sum( 0, 5 );
		$this->assertEquals( 5, $result );
	}

	/**
	 * Test calculate_sum with floats.
	 */
	public function test_calculate_sum_with_floats() {
		$result = $this->demo->calculate_sum( 1.5, 2.3 );
		$this->assertEquals( 3.8, $result );
	}

	/**
	 * Test check_user_permission with admin user.
	 */
	public function test_check_user_permission_admin() {
		$user_id = $this->factory->user->create(
			array(
				'role' => 'administrator',
			)
		);

		$result = $this->demo->check_user_permission( $user_id );
		$this->assertTrue( $result );
	}

	/**
	 * Test check_user_permission with subscriber user.
	 */
	public function test_check_user_permission_subscriber() {
		$user_id = $this->factory->user->create(
			array(
				'role' => 'subscriber',
			)
		);

		$result = $this->demo->check_user_permission( $user_id );
		$this->assertFalse( $result );
	}

	/**
	 * Test check_user_permission with invalid user ID.
	 */
	public function test_check_user_permission_invalid_user() {
		$result = $this->demo->check_user_permission( 99999 );
		$this->assertFalse( $result );
	}

	/**
	 * Test shortcode rendering.
	 */
	public function test_render_shortcode_default() {
		$result = $this->demo->render_shortcode( array() );
		
		$this->assertStringContainsString( 'unit-testing-demo', $result );
		$this->assertStringContainsString( 'Demo Title', $result );
		$this->assertStringContainsString( 'This is a demo shortcode from Unit Testing plugin.', $result );
	}

	/**
	 * Test shortcode rendering with custom attributes.
	 */
	public function test_render_shortcode_custom_attributes() {
		$atts = array(
			'title'   => 'Custom Title',
			'content' => 'Custom content here',
		);

		$result = $this->demo->render_shortcode( $atts );
		
		$this->assertStringContainsString( 'Custom Title', $result );
		$this->assertStringContainsString( 'Custom content here', $result );
	}

	/**
	 * Test custom post type registration.
	 */
	public function test_register_post_type() {
		$this->demo->register_post_type();
		
		$this->assertTrue( post_type_exists( 'demo_item' ) );
	}

	/**
	 * Test creating a demo item post.
	 */
	public function test_create_demo_item() {
		$this->demo->register_post_type();
		
		$post_id = $this->factory->post->create(
			array(
				'post_type'  => 'demo_item',
				'post_title' => 'Test Demo Item',
			)
		);

		$this->assertNotEmpty( $post_id );
		
		$post = get_post( $post_id );
		$this->assertEquals( 'demo_item', $post->post_type );
		$this->assertEquals( 'Test Demo Item', $post->post_title );
	}

	/**
	 * Test REST API endpoint response.
	 */
	public function test_get_demo_data() {
		$request  = new WP_REST_Request( 'GET', '/unit-testing/v1/demo' );
		$response = $this->demo->get_demo_data( $request );
		
		$this->assertInstanceOf( 'WP_REST_Response', $response );
		
		$data = $response->get_data();
		$this->assertArrayHasKey( 'message', $data );
		$this->assertArrayHasKey( 'version', $data );
		$this->assertArrayHasKey( 'time', $data );
		
		$this->assertEquals( 'Hello from Unit Testing plugin!', $data['message'] );
		$this->assertEquals( UNIT_TESTING_VERSION, $data['version'] );
	}
}
