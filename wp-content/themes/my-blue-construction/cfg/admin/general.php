<?php
    {   /* myTheme GENERAL OPTIONS */
        $sett = & acfg::$pages[ 'mytheme-general' ][ 'content' ];
        
        $sett[ 'logo' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'upload'
            ),
            'label' => __( 'Upload logo' , "mythemes" ),
            'hint' => __( 'This logo will be used only for blog and presentation side' , "mythemes" )
        );
        
        $sett[ 'sidebar' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'select'
            ),
            'values' => array(
                'left' => __( 'Left sidebar'  , "mythemes" ),
                'right' => __( 'Right sidebar' , "mythemes" )
            ),
            'label' => __( 'Select blog sidebar position' , "mythemes" ),
        );
        
        $sett[ 'custom-css' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'textarea'
            ),
            'label' => __( 'Set custom CSS' , "mythemes" )
        );
    }
?>