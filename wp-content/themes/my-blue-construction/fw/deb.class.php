<?php
	class deb{
		function e( $data )
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift( $bt );
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			print_r( $data );
			print "</pre>";
		}
		
		function dump( $data )
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			var_dump( $data );
			print "</pre>";
		}
		
		function html( $data )
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			print htmlspecialchars( $data );
			print "</pre>";
		}
		
		function post()
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			print_r( $_POST ) ;
			print "</pre>";
		}
		
		function get()
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			print_r( $_GET ) ;
			print "</pre>";
		}
		
		function request()
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			print_r( $_REQUEST ) ;
			print "</pre>";
		}
		
		function server()
        {
			print '<pre style="margin:10px; border:1px dashed #999999; padding:10px; color:#333; background:#ffffff;">';
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            print "[ File : " . self::short( $caller[ 'file' ] ) . " ][ Line : " . $caller[ 'line' ] . " ]\n";
            print "--------------------------------------------------------------\n";
			print_r( $_SERVER ) ;
			print "</pre>";
		}

        function short( $str )
        {
            if( MYTHEMES_SHORT_PATH ){
                $theme = wp_get_theme();
                $str = $theme[ 'Name' ] . ':' . str_replace( str_replace( '/' , '\\' , get_template_directory() ) , '' , $str );
            }
            return $str;
        }
	}
?>