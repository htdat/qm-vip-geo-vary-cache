<?php 

class Vary_Cache_Test extends WP_UnitTestCase {

    public function test_just_a_test() {
        $a = 'abc';
        $b = 'abc'; 
		$this->assertEquals( $a, $b );
        $this->assertTrue ( class_exists( '\Automattic\VIP\Cache\Vary_Cache' ) ); 

    }
}