<?php
function ae_debug_del_track(){
	$resp = array(
		'success' 	=> true,
		'msg' 		=> ' File has been deleted',
	);
	fre_debug_del_files();
	wp_send_json($resp);
}
add_action('wp_ajax_delete_track','ae_debug_del_track');


function ae_debug_del_posts(){
	$resp = array(
		'success' 	=> true,
		'msg' 		=> ' Deleted all posts.',
	);


	$ptype = isset($_REQUEST['ptype']) ? $_REQUEST['ptype']:'';
	global $wpdb;
	if( $ptype ){
		$sql = $wpdb->prepare("SELECT * FROM $wpdb->posts where post_type = %s", $ptype);
		$results = $wpdb->get_results($sql);
		foreach($results as $post){
			var_dump($post->ID);
		}
	}

	wp_send_json($resp);
}
add_action('wp_ajax_delete_posts','ae_debug_del_posts');

