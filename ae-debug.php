<?php
 /*
Plugin Name: Fre Debug

Plugin URI: https://danhoat.wordpress.com/
Description: Allow developer can easy debug the problem of FreelanceEngine site.
Version: 1.0
Author: danng
Author URI: https://danhoat.wordpress.com/
License: A "Slug" license name e.g. GPL2
Text Domain: ae_debug
*/

define( 'FRE_DEBUG_PATH', dirname( __FILE__ ) );
define( 'FRE_DEBUG_URL', plugin_dir_url( __FILE__ ) );

define('FRE_TRACK_PAYMENT_PATH', WP_CONTENT_DIR.'/fre_track_payment.css');

require_once FRE_DEBUG_PATH . '/inc/enque_style.php';
require_once FRE_DEBUG_PATH . '/inc/debug_order.php';
require_once FRE_DEBUG_PATH . '/functions.php';


function  fre_debug_function(){
	require_once FRE_DEBUG_PATH . '/inc/filter.php';
	require_once FRE_DEBUG_PATH . '/inc/hook_action.php';
	if( current_user_can('manage_options') ){
		add_action('wp_footer','fre_debug_show');
	}

}

add_action('after_setup_theme','fre_debug_function');

/**
 * Activate the plugin.
 */
function ae_debug_create_page(){
	$args = array(
		'post_type' => 'page',
		'post_title' => 'Debug Page',
		'post_content' => '[ae_debug]',
	);
	$id = wp_insert_post($args);
	if( $id && !is_wp_error($id) ){
		update_option('debug_id_page', $id);
	}
}
function ae_debug_activate() {
	$debug = get_option('debug_id_page', true);
	if( empty($debug) || !$debug ){
		debug_log('page no exist.');
		debug_log('create new page.');
		ae_debug_create_page();
	} else{
		$page = get_post($debug);
		if( !$page or is_wp_error($page) ){
			debug_log('page removed.');
			debug_log('create new page.');
			ae_debug_create_page();
		}
	}
}
register_activation_hook( __FILE__, 'ae_debug_activate' );