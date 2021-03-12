<?php 

class QM_VIP_Geo_Test extends QM_VIP_Base_Test {

	public function setUp() {
		// Set up some values for VIP_Go_Geo_Uniques
		VIP_Go_Geo_Uniques::set_default_location( 'US' );
		VIP_Go_Geo_Uniques::add_location( 'GB' );
		VIP_Go_Geo_Uniques::add_location( 'SG' );
		VIP_Go_Geo_Uniques::add_location( 'ES' );
		
		parent::setUp();  

		$this->assertTrue( class_exists( 'VIP_Go_Geo_Uniques' ) ); 
		$this->assertTrue( class_exists( 'QueryMonitor' ) ); 
	}

	public function test_output_include_registered_codes() {
		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
		$needle = '<code>GB | SG | ES</code>';

		$this->assertStringContainsString( $needle, $output );
	}

	public function test_output_include_the_current_country() {
		$_SERVER['GEOIP_COUNTRY_CODE'] = 'ES';
		
		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
		$needle = '<code>ES</code>';

		$this->assertStringContainsString( $needle, $output );

	}

	public function test_output_include_default_code_when_the_current_country_not_registere() {
		$_SERVER['GEOIP_COUNTRY_CODE'] = 'VN';

		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
		$needle = '<code>US</code>';
		$this->assertStringContainsString( $needle, $output );
	}
}