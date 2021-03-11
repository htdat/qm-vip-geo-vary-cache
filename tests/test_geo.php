<?php 

class QM_VIP_Geo_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();  
		
		$admin = $this->factory->user->create_and_get( array(
			'role' => 'administrator',
		) );

		if ( is_multisite() ) {
			grant_super_admin( $admin->ID );
		}

		wp_set_current_user( $admin->ID );

		// Set up some values for VIP_Go_Geo_Uniques
		if ( class_exists( 'VIP_Go_Geo_Uniques' ) ) {
			VIP_Go_Geo_Uniques::set_default_location( 'US' );
			VIP_Go_Geo_Uniques::add_location( 'GB' );
			VIP_Go_Geo_Uniques::add_location( 'SG' );
			VIP_Go_Geo_Uniques::add_location( 'ES' );
		}
		
		if ( ! defined( 'WP_USE_THEMES' ) ){
			define( 'WP_USE_THEMES', true);
		}

		remove_action( 'template_redirect', 'redirect_canonical' );

		require_once ABSPATH . WPINC . '/template-loader.php';

		$this->html = QM_Dispatchers::get( 'html' );

		$this->html->init();

	}

	public function test_output_include_registered_codes() {
		$this->assertTrue ( class_exists( 'VIP_Go_Geo_Uniques' ) ); 
		$this->assertTrue ( class_exists( 'QueryMonitor' ) ); 

		$this->go_to( 'wp-admin' );

		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
		$needle = '<code>GB | SG | ES</code>';

		$this->assertStringContainsString( $needle, $output );

	}

	public function test_output_include_the_current_country() {
		$_SERVER['GEOIP_COUNTRY_CODE'] = 'ES';
		$this->go_to( 'wp-admin' );

		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
		$needle = '<code>ES</code>';

		$this->assertStringContainsString( $needle, $output );

	}

	public function test_output_include_default_code_when_the_current_country_not_registere() {
		$_SERVER['GEOIP_COUNTRY_CODE'] = 'VN';
		$this->go_to( 'wp-admin' );

		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
		$needle = '<code>US</code>';
		$this->assertStringContainsString( $needle, $output );
	}
}