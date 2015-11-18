<?php

class DHVCFormEmail {
	
	protected $data = array();
	protected $email = '';
	protected $html = false;
	protected $dhvc_form_use_email_empty_field_value = true;
	
	public function __construct($email='',$data=array()){
		$this->data = $data;
		$this->email = $email;
		$this->dhvc_form_use_email_empty_field_value = apply_filters('dhvc_form_use_email_empty_field_value', true);
	}
	
	
	public function replace_mail_tags( ){
		$regex = '/(\[?)\[[\t ]*'
				. '([a-zA-Z_][0-9a-zA-Z:._-]*)' // [2] = name
				. '[\t ]*\](\]?)/';
		
		$callback = array( $this, '_mail_callback' );
		
		return preg_replace_callback( $regex, $callback, $this->email );
	}
	
	protected function _mail_callback($matches){
		// allow [[foo]] syntax for escaping a tag
		if ( $matches[1] == '[' && $matches[4] == ']' )
			return substr( $matches[0], 1, -1 );
		
		$tag = $matches[0];
		$tagname = $matches[2];
		if ( isset( $this->data[$tagname] ) ) {
			$submitted = $this->data[$tagname];
			if(!$this->dhvc_form_use_email_empty_field_value && empty($submitted) ){
				return '';
			}
			$replaced = $submitted;
			
			$output = array();
			foreach ( (array) $replaced as $value )
				$output[] = trim( (string) $value );
			
			$replaced = implode( ', ', $output );
			return wp_unslash( $replaced );
		}
		
		return $tag;
	}
}