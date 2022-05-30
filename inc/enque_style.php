<?php

function fre_debug_style() {
    wp_enqueue_style( 'fre_debug_style', plugin_dir_url( __FILE__ ) . 'assets/style.css', array(), rand() );
}
add_action('wp_enqueue_scripts', 'fre_debug_style');