<?php
class mytheme_admin {
		
    static function pageHeader( $pageSlug )
    {
        echo '<div class="admin-menu">';
        echo '<ul>';
            
        $current_title = '';
            
        foreach( acfg::$pages as $slug => &$d ) {
            $title = $d[ 'menu' ][ 'label' ];
            $class = '';
            if( $slug == $pageSlug ) {	
                $class = 'current';
                $current_title = $title;
            }
            echo '<li class="' . $class . '"><a href="?page=' . $slug . '">' . $title . '</a></li>';
        }
			
        echo '</ul>';
        echo '</div>';
			
        $theme = wp_get_theme();
        echo '<div class="mytheme-admin-header">';
        echo '<img src="' . MYTHEMES_DEV_LOGO . '" />';
        echo '<span class="theme"><strong>' . $theme[ 'Name' ] . '</strong> ' . __( 'Version' , "mythemes" ) . ': ' . $theme[ 'Version' ]  . '</span>';
        echo '</div>';
    }
		
    static function pageContent( $pageSlug )
    {
        $st = & acfg::$pages[ $pageSlug ][ 'content' ];
            
        if( !empty( $_POST ) ){
            foreach( $_POST as $key => & $d ){
                if( substr( $key , 0 , 8 ) == 'mytheme-' ){
                    $fName = str_replace( $pageSlug . '-' , '' , $key );
                        
                    /* VALIDATE INFO BEFORE SAVE */
                    $validator = '';
                    if( isset( $_POST[ $key ] ) && isset( $st[ $fName ] ) )
                        $validator = ahtml::validator( $_POST[ $key ] , ahtml::getValidator( $st[ $fName ] ) );
                    
                    set_theme_mod( $key , $validator );
                }
            }
        }
            
        $cfgs = & acfg::$pages[ $pageSlug ];

        echo '<div class="admin-content">';
			
        /* PAGE TITLE */    
        echo '<div class="title">';

        if( isset( $cfgs[ 'title' ] ) )
            echo '<h2>' . $cfgs[ 'title' ] . '</h2>';

        if( isset( $cfgs[ 'description' ] ) )
            echo '<p>' . $cfgs[ 'description' ] . '</p>';
        
        echo '</div>';
			
        /* SUBMIT FORM */
        if( !isset( $cfgs[ 'update' ] ) || ( isset( $cfgs[ 'update' ] ) && $cfgs['update'] ) ){
            echo '<form method="post">';
        }
			
        settings_fields( $pageSlug );
			
        if( isset( $cfgs[ 'content' ] ) && !empty( $cfgs[ 'content' ] ) ) {
            foreach( $cfgs[ 'content' ] as $fieldName => $sett ) {
                $sett[ 'pageSlug' ]     = $pageSlug;
                $sett[ 'fieldName' ]    = $fieldName;
                $sett[ 'value' ]        = sett::get( $pageSlug . '-' . $fieldName );
                echo ahtml::template( $sett );
            }
        }
			
        /* SUBMIT BUTTON */
        if( !isset( $cfgs[ 'update' ] ) || ( isset( $cfgs[ 'update' ] ) && $cfgs['update'] ) ){
            echo '<div class="standart-generic-field submit">';
            echo '<div class="field">';
            echo '<input type="submit" class="button-primary my-submit" value="' . __( 'Update Settings' , "mythemes" ) . '"/>';
            echo '</div>';
            echo '</div>';
            echo '</form>';
        }
            
        echo '</div>';
    }
    
    function echoPage( )
    {	
        if( !isset( $_GET ) || !isset( $_GET[ 'page' ] ) ){
            wp_die( 'Invalid page name', "mythemes" );
            return;
        }

        $pageSlug = $_GET[ 'page' ];

        /* NOTIFICATION */
        if( isset( $_GET[ 'settings-updated' ] ) && $_GET[ 'settings-updated' ] == 'true' ){
            echo '<div class="updated settings-error myTheme" id="setting-error-settings_updated">';
            echo '<p>' . __( 'options has been updated successfully' , "mythemes" ) . '</p>';
            echo '</div>';
        }

        echo '<div class="admin-page">';
        self::pageHeader( $pageSlug );
        self::pageContent( $pageSlug );
        echo '</div>';
    }
		
