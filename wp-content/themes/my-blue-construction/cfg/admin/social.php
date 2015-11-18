<?php
    {   /* SOCIAL OPTIONS */
        $sett = & acfg::$pages[ 'mytheme-social' ][ 'content' ];
        //mytheme_admin::save();
        
        $sett[ 'twitter' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'text'
            ),
            'label' => __( 'Fill this with your\'s twitter account' , "mythemes" ),
            'hint' => __( 'if you want to display twitter icon on front page'  , "mythemes" )
        );
        
        $sett[ 'facebook' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'text',
                'validator' => 'url'
            ),
            'label' => __( 'Facebook url' , "mythemes" ),
            'hint' => __( 'if you want to display on front page'  , "mythemes" )
        );
        
        $sett[ 'subscribe' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'text'
            ),
            'label' => __( 'Email feed Subscription'  , "mythemes" ),
            'hint' => __( 'Fill with Google FeedBurner account ex : ' , "mythemes" ) . 'http://feeds.feedburner.com/<strong>mythem_es</strong>'
        );
        
        $sett[ 'rss' ] = array(
            'type' => array(
                'template' => 'inline',
                'input' => 'logic'
            ),
            'label' => __( 'You want display Rss Feed' , "mythemes" )
        );
    }
?>