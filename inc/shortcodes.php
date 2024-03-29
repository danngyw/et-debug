<?php
function ae_debug_selected($string, $check){
    if( $string == $check){
        return 'selected';
    }
}
add_shortcode( 'ae_debug', 'ae_debug_shortcode' );
function ae_debug_shortcode( $atts ) {
    $atts = shortcode_atts( array(
        'foo' => 'no foo',
        'baz' => 'default baz'
    ), $atts, 'bartag' );
    $debug  = isset($_GET['debug']) ? $_GET['debug'] : '';
    $view   = isset($_GET['view']) ? $_GET['view'] : '';
    global $wpdb;
    $debug_page = get_ae_debug_page();

    if( $debug == 'order'){
        $order_id = isset($_GET['order_id'] ) ? (int) $_GET['order_id'] : '';
         if($order_id < 1) $order_id = '';

        $action = add_query_arg( array(
            'debug' => 'order',
            'view'  => 'detail',
        ), $debug_page );

            $html = '<form class="form-inline debugForm" action="'.$action.'" method="get"><h3> XEM THÔNG TIN ORDER</h3>

          <div class="form-group mx-sm-5 mb-5">
            <label for="inputPassword2" >Order ID</label>

            <input type="hidden" name="debug" value ="order" />
            <input type="hidden" name="view" value ="detail" />

            <input type="number" class="form-control"  name="order_id" placeholder="Order ID" value="'.$order_id.'">
          </div>
          <button type="submit" class="btn btn-primary btn-submit">Tìm Kiếm</button>
        </form> ';
        if( $view == 'detail' && $order_id > 0 ){
            $html .= '<br /><p><strong>Detail Order</strong></p>';
            $order_id = $_GET['order_id'];
            $order_p = get_post($order_id);
            if( $order_p && !is_wp_error($order_p) ){

                $order = new AE_Order($order_id);

                $order_data = $order->get_order_data();
                $order_pay = $order->generate_data_to_pay();
                $output     = print_r($order_data, true);
                $output2 = print_r($order_pay, true);
                $html.='order_data:<pre>'.$output.'</pre>';
                $html.='order_pay: <pre>'.$output2.'</pre>';
            } else{
                $html.='This order is not available.';
            }
        }
        return $html;
    } else if( $debug == 'post'){
         $action = add_query_arg( array(
            'debug' => 'order',
            'view' => 'detail',
        ), $debug_page );
        $post_id = isset($_GET['post_id']) ? (int) $_GET['post_id'] : '';
        if($post_id < 1) $post_id = '';

        $html = '<form class="form-inline debugForm" action="'.$action.'" method="get"><h3> XEM THÔNG TIN POST</h3>

          <div class="form-group mx-sm-5">
            <label for="inputPassword2" >Post ID</label>
            <input type="hidden" name="debug" value ="post" />
            <input type="hidden" name="view" value ="detail" />
            <input type="number" class="form-control"  name="post_id" placeholder="Post ID" value="'.$post_id.'">
          </div>
          <button type="submit" class="btn btn-primary btn-submit">Tìm Kiếm</button>
        </form> ';
        if( $view == 'detail' && $post_id > 0 ){
            $html .= '<br /><p><strong> Detail Post</strong></p>';
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


            } else{
                 $html.='This post is not available.';
            }
            return $html;
        }
        return $html;
    } else if($debug == 'viewpost'){
        $post_type          = isset($_GET['ptype']) ? $_GET['ptype'] : 'fre_credit_history';
        $order_selected     = ae_debug_selected($post_type, 'et_order');
        $his_selected       = ae_debug_selected($post_type, 'fre_credit_history');
        $project_selected   = ae_debug_selected($post_type, 'project');
        $profile_selected   = ae_debug_selected($post_type, 'fre_profile');
         $html = '<form class="form-inline debugForm" method="get"><h3> XEM THÔNG TIN POST</h3>

          <div class="form-group mx-sm-5">
            <label for="inputPassword2" >Post ID</label>
            <input type="hidden" name="debug" value ="viewpost" />
            <select name="ptype">
                <option '.$his_selected.' value = "fre_credit_history"> History </option>
                <option '.$order_selected.' value = "et_order"> Order </option>
                <option '.$project_selected.' value = "project"> Projects </option>
                <option '.$profile_selected.' value = "fre_profile"> Profiles </option>
            </select>
            <button type="submit" class="btn btn-primary btn-submit">Tìm Kiếm</button>
          </div>

           <div class="form-group mx-sm-5 debug-btn-del">
          '.debug_btn_del().'
          </div>
        </form> ';

        $debug_page = get_ae_debug_page();
        if( $post_type){
            $args = array(
                'post_type'         => $post_type,
                'post_status'       => 'all',
                'posts_per_page'    => -1,
            );
            $query = new WP_Query($args);
            if( $query->have_posts() ){
                $html .='<table id="listPost">';
                    $html.='<thead><tr><td> ID</td><td> Title </td><td> Author</td><td> Post Parent</td><td> Date</td><td> Status</td><td> Action</td></thead>';
                while($query->have_posts() ){

                    $query->the_post();
                    global $post;

                    $link = add_query_arg(array(
                        'debug' => 'post',
                        'view'=> 'detail',
                        'post_id'=> $post->ID),
                        $debug_page);
                    $link_html = '<a href="'.$link.'" target="_blank" >View</a>';
                    $html.='<tr><td>'.$post->ID.'</td><td>'.$post->post_title.'</td><td>'.$post->post_author.'</td>';
                    $html.='<td>'.$post->post_parent.'</td><td>'.$post->post_date.'</td>';
                    $html.='<td>'.$post->post_status.'</td><td>'.$link_html.' </td>';
                    $html.='</tr>';

                }
                $html.='</table>';
            } else {
                $html.='No posts found.';
            }
            wp_reset_query();
        }
        return $html;
    }
    return "foo = {$atts['foo']}";
}