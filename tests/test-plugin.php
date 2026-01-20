<?php
/**
 * Class PluginTest
 *
 * @package Unit_Testing
 */

/**
 * Plugin main class test case.
 */
class PluginTest extends WP_UnitTestCase {

	/**
	 * Test plugin instance is singleton.
	 */
	public function test_get_instance_returns_same_instance() {
		$instance1 = \UnitTesting\Plugin::get_instance();
		$instance2 = \UnitTesting\Plugin::get_instance();
		
		$this->assertSame( $instance1, $instance2 );
	}

	/**
	 * Test plugin instance is of correct class.
	 */
	public function test_get_instance_returns_plugin_instance() {
		$instance = \UnitTesting\Plugin::get_instance();
		
		$this->assertInstanceOf( 'UnitTesting\Plugin', $instance );
	}

	/**
	 * Test plugin constants are defined.
	 */
	public function test_plugin_constants_defined() {
		$this->assertTrue( defined( 'UNIT_TESTING_VERSION' ) );
		$this->assertTrue( defined( 'UNIT_TESTING_PATH' ) );
		$this->assertTrue( defined( 'UNIT_TESTING_URL' ) );
	}

	/**
	 * Test plugin version constant.
	 */
	public function test_plugin_version() {
		$this->assertEquals( '1.0.0', UNIT_TESTING_VERSION );
	}

	/**
	 * Test plugin path constant.
	 */
	public function test_plugin_path() {
		$expected_path = plugin_dir_path( dirname( __FILE__ ) );
		$this->assertEquals( $expected_path, UNIT_TESTING_PATH );
	}

	/**
	 * Test init action is registered.
	 */
	public function test_init_action_registered() {
		$plugin = new \UnitTesting\Plugin();
		$plugin->run();
		
		$this->assertNotFalse( has_action( 'init', array( $plugin, 'init' ) ) );
	}

	/**
	 * Test admin menu action is registered.
	 */
	public function test_admin_menu_action_registered() {
		$plugin = new \UnitTesting\Plugin();
		$plugin->run();
		
		$this->assertNotFalse( has_action( 'admin_menu', array( $plugin, 'add_admin_menu' ) ) );
	}
}
