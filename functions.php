<?php

function debug_log($input){

	$file_store = WP_CONTENT_DIR.'/debug_log.css';

	if( is_array( $input ) || is_object( $input ) ){
		error_log( date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) ). ': '. print_r($input, TRUE), 3, $file_store );
	} else {
		error_log( date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) ). ': '. $input . "\n" , 3, $file_store);
	}

}
function get_ae_debug_page(){
	$page_id = get_option('debug_id_page', false);
	if( $page_id ){
		//update_post_meta($page_id, '_wp_page_template', 'page-full-width.php');
		$page_id = get_post($page_id);
		if( $page_id && !is_wp_error($page_id))
			return get_permalink($page_id);
	}
}
function fre_debug_del_files(){
	$act = isset($_GET['act']) ? $_GET['act'] :'';
	if( $act == 'deltrack' && file_exists(FRE_TRACK_PAYMENT_PATH) ){
		unlink(FRE_TRACK_PAYMENT_PATH);
	}
}