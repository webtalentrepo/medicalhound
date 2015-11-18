<?php
    {   /* FRONT PAGE OPTIONS */
        $sett = & acfg::$pages[ 'mytheme-front-page' ][ 'content' ];
        
        $sett[ 'logo' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'upload'
            ),
            'label' => __( 'Upload logo for front page' , "mythemes" ),
            'hint' => __( 'This logo will be used only on front page' , "mythemes" )
        );
        
        $sett[ 'menu-limit' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'digit'
            ),
            'label' => __( 'Set items limit for front page menu' , "mythemes" )
        );
    }
?>