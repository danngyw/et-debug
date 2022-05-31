<?php
add_shortcode( 'ae_debug', 'ae_debug_shortcode' );
function ae_debug_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'foo' => 'no foo',
        'baz' => 'default baz'
    ), $atts, 'bartag' );
    $debug  = isset($_GET['debug']) ? $_GET['debug'] : '';
    $view   = isset($_GET['view']) ? $_GET['view'] : '';
    if( $debug = 'order'){
        $debug_page = get_ae_debug_page();

        
       $action = add_query_arg( array(
            'debug' => 'order',
            'view' => 'detail',
        ), $debug_page );

                $html = '<form class="form-inline" action="'.$action.'" method="get"><h3> Tim kiếm order</h3>

          <div class="form-group mx-sm-5 mb-5">
            <label for="inputPassword2" >Order ID</label>

            <input type="hidden" name="debug" value ="order" />
            <input type="hidden" name="view" value ="detail" />

            <input type="number" class="form-control"  name="order_id" placeholder="Order ID">
          </div>
          <button type="submit" class="btn btn-primary mb-2">Tìm Kiếm</button>
        </form> ';
        if( $view == 'detail' ){
            $html .= '<br /><p>This is detail order.</p>';
            $order_id = $_GET['order_id'];
            $order_p = get_post($order_id);
            if( $order_p && !is_wp_error($order_p) ){
                $order = new AE_Order($order_id);
                $order_data = $order->get_order_data();
                $order_pay = $order->generate_data_to_pay();
                $output = print_r($order_data, true);
                $output2 = print_r($order_pay, true);
                $html.='order_data:<pre>'.$output.'</pre>';
                $html.='order_pay: <pre>'.$output2.'</pre>';
            }
        }
        return $html;
    }
    return "foo = {$atts['foo']}";
}