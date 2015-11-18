<?php
    $cfg = array(
        
        /* FOOTER SETTINGS */
        'copyright' => '<span>Copyright &copy; 2010. Powered by</span> <a href="http://wordpress.org" target="_blank">WordPress</a><span>. Designed by </span><a href="http://mythem.es" target="_blank" title="myThemes - HTML5, CSS3, creative design and premium WordPress themes">myThem.es</a>',
        
        /* MENUS SETTINGS */
        'menus' => array(
            'base-menu' => __( 'Base Menu' , "mythemes" ),
            'under-construction-menu' => __( 'Under Construction Menu' , "mythemes" )
        ),
        
        /* SIDEBARS SETTINGS */
        'sidebars' => array(
            array(
                'name' => __( 'General Sidebar' , "mythemes" ),
                'id' => 'blog_sidebar',
                'description' => __( 'Sidebar for Blog section' , "mythemes" ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="sidebartitle">',
                'after_title' => '</h4>',
            )
        )
    );
?>