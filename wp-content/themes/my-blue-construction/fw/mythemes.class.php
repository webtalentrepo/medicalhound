<?php
    class myThemes{
        
        function get( $optName , $strip = false )
        {
            return sett::get( 'mytheme-' . $optName , $strip );
        }
        
        function pget( $optName )
        {
            if( isset( $_POST ) && isset( $_POST[ 'mythemes-' . $optName ] ) )
                return $_POST[ 'mythemes-' . $optName ];
            else
                return self::get( $optName );
        }
        
        function cfg( $sett )
        {
            $file = get_template_directory() . '/cfg/static.php';
            
            if( file_exists( $file ) ){
                include $file;
                
                if( isset( $cfg[ $sett ] ) ){
                    if( is_array( $cfg[ $sett ] ) ){
                        if( isset( $cfg[ $sett ][ 'pageSlug' ] ) && isset( $cfg[ $sett ][ 'fieldName' ] ) ){
                            return sett::get( $cfg[ $sett ][ 'pageSlug' ] , $cfg[ $sett ][ 'fieldName' ] );
                        }
                        else{
                            return $cfg[ $sett ];
                        }
                    }
                    else{
                        return $cfg[ $sett ];
                    }
                }
                else{
                    return null;
                }
            }
            else{
                return null;
            }
        }
        
        function reg_menus( )
        {
            register_nav_menus( self::cfg( 'menus' ) );
        }
        
        function reg_sidebars( )
        {
            $sidebars = self::cfg( 'sidebars' );

            if( !empty( $sidebars ) ){
                foreach( $sidebars as $sidebar ){
                    register_sidebar( $sidebar );
                }
            }
        }
        
        /* INIT SCRIPTS */
        function init_scripts()
        {
            wp_enqueue_script( 'jquery' );
            
            wp_enqueue_script( 'js-utils' , get_template_directory_uri() . '/media/js/utils.js' );

            wp_enqueue_script(
                'js-pretty-photo',
                get_template_directory_uri( ) . '/media/js/jquery.prettyPhoto.js'
            );

            wp_enqueue_script(
                'settings-pretty-photo',
                get_template_directory_uri( ) . '/media/js/settings.prettyPhoto.js'
            );

            wp_enqueue_style(
                'css-pretty-photo',
                get_template_directory_uri( ) . '/media/css/prettyPhoto.css'
            );
            
            wp_enqueue_style( 'mythemes-style', get_stylesheet_uri() );

            /* INCLUDE FOR REPLY COMMENTS */
            if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
                    wp_enqueue_script( 'comment-reply' );
        }
        
        function pagination(){
            global $wp_query;
            if( (int) get_query_var('paged') > 0 ){
                $paged = get_query_var('paged');
            }else{
                if( (int) get_query_var('page') > 0 ){
                    $paged = get_query_var('page');
                }else{
                    $paged = 1;
                }
            }
            
            return $paged;
        }
        
        function title( $title, $sep )
        {    
            global $paged, $page;

            if ( is_feed() )
		return $title;

            /*/ Add the site name. */
            $title .= get_bloginfo( 'name' );

            /*/ Add the site description for the home/front page. */
            $site_description = get_bloginfo( 'description', 'display' );
            if ( $site_description && ( is_home() || is_front_page() ) )
                $title = "$title $sep $site_description";

            /*/ Add a page number if necessary. */
            if ( $paged >= 2 || $page >= 2 )
                $title = "$title $sep " . sprintf( __( 'Page %s', 'mythemes' ), max( $paged, $page ) );

            return $title;
        }
        
        function gravatar( $authorID , $size, $default = '' )
        {
            if( get_user_meta( $authorID , 'avatar' , true ) == -1 ){
                $result = '<img src="' . $default . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
            }else{
                if(  get_user_meta( $authorID , 'avatar' , true ) > 0 ){
                    $avatar_info = wp_get_attachment_image_src( get_user_meta( $authorID , 'avatar' , true ) , array( $size , $size ) );
                    $result = '<img src="' . $avatar_info[0] . '" height="' . $size . '" width="' . $size . '" alt="" class="photo avatar" />';
                }else{
                    $result = get_avatar( $authorID , $size , $default );
                }
            }
            
            return $result;
        }
        
        function comment( $comment, $args, $depth )
        {
            $GLOBALS['comment'] = $comment;
            switch ( $comment -> comment_type ) {
                case '' : {
                    echo '<li '; comment_class(); echo' id="li-comment-'; comment_ID(); echo '">';
                    echo '<div id="comment-'; comment_ID(); echo '" class="comment-box">';
                    echo '<header>';
                    echo '<span class="arrow"></span>';
                    echo myThemes::gravatar( $comment -> comment_author_email , 50 );
                    echo '<span class="comment-meta">';
                    echo '<time class="comment-time"><i class="icon-date"></i> ';
                    printf( '%1$s ' , get_comment_date() );
                    echo '</time>';
                    comment_reply_link( array_merge( $args , array( 
                        'reply_text' => __( 'Reply', 'mythemes' ),
                        'before' => '<span class="comment-replay">',
                        'after' => '</span>',
                        'depth' => $depth,
                        'max_depth' => $args['max_depth'] )
                    ) );
                    echo '</span>';
                    echo '<cite>';
                    echo get_comment_author_link( $comment -> comment_ID );
                    echo '</cite>';
                    echo '<div class="clear"></div>';
                    echo '</header>';

                    echo '<p class="comment-quote">';
                    if ( $comment -> comment_approved == '0' ) {
                        echo '<em class="comment-awaiting-moderation">';
                        _e( 'Your comment is awaiting moderation.' , 'mythemes' );
                        echo '</em>';
                    }
                    echo get_comment_text();            
                    echo '</p>';

                    echo '</div>';
                    echo '</li>';
                    break;
                }	
                case 'pingback'  :{
                }
                case 'trackback' : {
                    break;
                }
            }
        }
        
        function setup()
        {
            load_theme_textdomain( 'mythemes' );
            load_theme_textdomain( 'mythemes' , get_template_directory() . '/media/languages' );
    
            if ( function_exists( 'load_child_theme_textdomain' ) ){
                load_child_theme_textdomain( 'mythemes' );
            }
            add_editor_style();
	
            add_theme_support( 'automatic-feed-links' );

            add_theme_support( 'post-thumbnails' );
            set_post_thumbnail_size( 630, 9999 );
        }
        
        function rssThumbnail( $content )
        {
            global $post;
            if ( has_post_thumbnail( $post->ID ) ){
                $content = '' . get_the_post_thumbnail( $post -> ID, 'small-thumb' , array( 'style' => 'float:left; margin:0 15px 15px 0;' ) ) . '' . $content;
            }
            return $content;
        }
    }
?>