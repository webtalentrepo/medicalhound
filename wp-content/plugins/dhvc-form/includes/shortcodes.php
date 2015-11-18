<?php
if(class_exists('WPBakeryShortCode')){
	
	function dhvc_form_textarea_variable_field($settings, $value){
		$param_line ='';
		$param_line .='<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
		$param_line .='<option value="">'.__('Insert variable...',DHVC_FORM).'</option>';
		foreach (dhvc_form_get_variables() as $label=>$key){
		$param_line .='<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
		}
		$param_line .='</select>';
		$param_line .= '<textarea name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textarea ' . $settings['param_name'] . ' ' . $settings['type'] . '">' . $value . '</textarea>';
		return $param_line;
			
	}
	add_shortcode_param('dhvc_form_textarea_variable', 'dhvc_form_textarea_variable_field');
	
	function dhvc_form_heading_field($settings, $value){
		return '<div style="background: none repeat scroll 0 0 #E1E1E1;font-size: 14px;font-weight: bold;padding: 5px 10px;">'.$value.'</div>';
	}
	add_shortcode_param('dhvc_form_heading', 'dhvc_form_heading_field');
	
	function dhvc_form_control_id_field($settings, $value){
		if(empty($value))
			$value = dhvc_form_gen_control_id();
		
		return '<input name="'.$settings['param_name'].'" class="wpb_vc_param_value dhvc-woo-param-value wpb-textinput" type="hidden" value="'.$value.'"/>';
	}
	add_shortcode_param('dhvc_form_control_id', 'dhvc_form_control_id_field');
	
	function dhvc_form_input_variable_field($settings, $value){
		$param_line ='';
		$param_line .='<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
		$param_line .='<option value="">'.__('Insert variable...',DHVC_FORM).'</option>';
		foreach (dhvc_form_get_variables() as $label=>$key){
			$param_line .='<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
		}
		$param_line .='</select>';
		$param_line .= '<input type="text" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
		return $param_line;
			
	}
	add_shortcode_param('dhvc_form_input_variable', 'dhvc_form_input_variable_field');
	
	function dhvc_form_name_field($param, $value){
		return '<input name="' . $param['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $param['param_name'] . ' ' . $param['type'] . '" type="text" value="' . $value . '"/>';
	}
	add_shortcode_param('dhvc_form_name', 'dhvc_form_name_field');
	
	function dhvc_form_validator_field($settings, $value){
		$value_arr = explode(',', $value);
		if(empty($value_arr))
			$value_arr = array();
		$param_line ='';
		$param_line .='<select onchange="dhvc_form_select_validator(this)" multiple class="dhvc-form-select-validator">';
		$param_line .='<option value="">'.__('Select validator...',DHVC_FORM).'</option>';
		foreach (dhvc_form_get_validation() as $label=>$key){
			$param_line .='<option value="'.esc_attr($key).'" '.(in_array($key, $value_arr) ? 'selected="selected"':'').'>'.esc_html($label).'</option>';
		}
		$param_line .='</select>';
		$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
		return $param_line;
		
	}
	add_shortcode_param('dhvc_form_validator', 'dhvc_form_validator_field');

	function dhvc_form_conditional_field($settings, $value){
		$value_64 = base64_decode($value);
		$value_arr = json_decode($value_64);
		$param_line ='';
		$param_line .='<div class="dhvc-form-conditional-list clearfix">';
		$param_line .= '<table>';
		$param_line .='<tbody>';
		if(is_array($value_arr) && !empty($value_arr)){
			foreach ($value_arr as $k=>$v){
				if(!property_exists($v,'element') || empty($v->element))
					continue;
				
				$param_line .='<tr>';
				$param_line .= '<td>';
				$param_line .='<label>'.__('If value this element',DHVC_FORM).'</label>';
				$param_line .='<select id="conditional-type" onchange="dhvc_form_conditional_select_type(this)">';
				$param_line .='<option '.selected($v->type,'=',false).' value="=">'.__('equals',DHVC_FORM).'</option>';
				$param_line .='<option '.selected($v->type,'>',false).' value=">">'.__('is greater than',DHVC_FORM).'</option>';
				$param_line .='<option '.selected($v->type,'<',false).' value="<">'.__('is less than',DHVC_FORM).'</option>';	
				$param_line .='<option '.selected($v->type,'not_empty',false).' value="not_empty">'.__('not empty',DHVC_FORM).'</option>';
				$param_line .='<option '.selected($v->type,'is_empty',false).' value="is_empty">'.__('is empty',DHVC_FORM).'</option>';
				$param_line .='</select>';
				$param_line .= '</td>';
				$param_line .= '<td>';
				$param_line .='<label>'.__('Value',DHVC_FORM).'</label>';
				$param_line .='<input type="text" id="conditional-value" value="'.esc_attr($v->value).'" />';
				$param_line .= '</td>';
				$param_line .= '<td>';
				$param_line .='<label>'.__('Then',DHVC_FORM).'</label>';
				$param_line .='<select id="conditional-action">';
				$param_line .='<option '.selected($v->action,'hide',false).' value="hide">'.__('Hide',DHVC_FORM).'</option>';
				$param_line .='<option '.selected($v->action,'show',false).' value="show">'.__('Show',DHVC_FORM).'</option>';
				$param_line .='</select>';
				$param_line .= '</td>';
				$param_line .= '<td>';
				$param_line .='<label>'.__('Element(s) name',DHVC_FORM).'</label>';
				$param_line .='<input type="text" placeholder="element_1,element_2" value="'.esc_attr($v->element).'" id="conditional-element" />';
				$param_line .= '</td>';
				$param_line .= '<td class="dhvc-form-conditional">';
				$param_line .='<a href="#" onclick="return dhvc_form_conditional_remove(this);"  id="conditional-remove" title="'.__('Remove',DHVC_FORM).'">-</a>';
				$param_line .= '</td>';
				$param_line .='</tr>';
			}
		}
		$param_line .='</tbody>';
		$param_line .='<tfoot>';
		$param_line .='<tr>';
		$param_line .= '<td colspan="5">';
		$param_line .='<a href="#" onclick="return dhvc_form_conditional_add(this);"  class="button" title="'.__('Add',DHVC_FORM).'">'.__('Add',DHVC_FORM).'</a>';
		$param_line .= '</td>';
		$param_line .='</tr>';
		$param_line .='</tfoot>';
		$param_line .= '</table>';
		$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
		$param_line .='</div>';
		return $param_line;
	}
	add_shortcode_param('dhvc_form_conditional', 'dhvc_form_conditional_field');
	
	function dhvc_form_rate_option_field($settings, $value){
		$value_64 = base64_decode($value);
		$value_arr = json_decode($value_64);
		if(empty($value_arr) && !is_array($value_arr)){
			
			for($i=0;$i<5;$i++){
				$value = $i+1;
				$option = new stdClass();
				$option->label = $value.'/5';
				$option->value = $value;
				$value_arr[] = $option;
			}
		}
		$param_line ='';
		$param_line .='<div class="dhvc-form-rate-option-list clearfix">';
		$param_line .= '<table>';
		$param_line .='<tbody>';
		if(is_array($value_arr) && !empty($value_arr)){
			foreach ($value_arr as $k=>$v){
				$param_line .='<tr>';
				$param_line .= '<td>';
				$param_line .='<input type="text" id="rate-label" value="'.esc_attr($v->label).'" />';
				$param_line .= '</td>';
				$param_line .= '<td>';
				$param_line .= __('Value',DHVC_FORM).':<span>'.esc_attr($v->value).'</span>';
				$param_line .='<input type="hidden" id="rate-value" value="'.esc_attr($v->value).'" />';
				$param_line .= '</td>';
				$param_line .= '<td class="dhvc-form-conditional">';
				$param_line .='<a href="#" onclick="return dhvc_form_rate_option_remove(this);"  title="'.__('Remove',DHVC_FORM).'">-</a>';
				$param_line .= '</td>';
				$param_line .='</tr>';
			}
		}
		$param_line .='</tbody>';
		$param_line .='<tfoot>';
		$param_line .='<tr>';
		$param_line .= '<td colspan="3">';
		$param_line .='<a href="#" onclick="return dhvc_form_rate_option_add(this);"  class="button" title="'.__('Add',DHVC_FORM).'">'.__('Add',DHVC_FORM).'</a>';
		$param_line .= '</td>';
		$param_line .='</tfoot>';
		$param_line .= '</table>';
		$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
		$param_line .='</div>';
		return $param_line;
	}
	add_shortcode_param('dhvc_form_rate_option', 'dhvc_form_rate_option_field');
	
	function dhvc_form_option_field($settings, $value){
		$value_64 = base64_decode($value);
		$value_arr = json_decode($value_64);
		if(empty($value_arr) && !is_array($value_arr)){
			for($i = 0;$i<2;$i++){
				$option = new stdClass();
				$option->is_default = 0;
				$option->label='Option'.$i;
				$option->value = 'value'.$i;
				$value_arr[] = $option;
			}
		}
		$param_line ='';
		$param_line .='<div class="dhvc-form-option-list clearfix" data-option-type="'.(isset($settings['option_checkbox']) ? 'checkbox' : 'radio').'">';
		$param_line .= '<table>';
		$param_line .= '<thead>';
		$param_line .='<tr>';
		$param_line .='<td>';
		$param_line .=__('Is Default',DHVC_FORM);
		$param_line .='</td>';
		$param_line .='<td>';
		$param_line .=__('Label',DHVC_FORM);
		$param_line .='</td>';
		$param_line .='<td>';
		$param_line .=__('Value',DHVC_FORM);
		$param_line .='</td>';
		$param_line .='<td>';
		$param_line .='</td>';
		$param_line .='</tr>';
		$param_line .= '</thead>';
		$param_line .='<tbody>';
		if(is_array($value_arr) && !empty($value_arr)){
			foreach ($value_arr as $k=>$v){
				$param_line .='<tr>';
				$param_line .= '<td>';
				$param_line .='<input type="'.(isset($settings['option_checkbox']) ? 'checkbox' : 'radio').'" name="is_default" id="is_default" '.checked($v->is_default,'1',false).' value="1" />';
				$param_line .= '</td>';
				$param_line .= '<td>';
				$param_line .='<input type="text" id="label" value="'.esc_html($v->label).'" />';
				$param_line .= '</td>';
				$param_line .= '<td>';
				$param_line .='<input type="text" id="value" value="'.esc_html($v->value).'" />';
				$param_line .= '</td>';
				$param_line .= '<td class="dhvc-form-conditional">';
				$param_line .='<a href="#" onclick="return dhvc_form_option_remove(this);"  title="'.__('Remove',DHVC_FORM).'">-</a>';
				$param_line .= '</td>';
				$param_line .='</tr>';
			}
		}
		$param_line .='</tbody>';
		$param_line .='<tfoot>';
		$param_line .='<tr>';
		$param_line .= '<td colspan="4">';
		$param_line .='<a href="#" onclick="return dhvc_form_option_add(this);" class="button" title="'.__('Add',DHVC_FORM).'">'.__('Add',DHVC_FORM).'</a>';
		$param_line .= '</td>';
		$param_line .='</tfoot>';
		$param_line .= '</table>';
		$param_line .= '<input type="hidden" name="' . $settings['param_name'] . '" class="wpb_vc_param_value wpb-textinput ' . $settings['param_name'] . ' ' . $settings['type'] . '" value="'.$value.'">' ;
		$param_line .='</div>';
		return $param_line;
	}
	add_shortcode_param('dhvc_form_option', 'dhvc_form_option_field');
	
	class WPBakeryShortCode_DHVC_Form extends WPBakeryShortCode {
		protected $_messages;
		
		public function loadTemplate( $atts, $content = null ) {
 			global $dhvc_form;
		
			$output = '';
			extract(shortcode_atts(array(
				'id'=>''
			), $atts));
			if(empty($id))
				return __('No form yet! You should add some...',DHVC_FORM);
				
			$form = get_post($id);
			$dhvc_form = $form;
			
			$method = get_post_meta($form->ID,'_method',true);
			$action = '';
			$action_type = get_post_meta($form->ID,'_action_type',true);
			if($action_type === 'external_url')
				$action = get_post_meta($form->ID,'_action_url',true);
				
			if($form && $form->post_status === 'publish'){

				wp_enqueue_style('js_composer_front');
				wp_enqueue_style('js_composer_custom_css');

				$output .='<div id="dhvcform-' . $form->ID . '"  class="dhvc-form-container dhvc-form-icon-pos-'.get_post_meta($form->ID,'_input_icon_position',true).' dhvc-form-'.get_post_meta($form->ID,'_form_layout',true).' dhvc-form-flat">'. "\n";
				$use_ajax = get_post_meta($form->ID,'_use_ajax',true);
				
				$key = md5('dhvc_form_'.$id);
				$form_msg = isset($_SESSION[$key]) && !empty($_SESSION[$key]) ? $_SESSION[$key] : '';

				$form_message = '';
				$form_message .='<div id="dhvc_form_message_'.$form->ID.'" class="dhvc-form-message '.(!empty($form_msg) ? '':'dhvc-form-hidden').'">'. "\n";

				if(!empty($form_msg) ){
					if(!empty($form_msg)){
						foreach ((array)$form_msg as $msg){
							$form_message .= $msg;
						}
						//unset this form message
						$_SESSION[$key] = null;
						unset($_SESSION[$key]);
					}
					
				}
				$form_message .='</div>'. "\n";
				if(get_post_meta($form->ID,'_message_position',true) !== 'bottom'){
					$output .=$form_message;
				}

				$output .= '<form data-popup="'.(get_post_meta($form->ID,'_form_popup',true) ? '1':'0').'" autocomplete="off" data-use-ajax="'.(int)$use_ajax.'" method="' . $method . '" class="dhvcform dhvcform-' . $form->ID . '" enctype="multipart/form-data"'.(!empty($action) ? ' action="' . $action . '"':'').'>' . "\n";
				$output .='<div style="display: none;">' . "\n";
				if($use_ajax){
					$output .='<input type="hidden" name="action" value="dhvc_form_ajax">' . "\n";
					$output .='<input type="hidden" name="_dhvc_form_is_ajax_call" value="1">' . "\n";
				}
				if($action_type === 'default'){
					$form_action = get_post_meta($form->ID,'_form_action',true);
					if(in_array($form_action, dhvc_form_get_actions())){
						$output .='<input type="hidden" name="_dhvc_form_action" value="'.$form_action.'">' . "\n";
					}
				}
				$output .='<input type="hidden" name="dhvc_form" value="'.$form->ID.'">' . "\n";
				$output .='<input type="hidden" name="form_url" value="'.esc_attr(dhvc_form_get_current_url()).'">' . "\n";
				$output .='<input type="hidden" name="referer" value="'.esc_attr(dhvc_form_get_http_referer()).'">' . "\n";
				$output .='<input type="hidden" name="post_id" value="'.get_the_ID().'">' . "\n";
				$output .='<input type="hidden" name="_dhvc_form_nonce" value="'.wp_create_nonce('dhvc-form-'.$form->ID).'">' . "\n";
				$output .='</div>' . "\n";
				$output .= '<div class="dhvc-form-inner">' . "\n";
				$output .= wpb_js_remove_wpautop($form->post_content);
				$output .= '</div>';
				
				if(!dhvc_form_has_submit_shortcode($form->ID)){
					$output .= '<div class="dhvc-form-action">' . "\n";
					$form_button = '<button type="submit" class="button dhvc-form-submit"><span class="dhvc-form-submit-label">'.__('Submit',DHVC_FORM).'</span><span class="dhvc-form-submit-spinner"></span></button>';
					$form_button = apply_filters('dhvc_form_action',$form_button,$form->ID);
					$output .= $form_button. "\n";
					$output .= '</div>' . "\n";
				}
				if(get_post_meta($form->ID,'_message_position',true) === 'bottom'){
					$output .= $form_message;
				}
				$output .= '</form>' . "\n";
				$output .= '</div>' . "\n";
				
				$output .= $this->_edit_form_link($id );
				
				return $output;
			}
			return __('No form yet! You should add some...',DHVC_FORM);
		}
		
		protected function _edit_form_link($id){
			if ( ! $form = get_post( $id ) )
				return;
		
			
			$action = '&amp;action=edit';
		
			$form_type_object = get_post_type_object( $form->post_type );
			if ( !$form_type_object )
				return;
		
			if ( !current_user_can( 'edit_dhvcform', $form->ID ) )
				return;
			
			$url= admin_url( sprintf( $form_type_object->_edit_link . $action, $form->ID ));
			$link = '<div class="edit-link" style="margin-top: 10px; text-align: right;"><a class="post-edit-link" href="' . $url . '">' . __('Edit Form',DHVC_FORM) . '</a></div>';
			return $link;
		}
	}
	
	class DHVC_Form_ShortCode extends WPBakeryShortCode {
		
		/**
		 * Find html template for shortcode output.
		 */
		protected function findShortcodeTemplate() {
			// Check template path in shortcode's mapping settings
			if(!empty($this->settings['html_template']) && is_file($this->settings('html_template'))) {
				return $this->setTemplate($this->settings['html_template']);
			}
			// Check template in theme directory
			$user_template = WPBakeryVisualComposer::getUserTemplate($this->getFilename().'.php');
			if(is_file($user_template)) {
				return $this->setTemplate($user_template);
			}
			// Check default place
			$default_dir = DHVC_FORM_TEMPLATE_DIR;
			if(is_file($default_dir.$this->getFilename().'.php')) {
				return $this->setTemplate($default_dir.$this->getFilename().'.php');
			}
		}
		protected function getFileName() {
			return $this->shortcode;
		}
		
		protected function loadTemplate( $atts, $content = null ) {
			if($this->shortcode !== 'dhvc_form_submit_button'){
				extract(shortcode_atts(array(
					'control_name'=>'',
				), $atts),EXTR_SKIP);
				if(empty($control_name))
					return __('Field name is required',DHVC_FORM);
			}
			return parent::loadTemplate($atts,$content);
		}
	}
	
	class WPBakeryShortCode_DHVC_Form_Text extends DHVC_Form_ShortCode {
		
	}
	
	class WPBakeryShortCode_DHVC_Form_Label extends DHVC_Form_ShortCode {
	
	}
	class WPBakeryShortCode_DHVC_Form_Rate extends DHVC_Form_ShortCode {
	
	}
	class WPBakeryShortCode_DHVC_Form_Slider extends DHVC_Form_ShortCode {
	
	}
	class WPBakeryShortCode_DHVC_Form_Email extends DHVC_Form_ShortCode {
	
	}
	
	class WPBakeryShortCode_DHVC_Form_Password extends DHVC_Form_ShortCode{
		protected function loadTemplate( $atts, $content = null ) {
			extract(shortcode_atts(array(
				'confirmation'=>'',
				'password_field'=>''
			), $atts),EXTR_SKIP);
			if(!empty($confirmation) && empty($password_field))
				return __('Passwords field name to validate match is required',DHVC_FORM);
				
			return parent::loadTemplate($atts,$content);
		}
	}
	
	class WPBakeryShortCode_DHVC_Form_Hidden extends DHVC_Form_ShortCode{
		
	} 
	
	class WPBakeryShortCode_DHVC_Form_reCaptcha extends DHVC_Form_ShortCode {
		public function loadTemplate( $atts, $content = null ) {
			$recaptcha_public_key = dhvc_form_get_option('recaptcha_public_key',false);
			if(!$recaptcha_public_key){
				echo __('ReCaptcha plugin needs a public key to be set in its parameters. Please contact a site administrator.',DHVC_FORM);
				return ;
			}
			return parent::loadTemplate($atts,$content);
		}
	}
	class WPBakeryShortCode_DHVC_Form_Captcha extends DHVC_Form_ShortCode {
		
	}
	class WPBakeryShortCode_DHVC_Form_DateTime extends DHVC_Form_ShortCode {
		
	}
	
	class WPBakeryShortCode_DHVC_Form_Color extends DHVC_Form_ShortCode {
		
	}
	
	class WPBakeryShortCode_DHVC_Form_Radio extends DHVC_Form_ShortCode {
	
	}
	class WPBakeryShortCode_DHVC_Form_Checkbox extends DHVC_Form_ShortCode {
	
	}
	class WPBakeryShortCode_DHVC_Form_File extends DHVC_Form_ShortCode {
		
	}
	class WPBakeryShortCode_DHVC_Form_Select extends DHVC_Form_ShortCode {
	
	}
	class WPBakeryShortCode_DHVC_Form_Multiple_Select extends WPBakeryShortCode_DHVC_Form_Select {
		protected function getFileName() {
			return 'dhvc_form_select';
		}
	}
	class WPBakeryShortCode_DHVC_Form_Textarea extends DHVC_Form_ShortCode {
		
	}
	
	class WPBakeryShortCode_DHVC_Form_Submit_Button extends DHVC_Form_ShortCode {
		
	}
}