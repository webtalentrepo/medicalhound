<?php
    class sett{
        
        static $deff;
        
		/* READ DEFAULT VALUES */
        function deff( $optName )
        {
            if( isset( self::$deff[ $optName ] ) ){
                return self::$deff[ $optName ];
            }else{
                return null;
            }
        }
        
		/* READ SETTINGS VALUE ( STRING FORMAT ) */
        function get( $optName , $strip = false )
        {
            if( $strip )
                return stripcslashes ( get_theme_mod( $optName , self::deff( $optName ) ) );
            else
                return get_theme_mod( $optName , self::deff( $optName ) );
        }
    };
?>