<?php
/**
 * Plugin Name: Query Monitor: VIP Go Geo Uniques and Personalziation (Vary) Cache 
 * Description: Show Geolocation and Personalziation Cache info in Query Monitor
 * Version: 0.1-dev
 * Plugin URI: https://github.com/Automattic/update-soon 
 * Author: Automattic, htdat
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

add_action( 'plugins_loaded', 'qm_vip_geo' );
add_action( 'plugins_loaded', 'qm_vip_vary_cache' );

// Load files for VIP Go Geo Uniques
function qm_vip_geo() {

    if ( ! class_exists ( 'VIP_Go_Geo_Uniques' ) ) {
        return; 
    }

    add_filter( 'qm/collectors', 
        function ( array $collectors, QueryMonitor $qm ) {
            require_once ( 'collectors/geo.php' ); 
            $collectors['vip-go-geo'] = new QM_Collector_VIP_Go_Geo_Uniques();         
            return $collectors;
        }, 
    20, 2 );

    add_filter( 'qm/outputter/html', 
        function( $output ) {
            require_once ( 'output/geo.php' ); 
            $collector = QM_Collectors::get( 'vip-go-geo-uniques' ); 
            if ( $collector ) {
                $output['vip-go-geo'] = new QM_Output_VIP_Go_Geo_Uniques( $collector );
            }
            return $output;   
        }, 
    10, 1 );        

}

// Load files for VIP Go Vary Cache
function qm_vip_vary_cache() {

    if ( ! class_exists ( '\Automattic\VIP\Cache\Vary_Cache' ) ) {
        return; 
    }

    add_filter( 'qm/collectors', 
        function ( array $collectors, QueryMonitor $qm ) {
            require_once ( 'collectors/vary_cache.php' ); 
            $collectors['vip-vary-cache'] = new QM_Collector_VIP_Vary_Cache();         
            return $collectors;
        }, 
    20, 2 );

    add_filter( 'qm/outputter/html', 
        function( $output ) {
            require_once ( 'output/vary_cache.php' ); 
            $collector = QM_Collectors::get( 'vip-vary-cache' ); 
            if ( $collector ) {
                $output['vip-vary-cache'] = new QM_Output_VIP_Vary_Cache( $collector );
            }
            return $output;   
        }, 
    10, 1 );   

}