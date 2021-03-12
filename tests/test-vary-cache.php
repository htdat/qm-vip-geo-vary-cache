<?php

use Automattic\VIP\Cache\Vary_Cache;

class QM_VIP_Cache_Test extends QM_VIP_Base_Test {

	public function setUp() {
		Vary_Cache::unload(); 

		parent::setUp(); 

		$this->assertTrue( class_exists( '\Automattic\VIP\Cache\Vary_Cache' ) ); 
		$this->assertTrue( class_exists( 'QueryMonitor' ) ); 
	
	}

	public function test_output_include_group_name_without_any_value() {
		Vary_Cache::register_group( 'test-group-1' );

		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();

		$this->assertStringContainsString( 'test-group-1', $output );
	}

	public function test_output_include_group_name_with_value() {
		// Set cookie value to mock a segment 
		$_COOKIE = [ // phpcs:ignore
			'vip-go-seg' => 'test2_--_value2',
		];

		Vary_Cache::register_group( 'test2' );
		Vary_Cache::parse_cookies();

		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();

		$this->assertStringContainsString( 'test2', $output );
		$this->assertStringContainsString( 'value2', $output );
	}

	public function test_output_without_any_group() {
		ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();

		$this->assertStringContainsString( 'No group is defined', $output );
	}
}