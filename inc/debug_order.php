<?php


function fre_debug_order(){
	$order_id = 680;

	$order_p = get_post($order_id);
	$order = new AE_Order($order_id);
	$order_pay = $order->generate_data_to_pay();
	$order_data = $order->get_order_data();
	$order_type = get_post_meta( $order_id,  'order_type',true );

	echo '<pre>';
	//var_dump($order_type);
	//var_dump($order_data);
	var_dump($order_pay);

	echo '</pre>';


	$order->set_status( 'pending' );
	$order->update_order();
	//$order_data = $order_pay->generate_data_to_pay();

}
 add_action('wp_head','fre_debug_order');