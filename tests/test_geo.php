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

        if ( class_exists( 'VIP_Go_Geo_Uniques' ) ) {
            VIP_Go_Geo_Uniques::set_default_location( 'US' );
            VIP_Go_Geo_Uniques::add_location( 'GB' );
            VIP_Go_Geo_Uniques::add_location( 'VN' );
            VIP_Go_Geo_Uniques::add_location( 'SG' );
            VIP_Go_Geo_Uniques::add_location( 'JP' );
            VIP_Go_Geo_Uniques::add_location( 'HK' );
            VIP_Go_Geo_Uniques::add_location( 'ES' );
        }
        
        define( 'WP_USE_THEMES', true );

		if ( ! isset( $_SERVER['REQUEST_METHOD'] ) ) {
			$_SERVER['REQUEST_METHOD'] = 'GET';
		}
        remove_action( 'template_redirect', 'redirect_canonical' );

        require_once ABSPATH . WPINC . '/template-loader.php';

        $this->html = QM_Dispatchers::get( 'html' );

		$this->html->init();

	}

    public function test_just_a_test() {         
        $this->assertTrue ( class_exists( 'VIP_Go_Geo_Uniques' ) ); 
        $this->assertTrue ( class_exists( 'QueryMonitor' ) ); 

        $this->go_to( 'wp-admin' );

        ob_start();
		$this->html->dispatch();
		$output = ob_get_flush();
        $needle = 'VIP Geo Location';

        $this->assertStringContainsString( $needle, $output );

    }
}