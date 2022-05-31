<?php
function filter_the_content_in_the_main_loop( $content ) {

    // Check if we're inside the main loop in a single Post.
    $debug = isset($_GET['debug']) ? $_GET['debug']:'';
    if (  $debug == 'order') {
        return esc_html__( 'Form order here', 'wporg');
    }

    return $content;
}
add_filter( 'the_content', 'filter_the_content_in_the_main_loop', 999 );