<?php 

use Automattic\VIP\Cache\Vary_Cache;

/**
 * Class Output for Automattic\VIP\Cache\Vary_Cache
 */

class QM_Output_VIP_Vary_Cache extends \QM_Output_Html {

	/**
	 * @param QM_Collector $collector
	 */
	public function __construct( QM_Collector $collector ) {
		parent::__construct( $collector );
		add_filter( 'qm/output/menus', array( $this, 'admin_menu' ), 90 );
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

		if ( ! class_exists ( '\Automattic\VIP\Cache\Vary_Cache' ) ) {
			return;  
        }

		$groups = Vary_Cache::get_groups(); 

		if ( ! is_array( $groups ) || count( $groups ) < 1 ) {
			$this->before_non_tabular_output();
			echo '<section>';
			echo '<h3>' . esc_html__( 'No group is defined.', 'qm-vip-geo-vary-cache' ) . '</h3>';
			echo '</section>';
			$this->after_non_tabular_output();
			return;	
		}

		$this->before_tabular_output();

		echo '<thead>';
		echo '<tr>';
		echo '<th scope="col">' . esc_html__( 'Group', 'qm-vip-geo-vary-cache' ) . '</th>';
		echo '<th scope="col">' . esc_html__( 'Value', 'qm-vip-geo-vary-cache' ) . '</th>';
		echo '</tr>';
		echo '</thead>';

		echo '<tbody>';
		foreach ($groups as $group => $value) {
			echo '<tr>';
			echo '<td class="qm-ltr">' . esc_html( $group ) . '</td>'; 
			echo '<td class="qm-ltr">' . esc_html( $value ) . '</td>'; 
			echo '</tr>';

		}
		echo '</tbody>';
	
		$this->after_tabular_output();

    } 
}
