<?php 

/**
 * Class Collector for VIP_Go_Geo_Uniques
 */
class QM_Collector_VIP_Go_Geo_Uniques extends QM_Collector {

	public $id = 'vip-go-geo-uniques';

	/**
	 * @return string
	 */
	public function name() {
		return esc_html__( 'VIP Go Geo Uniques', 'qm-vip-geo-vary-cache' );
	}
}