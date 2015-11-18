<?php
$output = $css_class ='';

extract(shortcode_atts(array(
	'captcha_type'=>'2',
	'type'=>'recaptcha',
	'theme'=>'',
	'language'=>'en',
	'control_label'=>'',
	'control_name'=>'',
	'placeholder'=>'',
	'help_text'=>'',
	'required'=>'1',
	'attributes'=>'',
	'el_class'=> '',
), $atts));
$name = esc_attr($control_name);
$label = esc_html($control_label);
if($captcha_type == '2'){
	
	if ( is_ssl() ) {
		$protocol_to_be_used = 'https://';
	} else {
		$protocol_to_be_used = 'http://';
	}
	dhvc_form_add_js_declaration("
	var dhreCatptcha_onloadCallback = function () {
	    grecaptcha.render( $name, {
	        'sitekey': '".dhvc_form_get_option('recaptcha_public_key')."',
	        'theme': 'light'
	    } );
	};
	");
	wp_register_script( 'dhvc-form-recaptcha2', "{$protocol_to_be_used}www.google.com/recaptcha/api.js?onload=dhreCatptcha_onloadCallback&render=explicit&hl=en", null, '1.0.0', false );
	wp_enqueue_script( 'dhvc-form-recaptcha2' );
}else{
	wp_enqueue_script('dhvc-form-recaptcha');
	dhvc_form_add_js_declaration('
	jQuery( document ).ready(function(){
		Recaptcha.create("' . dhvc_form_get_option('recaptcha_public_key') . '", "'.$name.'", {theme: "' . $theme . '",lang : \''.$language.'\',tabindex: 0});
	});
	');
}

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.'">'."\n";
if(!empty($label)){
	$output .='<label for="'.$name.'">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}
if($captcha_type == '2'){
	$site_key = dhvc_form_get_option('recaptcha_public_key');
	$secret_key	 = dhvc_form_get_option('recaptcha_private_key');
	if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
		$output .='<div type="recaptcha" class="dhvc-form-group-recaptcha dhvc-form-recaptcha2" id="'.$name.'"></div>';
	}else{
		$output .= __('Plese settup site Captcha in DHVC Form Settings',DHVC_FORM);
	}
}else{
	$output .='<div class="dhvc-form-group-recaptcha" id="'.$name.'"></div>';	
}

if(!empty($help_text)){
	$output .='<span class="help_text">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;
