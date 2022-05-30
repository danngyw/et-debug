<?php


function fre_debug_order(){
	$order_id = 676;


	$order = new AE_Order($order_id);
	$order->set_status( 'pending' );
	$order->update_order();
	//$order_data = $order_pay->generate_data_to_pay();

}
add_action('wp_head','fre_debug_order');