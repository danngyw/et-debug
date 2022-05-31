<?php
add_shortcode( 'ae_debug', 'ae_debug_shortcode' );
function ae_debug_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'foo' => 'no foo',
        'baz' => 'default baz'
    ), $atts, 'bartag' );
    $debug  = isset($_GET['debug']) ? $_GET['debug'] : '';
    $view   = isset($_GET['view']) ? $_GET['view'] : '';

     $debug_page = get_ae_debug_page();
    if( $debug == 'order'){


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
    } else if( $debug == 'post'){
         $action = add_query_arg( array(
            'debug' => 'order',
            'view' => 'detail',
        ), $debug_page );
        $post_id = isset($_GET['post_id']) ? (int) $_GET['post_id'] : '';

        $html = '<form class="form-inline" action="'.$action.'" method="get"><h3> Tim kiếm post </h3>

          <div class="form-group mx-sm-5 mb-5">
            <label for="inputPassword2" >Post ID</label>

            <input type="hidden" name="debug" value ="post" />
            <input type="hidden" name="view" value ="detail" />

            <input type="number" class="form-control"  name="post_id" placeholder="Post ID" value="'.$post_id.'">
          </div>
          <button type="submit" class="btn btn-primary mb-2">Tìm Kiếm</button>
        </form> ';
        if( $view == 'detail' && $post_id > 0 ){
            $html .= '<br /><p>This is detail post.</p>';


            global $wpdb;

            $post = get_post($post_id);

            if( $post && ! is_wp_error($post) ){
                $sql = "SELECT * FROM $wpdb->postmeta where post_id = {$post->ID}";
                $results = $wpdb->get_results($sql);

                $output = print_r($post, true);
                $html.='Post values: <br /><pre>'.$output.'</pre>';
                $temp = array();
                foreach($results as $meta){
                    $meta_key = $meta->meta_key;
                    $temp[$meta_key] = $meta->meta_value;
                }
                $meta_keys = print_r($temp, true);
                $html.='Post Meta:  <br /><pre>'.$meta_keys.'</pre>';


            }
            return $html;
        }
        return $html;
    }
    return "foo = {$atts['foo']}";
}