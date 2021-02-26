<?php 

/**
 * Class Collector for Automattic\VIP\Cache\Vary_Cache
 */
class QM_Collector_VIP_Vary_Cache extends QM_Collector {

	public $id = 'vip-vary-cache';

	/**
	 * @return string
	 */
	public function name() {
		return esc_html__( 'VIP Vary Cache', 'query-monitor' );
	}
}