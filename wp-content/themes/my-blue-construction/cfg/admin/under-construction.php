<?php
    {   /* FRONT PAGE OPTIONS */
        $sett = & acfg::$pages[ 'mytheme-under-construction' ][ 'content' ];
        //mytheme_admin::save();
        
        $sett[ 'logo' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'upload'
            ),
            'label' => __( 'Upload logo' , "mythemes" ),
            'hint' => __( 'This logo will be used only for under construction side' , "mythemes" )
        );
        
        $sett[ 'activate' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'logic'
            ),
            'action' => "{'t' : '.mytheme-used-page' , 'f' : '-' }",
            'label' => __( 'Activate under construction template' , "mythemes" ),
            'hint' => __( 'It will activate only on front page' , 'mythemes' )
        );
        
        if( (boolean)myThemes::pget( 'under-construction-activate' ) ){
            $pageClass = 'mytheme-used-page';
        }
        else{
            $pageClass = 'mytheme-used-page hidden';
        }
        
        $sett[ 'default-text' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'textarea',
                'validator' => 'noesc'
            ),
            'templateClass' => $pageClass,
            'label' => __( 'Default under construction description' , "mythemes" )
        );
        
        $sett[ 'page' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'search'
            ),
            'templateClass' => $pageClass,
            'query' => array( 'post_type' => 'page' , 'post_status' => 'published' ),
            'label' => __( 'Show content from page ( 600 chars )' , "mythemes" ),
            'hint' => __( 'Will display page content with do shortcodes' , "mythemes" )
        );
    }
?>