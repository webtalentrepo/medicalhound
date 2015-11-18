<?php
/// ////////////////////////////////////////////////////////////////////////////

define( "MYTHEME_SPAMTRAP_DOMAIN", "mailxu.com" );

/// ////////////////////////////////////////////////////////////////////////////

include dirname( __FILE__ ) . '/names.php';

/// ////////////////////////////////////////////////////////////////////////////

function mytheme_spamtrap_doy( ) 
{
	return date( 'z' );
}

/// ////////////////////////////////////////////////////////////////////////////

function mytheme_spamtrap_domain_id( ) 
{
	if( isset( $_SERVER[ 'HTTP_HOST' ] ) ) {
		$t = $_SERVER[ 'HTTP_HOST' ];
		$t = base_convert( md5( $t ), 16, 26 );
		for( $idx = 0; $idx < strlen( $t ); $idx++ ) {
			if( ord( $t[ $idx ] ) < ord( 'a' ) ) {
				$t[ $idx ] = chr( ord( $t[ $idx ] ) + 65 ); 
			}
		}
		return substr( $t, 0, 3 );
	}
	
	return 'wp';
}

/// ////////////////////////////////////////////////////////////////////////////

function mytheme_spamtrap_remail( $_idx = 0 )
{	
	global $MYTHEME_SPAMTRAP_SEP;
	global $MYTHEME_SPAMTRAP_FNAMES;
	global $MYTHEME_SPAMTRAP_LNAMES;
	
	$xday = time( ) + $_idx; 
	$sep = $MYTHEME_SPAMTRAP_SEP[ mt_rand( 0, count( $MYTHEME_SPAMTRAP_SEP ) - 1 ) ];
	
	$xname = $MYTHEME_SPAMTRAP_FNAMES[ $xday % count( $MYTHEME_SPAMTRAP_FNAMES ) ] . $sep;
	$xname .= $MYTHEME_SPAMTRAP_LNAMES[ mt_rand( 0, count( $MYTHEME_SPAMTRAP_LNAMES ) - 1 ) ];
			
	switch( mt_rand( 0, 8 ) ) {		
		case 0:
			$xname .= $sep;
			$xname .= mytheme_spamtrap_domain_id( );
			break;
		case 1:
			$xname .= $sep;
			$xname .= mytheme_spamtrap_doy( );
			break;
		default:
			break;
	}
	
	$xnameF = $xname . "@" . MYTHEME_SPAMTRAP_DOMAIN;
	
	switch( mt_rand( 0, 5 ) ) {
		case 1:
			return $xnameF;
		case 2:
			return "<a href='mailto:" . $xnameF . "'>" . $xname . "</a>";	
		default:
			return "<a href='mailto:" . $xnameF . "'>" . $xnameF . "</a>";
	} 

}

function mytheme_spamtrap_echo_trap( )
{	
	?>
	<div style="display: none;">
		<?php echo mytheme_spamtrap_remail( 0 ) . " \n"; ?>
	</div>
	<?php
}

add_action( 'wp_footer', 'mytheme_spamtrap_echo_trap' );

?>
