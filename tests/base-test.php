<?php 

class QM_VIP_Base_Test extends WP_UnitTestCase {

	public function setUp() {
		parent::setUp();  
		
		$admin = $this->factory->user->create_and_get( array(
			'role' => 'administrator',
		) );

		if ( is_multisite() ) {
			grant_super_admin( $admin->ID );
		}

		wp_set_current_user( $admin->ID );

		$this->assertTrue( class_exists( 'VIP_Go_Geo_Uniques' ) ); 
		$this->assertTrue( class_exists( 'QueryMonitor' ) ); 
		
		if ( ! defined( 'WP_USE_THEMES' ) ){
			define( 'WP_USE_THEMES', true);
		}

		remove_action( 'template_redirect', 'redirect_canonical' );

		require_once ABSPATH . WPINC . '/template-loader.php';

		$this->html = QM_Dispatchers::get( 'html' );

		$this->html->init();

        $this->go_to( 'wp-admin' );
	}

}