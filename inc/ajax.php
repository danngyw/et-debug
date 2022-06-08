<?php
function ae_debug_del_track(){
	$resp = array(
		'success' 	=> true,
		'msg' 		=> ' File has been deleted',
	);
	wp_send_json($resp);
}
add_action('wp_ajax_delete_track','ae_debug_del_track');