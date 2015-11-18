<?php
    if( get_option( 'show_on_front' ) == 'page' ){
        get_template_part( 'page' );
    }
    else {
        get_template_part( 'index' );
    }
?>

