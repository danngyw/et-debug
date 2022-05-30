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

require_once FRE_MEMBERSHIP_PATH . '/inc/enque_style.php';

function fre_debug_show_db_table(){

	global $wpdb;

	echo '<pre>';
	echo 'this is debug<br />';

	$path = "D:\Xampp\htdocs\et/wp-content/uploads/sites/3/2021/01/avatar_admin-3.png";
	$path = "http://localhost/et/fre/wp-content/uploads/sites/3/2021/01/avatar_admin-3.png";

	//$editor = wp_get_image_editor( $path );
	//var_dump($editor);


	$args = array(
		'path' => $path,
		'"mime_type' => 'image/png',
	);
	$implementation = _wp_image_editor_choose( $args ); // WP_Image_Editor_Imagick WP_Image_Editor_GD
;
	echo '</pre>';

	$slugs = array('register' ,'login' ,'profile' ,'reset-pass','forgot-password','process-payment','submit-project','my-project','list-notification','upgrade-account');
	foreach ($slugs as $slug) {
		$exist = get_pages( array(
			'meta_key'    => '_wp_page_template',
			'meta_value'  => 'page-' . $slug . '.php',
			'numberposts' => 1
		) );
		if($exist){
			continue;
		}
		echo ' Page '.$slug.' did not created <br />';
	}

}
add_action('wp_footer','fre_debug_show_db_table');

