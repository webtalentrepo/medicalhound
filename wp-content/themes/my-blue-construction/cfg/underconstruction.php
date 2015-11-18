    <body <?php body_class( 'my-front-page' ); ?>>
        <div id="mytheme-wrapper">
            <div id="home-header">
                <?php 
                    if( strlen( esc_url( myThemes::get( 'under-construction-logo' ) ) ) ){
                        echo '<div class="logo-image"><img src="' . esc_url( myThemes::get( 'under-construction-logo' ) ) . '" /></div>';
                    }else{
                ?>
                        <h1 class="home"><?php bloginfo( 'name' ); ?></h1>
                        <p class="logo-description"><?php bloginfo( 'description' ); ?></p>
                <?php
                    }
                ?>
            </div>
            <div id="home-page"><!-- blank --></div>
            <div id="home-main"><!-- blank --></div>
            <div id="home-content">
                <div id="home-social">	
                    <?php
                        /* FACEBOOK */
                        if( strlen( esc_url( myThemes::get( 'social-facebook' ) ) ) ) { 
                            echo '<a href="' . esc_url( myThemes::get( 'social-facebook' ) ) . '" class="facebook" title="' . esc_attr__( 'facebook profile' , "mythemes" ) . ' : ' . esc_url( myThemes::get( 'social-facebook' ) ) . '">';
                            echo '</a>';
                        }

                        /* TWITTER */
                        if( strlen( esc_attr( myThemes::get( 'social-twitter' ) ) ) ) { 
                            echo '<a href="http://twitter.com/' . esc_attr( myThemes::get( 'social-twitter' ) ) . '" class="twitter" title="' . esc_attr__( 'twitter account' , "mythemes" ) . ' : ' . esc_attr( myThemes::get( 'social-twitter' ) ) . '">';
                            echo '</a>';
                        }

                        /* FEED */
                        if( (int) myThemes::get( 'social-rss' ) ){
                            echo '<a href="'; bloginfo( 'rss2_url' ); 
                            echo '" class="rss" title="' . esc_attr__( 'RSS Feed' , "mythemes" ) .'">';
                            echo '</a>';
                        }
                    ?>
                </div>

                <?php
                    if( strlen( esc_attr( myThemes::get( 'social-subscribe' ) ) ) ) {
                ?>
                        <div id="home-subscribe">
                            <form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="javascript:utils.feedburner( '<?php echo esc_attr( myThemes::get( 'social-subscribe' ) ); ?>' );">
                                <input type="text" class="text" name="email" value="<?php esc_attr_e( 'your email for subscription' , "mythemes" ); ?>" onfocus="javascript:utils.focusEvent( this , '<?php esc_attr_e( 'your email for subscription' , "mythemes" ); ?>' )" onblur="javascript:utils.blurEvent( this , '<?php esc_attr_e( 'your email for subscription' , "mythemes" ); ?>' )">
                                <input type="hidden" value="<?php echo esc_attr( myThemes::get( 'social-subscribe' ) ); ?>" name="uri">
                                <input type="hidden" name="loc" value="en_US">
                                <input type="submit" class="submit" value="">
                            </form>
                        </div>
                <?php
                    }
                ?>

                <div id="home-blog-info">
                    <?php
                        
                        $pid = myThemes::get( 'under-construction-page' );
                        global $wp_query;
                        $wp_query = new WP_Query( array(
                            'post_type' => 'page',
                            'post_status' => 'publish',
                            'p' => $pid
                        ) );
                        
                        echo '<div class="post-home-description">';

                        if(  $pid > 0 && count( $wp_query -> posts ) && $wp_query -> posts[ 0 ] -> ID == $pid  ) { /* SHOW PAGE ON FRONT PAGE */
                            
                            $post = $wp_query -> posts[ 0 ];
                            $wp_query -> the_post();
                            
                            if( has_post_thumbnail( $post -> ID ) ){
                                echo '<a href="' . get_permalink( $post -> ID ) . '">' . get_the_post_thumbnail( $post -> ID , 'thumbnail' ) .'</a>';
                            }

                            the_content();
                        }
                        else{ /* SHOW DEFAULT CONTENT ON FRONT PAGE */ 
                            echo do_shortcode( myThemes::get( 'under-construction-default-text' , true ) );
                        }
                        echo '<div class="clear"></div>';    
                        echo '</div>';
                    ?>
                </div>
            </div>
        </div>	
        <div id="home-footer">
            <div class="menu">
                <nav class="inline linet">
                    <?php
                        $location = get_nav_menu_locations();
                        if( isset( $location[ 'under-construction-menu' ] ) && $location[ 'under-construction-menu' ] > 0 ) {
                            wp_nav_menu( array( 'theme_location' => 'under-construction-menu' ) );
                        }
                    ?>
                </nav>
            </div>    
            <p class="home-footer"> 
                <?php echo myThemes::cfg( 'copyright' ); ?>
            </p>
            <?php wp_footer(); ?>
        </div>
    </body>
</html>