<?php
add_action('wp_loaded','ult_iframe_front');
/**
 *
 */
function ult_iframe_front(){

    if(isset($_GET['ult-front-frame'])){
        add_filter('show_admin_bar', '__return_false');
        add_filter( 'edit_post_link', '__return_false' );
        do_action('ultimatum/iframe/front');
        exit;
    }
}