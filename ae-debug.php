<?php
 /*
Plugin Name: AE Debug

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
require_once FRE_DEBUG_PATH . '/inc/shortcodes.php';
require_once FRE_DEBUG_PATH . '/inc/ajax.php';


/**
 * Activate the plugin.
 */
function ae_debug_create_page(){
	$args = array(
		'post_type' 	=> 'page',
		'post_title' 	=> 'Debug Page',
		'post_content' 	=> '[ae_debug]',
		'post_status' 	=> 'publish',
	);
	$id = wp_insert_post($args);
	if( $id && !is_wp_error($id) ){
		update_option('debug_id_page', $id);
		update_post_meta($id, '_wp_page_template', 'page-full-width.php');
	}
}
function ae_debug_activate() {
	$debug = get_option('debug_id_page', false);

	if( empty($debug) || !$debug ){
		ae_debug_create_page();
	} else{

		$page = get_post($debug);
		if( !$page || is_wp_error($page)  ){
			ae_debug_create_page();
		} else if( $page->post_status !== 'publish'){
			$args = array('ID' => $page->ID, 'post_status' => 'publish');
			wp_update_post($args);
		}
	}
}
register_activation_hook( __FILE__, 'ae_debug_activate' );

function  fre_debug_function(){
	require_once FRE_DEBUG_PATH . '/inc/filter.php';
	require_once FRE_DEBUG_PATH . '/inc/hook_action.php';
	if( current_user_can('manage_options') ){
		add_action('wp_footer','fre_debug_show');
	}

}

add_action('after_setup_theme','fre_debug_function');