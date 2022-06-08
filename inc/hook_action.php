<?php

function fre_debug_show(){

	global $wpdb;
	// $trackPaymentLink 	= get_track_directory('url');
	// $trackPaymentPath 	= get_track_directory('path');
	$trackPaymentLink 		= home_url().'/wp-content/fre_track_payment.css';
	$trackPaymentPath 		= WP_CONTENT_DIR.'/fre_track_payment.css';
	?>
	<script type="text/javascript">
		(function($){
			$(document).ready(function() {
			$(".actDelTrack").click(function(){
				if (confirm("Delete This file?") == true) {
				  	jQuery.ajax({
						url: ae_globals.ajaxURL,
						method: 'GET',
						data: {
							action: 'delete_track',
						},
						beforeSend: function () {
							console.log('123');
						},
						success: function (response) {
						console.log('OK.');
					}
				});
			    return false
				}
			});
			});
		})(jQuery);
	</script>
	<div class="debugBoard">
		<div class="headerDebug">
			Fre Debug Tool <img src="<?php echo FRE_DEBUG_URL;?>/img/debug.jpg">
		</div>
		<ul>
			<li>
				<a href="<?php echo get_ae_debug_page();?>?debug=post" >Debug Post</a>
			</li>
			<li>
				<a href="<?php echo get_ae_debug_page();?>?debug=order" >Debug Order</a>
			</li>
			<?php if(file_exists(FRE_TRACK_PAYMENT_PATH) ){ ?>
				<li>
					<a href="<?php echo $trackPaymentLink;?>" target="_blank"> Track Payment</a>
					<a class="actDelTrack" href="<?php home_url();?>"  rel="Del File" title="Delete File?" >
						<i class="fa fa-trash" aria-hidden="true"></i></a>
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