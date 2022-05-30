<?php

function fre_debug_style() {
    wp_enqueue_style( 'fre_debug_style', FRE_DEBUG_URL . 'assets/debug.css', array(), rand() );
}
add_action('wp_enqueue_scripts', 'fre_debug_style');