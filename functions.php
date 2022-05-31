<?php

function debug_log($input){

	$file_store = WP_CONTENT_DIR.'/debug_log.css';

	if( is_array( $input ) || is_object( $input ) ){
		error_log( date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) ). ': '. print_r($input, TRUE), 3, $file_store );
	} else {
		error_log( date( 'Y-m-d H:i:s', current_time( 'timestamp', 0 ) ). ': '. $input . "\n" , 3, $file_store);
	}

	}

function fre_debug_del_files(){
	$act = isset($_GET['act']) ? $_GET['act'] :'';
	if( $act == 'deltrack' && file_exists(FRE_TRACK_PAYMENT_PATH) ){
		unlink(FRE_TRACK_PAYMENT_PATH);
	}
}