    function init_mainMenu( ) 
    {
        $parent = '';
        $pageCB = array( 'mytheme_admin', 'echoPage' );
        foreach( acfg::$pages as $pageSlug => $d ) {	
            if( isset( $d[ 'menu' ] ) ) {
                $m = $d[ 'menu' ];
                if( strlen( $parent ) == 0 ) {
                    add_theme_page(
                        $m[ 'label' ],                                          /* page_title   */
                        $m[ 'label' ],                                          /* menu_title   */
                        'administrator',                                        /* capability   */
                        $pageSlug,                                              /* menu_slug    */
                        $pageCB,                                                /* function     */
                        $m[ 'ico' ]                                             /* icon_url     */
                    );
                    $parent = $pageSlug;
                }
                else{
                    add_theme_page(
                        'myThemes'
                        ."&nbsp;&raquo;&nbsp;".$m[ 'label' ]                    /* page_title   */
                        , "&nbsp;&raquo;&nbsp;".$m[ 'label' ]                   /* menu_title   */
                        , 'administrator'                                       /* capability   */
                        , $pageSlug                                             /* menu_slug    */
                        , $pageCB                                               /* function     */
                    );
                }
            }
        }
    }
        
    function init_settings( )
    {            
        foreach( acfg::$pages as $pageSlug => $d ) {
            if( isset( $d[ 'content' ] ) &&
                !empty( $d[ 'content' ] ) &&
                is_array( $d[ 'content' ] ) )
            {
                foreach( $d[ 'content' ] as $fieldName => $sett ){
                    register_setting( $pageSlug ,  $pageSlug . '-' . $fieldName );
                }
            }
        }
    }
        
    function load_css()
    {
        if( is_admin() ){
            wp_enqueue_style( 'farbtastic' );
            wp_enqueue_style( 'ui-lightness' );
            wp_enqueue_style( 'thickbox' );

            wp_register_style( 'admin' ,  get_template_directory_uri() . '/media/admin/css/admin.css' );
            wp_register_style( 'inline' ,  get_template_directory_uri() . '/media/admin/css/inline.css' );

            wp_enqueue_style( 'admin' );
            wp_enqueue_style( 'inline' );
        }
    }
        
    function load_js()
    {
        if( is_admin( ) ){
            wp_register_script( 'autocomplete',
                get_template_directory_uri() . '/media/admin/js/autocomplete.js', 
                array( 'jquery' , 'media-upload' , 'thickbox' )
            );

            wp_register_script( 'fields' ,  get_template_directory_uri() . '/media/admin/js/fields.js' ) ;
            wp_register_script( 'tools' ,  get_template_directory_uri() . '/media/admin/js/tools.js' ) ;

            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'thickbox' );

            /* INCLUDE FARBTASTIC JS */
            $siteurl = get_option('siteurl');

            if( !empty($siteurl) )
                $farbtastic_url = rtrim( $siteurl , '/') . '/wp-admin/js/farbtastic.js' ;
            else
                $farbtastic_url = home_url('/wp-admin/js/farbtastic.js');

            wp_register_script( 'my-farbtastic' , $farbtastic_url );
            wp_enqueue_script( 'my-farbtastic' );
        }

        wp_enqueue_script( 'autocomplete' );
        wp_enqueue_script( 'fields' );
        wp_enqueue_script( 'tools' );
    }
}

add_action( 'admin_menu' , array( 'mytheme_admin', 'init_mainMenu' ) );
add_action( 'admin_init' , array( 'mytheme_admin', 'init_settings' ) );
add_action( 'init' , array( 'mytheme_admin' , 'load_js' ) );
add_action( 'init' , array( 'mytheme_admin' , 'load_css' ) );
?>