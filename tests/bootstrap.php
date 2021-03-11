<?php

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

/** 
 * Needs to set this up. Otherwise, it's not possible to run tests 
 * 
 * @ref https://github.com/johnbillion/query-monitor/blob/22b2828b0fb9f7fb8e117c875c042ef226d7ea66/tests/phpunit/includes/bootstrap.php#L21
 */ 
define( 'QM_TESTS', true); 

// Load relevant plugins 
tests_add_filter( 'muplugins_loaded', function() use ($_tests_dir)  {
	require_once $_tests_dir . '/vip-go-mu-plugins-built/query-monitor/query-monitor.php';
	require_once $_tests_dir . '/vip-go-mu-plugins-built/cache/class-vary-cache.php';
	require_once $_tests_dir . '/vip-go-geo-uniques/vip-go-geo-uniques.php';
	require_once dirname( __DIR__ ) . '/qm-vip-geo-vary-cache.php'; 
} );

// Load bootstrap from vip-go-mu-plugins-built 
require_once $_tests_dir . '/vip-go-mu-plugins-built/tests/bootstrap.php';

