<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title( '|', true, 'right' ); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <style type="text/css" media="screen">
            <?php
                echo myThemes::get( 'general-custom-css' );
            ?>
        </style>
        <?php wp_head(); ?>
    </head>
    <?php
        if( is_front_page() && myThemes::get( 'under-construction-activate' ) ){
            get_template_part( 'cfg/underconstruction' );
            exit();
        }
    ?>
<body <?php body_class(); ?>>
    <div id="header">	
						
        <div id="social">
			
            <?php 
                if( (int) myThemes::get( 'social-rss' ) ){
            ?>
                    <a href="<?php bloginfo('rss2_url'); ?>" class="rss" title="<?php esc_attr_e( 'RSS Feed' , "mythemes" ); ?>"><img src="<?php echo get_template_directory_uri() ; ?>/resource/images/_rss-hover.png" width="1" height="1" alt="" /></a>
            <?php
                }
                
                if( strlen( esc_url( myThemes::get( 'social-facebook' ) ) ) ){ 
                        echo '<a href="' . esc_url( myThemes::get( 'social-facebook' ) ) . '" class="facebook" title="' . esc_attr__( 'facebook profile : ' , "mythemes" ) . esc_url( myThemes::get( 'social-facebook' ) ) . '"><img src="' . get_template_directory_uri() . '/resource/images/_facebook-hover.png" width="1" height="1" alt="" /></a>';
                }

                if( strlen( esc_attr( myThemes::get( 'social-twitter' ) ) ) ){ 
                        echo '<a href="http://twitter.com/' . esc_attr( myThemes::get( 'social-twitter' ) ) . '" class ="twitter" title="' . esc_attr__( 'twitter account : ', "mythemes" ) . esc_attr( myThemes::get( 'social-twitter' ) ) . '"><img src="' . get_template_directory_uri( ) . '/resource/images/_twitter-hover.png" width="1" height="1" alt="" /></a>';
                }  
            ?>				
        </div>
		
        <div id="blog-info">
            <?php
                $logo = myThemes::get( 'general-logo' );

                if( strlen( $logo ) ){
                    echo '<a href="' . home_url() . '" title="' . get_option( 'blogname' ) . ' - ' . get_option( 'blogdescription' ) .  '"><img src="' . $logo . '" alt="' . get_option( 'blogname' ) . ' - ' . get_option( 'blogdescription' ) .  '" /></a>';
                }else{
                    echo '<h1><a href="' . home_url() . '" title="' . get_option( 'blogname' ) . ' - ' . get_option( 'blogdescription' ) .  '">' . get_option( 'blogname' ) . '</a></h1>';
                    echo '<p class="description">' . get_option( 'blogdescription' ) . '</p>';
                }
            ?>
        </div>
		
        <div class="menu" id="my-header-menu">
            <nav class="line inline">
                <?php wp_nav_menu( array( 'theme_location' => 'base-menu' ) ); ?>
            </nav>
        </div>
    </div>