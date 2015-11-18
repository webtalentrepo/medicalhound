<?php
$output = $css_class ='';

extract(shortcode_atts(array(
	'control_label'=>'',
	'control_name'=>'',
	'options'=>'',
	'help_text'=>'',
	'required'=>'',
	'disabled'=>'',
	'conditional'=>'',
	'el_class'=> '',
), $atts));

$label = esc_html($control_label);
$name = esc_attr($control_name);

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' '. $el_class,$this->settings['base'],$atts );

$output .='<div class="dhvc-form-group dhvc-form-'.$name.'-box '.$css_class.'">'."\n";
if(!empty($label)){
	$output .='<label class="dhvc-form-label">'.$label.(!empty($required) ? ' <span class="required">*</span>':'').'</label>' . "\n";
}
$output .='<div class="dhvc-form-radio'.(!empty($conditional) ? ' dhvc-form-conditional':'').'">'."\n";
if(!empty($options)){
	$options_arr = json_decode(base64_decode($options));
	global $dhvc_form;
	$options_arr = apply_filters('dhvc_form_radio_options', $options_arr,$dhvc_form,$name);
	if(!empty($options_arr)){
		$i = 0;
		foreach ($options_arr as $option){
			$id = uniqid('_');
			$output .='<label for="dhvc_form_control_'.sanitize_title($option->value).$id.'">';
			$output .= '<input '.(!empty($conditional) ? 'data-conditional-name="'.$name.'" data-conditional="'.esc_attr(base64_decode($conditional)).'"': '' ).' type="radio" '.(!empty($disabled) ? ' disabled':'').' class="dhvc-form-value dhvc-form-control-'.$name.' '.(!empty($required) && $i ==0 ? 'dhvc-form-required-entry':'').'"  id="dhvc_form_control_'.sanitize_title($option->value).$id.'" '.($option->is_default === 1 ? 'checked="checked"' :'').' name="'.$name.'" value="'.esc_attr($option->value).'"><i></i>';
			$output .= wp_kses_post($option->label);
			$output .= '</label>'."\n";
			$i++;
		}
	}
}
$output .='</div>';
if(!empty($help_text)){
	$output .='<span class="dhvc-form-help">'.$help_text.'</span>' . "\n";
}
$output .='</div>'."\n";

echo $output;