<?php

function fre_debug_show(){

	global $wpdb;

	fre_debug_del_files();

	$trackPaymentLink = get_track_directory('url');
	$trackPaymentPath = get_track_directory('path');
	$trackPaymentLink 	= home_url().'/wp-content/fre_track_payment.css';
	$trackPaymentPath = WP_CONTENT_DIR.'/fre_track_payment.css';
	?>
	<script type="text/javascript">
		function debugRemoveFile(){
			let text;
			  if (confirm("Delete This file?") == true) {
			    return true
			  }
			  return false;
		}
	</script>
	<div class="debugBoard">
		<div class="headerDebug">
			Fre Debug Tool <img src="<?php echo FRE_DEBUG_URL;?>/img/debug.jpg">
		</div>
		<ul>
			<?php if(file_exists(FRE_TRACK_PAYMENT_PATH) ){ ?>
			<li><a href="<?php echo $trackPaymentLink;?>" target="_blank"> Track Payment</a>
				<a class="actDelTrack" href="<?php home_url();?>/?act=deltrack" target="_blank" rel="Del File" title="Delete File?" onclick="return debugRemoveFile()"> <i class="fa fa-trash" aria-hidden="true"></i></a>
			</li>
			<?php } ?>
			<li>
				<a href="<?php echo get_ae_debug_page();?>?debug=post" >Debug Post</a>
			</li>
			<li>
				<a href="<?php echo get_ae_debug_page();?>?debug=order" >Debug Order</a>
			</li>

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