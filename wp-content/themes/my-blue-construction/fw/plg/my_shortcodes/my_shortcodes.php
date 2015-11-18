<?php

/*// ////////////////////////////////////////////////////////////////////////////
/// Shortcodes */

function _mytheme_autoload_shortcodes( $classname )
{
    my_shortcodes::load( $classname );
}

class my_shortcodes
{
    static $first_run = true;
    static $scs = array( );
	
    static function init( ) 
    {
        $currDir = dirname( __FILE__ );
        $data = include $currDir . '/scs.php';

        foreach( $data as $k => $v ) {
            $_k = $k;
            $_v = $v;
            if( !is_string( $k ) ) {
                $_k = $_v;
            }

            add_shortcode( $_k, array( "my_shortcodes", "run" ) );
            self::$scs[ "my_sc_" . $_k ] = $currDir . "/my_sc_{$_v}.php";
        }
    }

    static function load( $classname )
    {
        if( isset( self::$scs[ $classname ] ) ) {
            include_once( self::$scs[ $classname ] );
        }
    }

    static function run( $attr , $content , $tag )
    {
        if( self::$first_run ) {
            self::$first_run = false;

            /*// set autoload function //*/
            spl_autoload_register( '_mytheme_autoload_shortcodes' );

            wp_register_style( 'mythemes-sc-gallery',
                get_template_directory_uri( ) . '/fw/plg/my_shortcodes/my_sc_gallery.css'
            );
            wp_enqueue_style( 'mythemes-sc-gallery' );
        }

        $classname = "my_sc_$tag";
        $instance = new $classname;
        return $instance -> run( $attr, $content, $tag );
    }
}

my_shortcodes::init( );
?>