<?php 
/**
 * Class Output for VIP_Go_Geo_Uniques
 */
class QM_Output_VIP_Go_Geo_Uniques extends QM_Output_Html {

	/**
	 * @param QM_Collector $collector
	 */
	public function __construct( QM_Collector $collector ) {
		parent::__construct( $collector );
		add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 90 );
	}

	public function name() {
		return esc_html__( 'VIP Go Geo Uniques', 'qm-vip-geo-vary-cache' );
	}

	/**
	 * @param array $menu Array of menu items 
	 */
	public function admin_menu( array $menu ) {
		$args = array(
			'title' => esc_html( $this->name() ),
		);
		$menu[ $this->collector->id() ] = $this->menu( $args );
		return $menu;
	}

	/**
	 * Echoes the Query Manager compatible output
	 * @return void
	 */
	public function output() {

		if ( ! class_exists ( 'VIP_Go_Geo_Uniques' ) ) {
			return;  
        }

		$this->before_non_tabular_output();
		echo '<section>';
		echo '<h3>' . esc_html__( 'VIP Geo Location info:', 'qm-vip-geo-vary-cache' ) . '</h3>';
		
		echo '<ul>'; 
		echo '<li>'; 
		echo esc_html__( 'Current country code: ', 'qm-vip-geo-vary-cache' );
		echo '<code>' . esc_html( VIP_Go_Geo_Uniques::get_country_code() ). '</code>';
		echo '</li>'; 
		echo '<li>'; 
		echo esc_html__( 'Registered country codes: ', 'qm-vip-geo-vary-cache' );
		echo '<code>' . esc_html( implode( ' | ', VIP_Go_Geo_Uniques::get_registered_locations() ) ) . '</code>'; 
		echo '</li>';
		echo '</ul>';
		
		echo '</section>';
		$this->after_non_tabular_output();

    } 
}