<?php
    $pages = & acfg::$pages;
    
    $pages = array(
        /* MAIN PAGE */
        'mytheme-general' => array(
            'menu' => array(
                'label' => 'myThemes Options',
                'ico'	=> '',
            ),
            'title' => __( 'General Settings' , "mythemes" ),
            'description' => '',
        ),
		
        /* SUBPAGES */
        'mytheme-under-construction' => array(
            'menu' => array(
                'label' => __( 'Under Construction' , "mythemes" ),
            ),
			
            'title' => __( 'Under Construction Settings' , "mythemes" ),
            'description' => '',
            'content' => array(	),
        ),
        
        'mytheme-social' => array(
            'menu' => array(
                'label' => __( 'Social' , "mythemes" ),
            ),
			
            'title' => __( 'Social Settings' , "mythemes" ),
            'description' => '',
            'content' => array(),
        )
    );
?>