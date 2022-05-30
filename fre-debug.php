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


function fre_debug_del_files(){
	$act = isset($_GET['act']) ? $_GET['act'] :'';
	if( $act == 'deltrack' ){
		unlink(FRE_TRACK_PAYMENT_PATH);
	}
}
function fre_debug_show_db_table(){

	global $wpdb;


	$trackPaymentLink = get_track_directory('url');
	$trackPaymentPath = get_track_directory('path');
	$trackPaymentLink 	= home_url().'/wp-content/fre_track_payment.css';
	$trackPaymentPath = WP_CONTENT_DIR.'/fre_track_payment.css';
	?>
	<div class="debugBoard">
		<div class="headerDebug">
			Fre Debug Tool <img src="<?php echo FRE_DEBUG_URL;?>/img/debug.jpg">
		</div>
		<ul>
			<?php if(file_exists(FRE_TRACK_PAYMENT_PATH) ){ ?>
			<li><a href="<?php echo $trackPaymentLink;?>" target="_blank"> Track Payment</a>
				<a class="actDelTrack" href="<?php home_url();?>/?act=deltrack" target="_blank" rel="Del File" title="Delete File?"> <i class="fa fa-trash" aria-hidden="true"></i></a>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php

	$path = "D:\Xampp\htdocs\et/wp-content/uploads/sites/3/2021/01/avatar_admin-3.png";
	$path = "http://localhost/et/fre/wp-content/uploads/sites/3/2021/01/avatar_admin-3.png";




	$args = array(
		'path' => $path,
		'"mime_type' => 'image/png',
	);
	$implementation = _wp_image_editor_choose( $args ); // WP_Image_Editor_Imagick WP_Image_Editor_GD


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

