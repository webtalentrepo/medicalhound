<?php
$post_id = 0;
if (isset ( $_GET ['post'] ))
	$post_id = ( int ) $_GET ['post'];
elseif (isset ( $_POST ['post_ID'] ))
	$post_id = ( int ) $_POST ['post_ID'];
elseif (isset ( $_POST ['post_id'] ))
	$post_id = ( int ) $_POST ['post_id'];

if ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform') || (dhvc_is_editor () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform'))) || (dhvc_is_inline () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform'))) || (dhvc_is_editable () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform')))) :
	if (function_exists ( 'vc_disable_frontend' )) :
		vc_disable_frontend ();
	 else :
		if (class_exists ( 'NewVisualComposer' ))
			NewVisualComposer::disableInline ();
	endif;
endif;

if ((isset($_GET['page']) && ($_GET['page'] === 'vc_settings' || $_GET['page'] ==='wpb_vc_settings' || $_GET['page'] === 'vc-general')) || (isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform') || (dhvc_is_editor () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform'))) || ! is_admin () || (dhvc_is_inline () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform'))) || (dhvc_is_editable () && ((isset ( $_GET ['post_type'] ) && $_GET ['post_type'] === 'dhvcform') || (get_post_type ( $post_id ) === 'dhvcform')))) :
	
	vc_map ( array (
			"name" => __ ( "DHVC Form", DHVC_FORM ),
			"base" => "dhvc_form",
			'show_settings_on_create' => false,
			'content_element' => false 
	) );
	
	vc_map ( array (
			"name" => __ ( "Form Text", DHVC_FORM ),
			"base" => "dhvc_form_text",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-text",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Default value", DHVC_FORM ),
							"param_name" => "default_value" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Maximum length characters", DHVC_FORM ),
							"param_name" => "maxlength" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Icon", DHVC_FORM ),
							"param_name" => "icon",
							"param_holder_class" => 'dhvc-form-font-awesome',
							"value" => dhvc_form_font_awesome (),
							'description' => __ ( 'Select icon add-on for this control.', DHVC_FORM ) 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Read only ? ", DHVC_FORM ),
							"param_name" => "readonly",
							"value" => array (
									__ ( 'No', DHVC_FORM ) => 'no',
									__ ( 'Yes', DHVC_FORM ) => 'yes' 
							) 
					),
					array (
							"type" => "dhvc_form_validator",
							"heading" => __ ( "Add validator", DHVC_FORM ),
							"param_name" => "validator",
							"dependency" => array (
									'element' => "readonly",
									'value' => array (
											'no' 
									) 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Email", DHVC_FORM ),
			"base" => "dhvc_form_email",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-email",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Default value", DHVC_FORM ),
							"param_name" => "default_value" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Maximum length characters", DHVC_FORM ),
							"param_name" => "maxlength" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Icon", DHVC_FORM ),
							"param_name" => "icon",
							"param_holder_class" => 'dhvc-form-font-awesome',
							"value" => dhvc_form_font_awesome (),
							'description' => __ ( 'Select icon add-on for this control.', DHVC_FORM ) 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Read only ? ", DHVC_FORM ),
							"param_name" => "readonly",
							"value" => array (
									__ ( 'No', DHVC_FORM ) => 'no',
									__ ( 'Yes', DHVC_FORM ) => 'yes' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Label", DHVC_FORM ),
			"base" => "dhvc_form_label",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-label",
			"params" => array (
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							'type' => 'textarea_html',
							'holder' => 'div',
							'heading' => __ ( 'Text', DHVC_FORM ),
							'param_name' => 'content',
							'value' => __ ( '<p>I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Slider", DHVC_FORM ),
			"base" => "dhvc_form_slider",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-slider",
			"params" => array (
					array (
							"type" => "dropdown",
							"heading" => __ ( "Type", DHVC_FORM ),
							"param_name" => "type",
							"value" => array (
									__ ( 'Slider', DHVC_FORM ) => 'slider',
									__ ( 'Range', DHVC_FORM ) => 'range' 
							),
							'admin_label' => true 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Minimum Value", DHVC_FORM ),
							"param_name" => "minimum_value",
							"value" => 0 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Maximum Value", DHVC_FORM ),
							"param_name" => "maximum_value",
							"value" => 100 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Step", DHVC_FORM ),
							"param_name" => "step",
							"value" => 5 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Default value", DHVC_FORM ),
							"param_name" => "default_value" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_conditional",
							"heading" => __ ( "Conditional Logic", DHVC_FORM ),
							"param_name" => "conditional",
							"dependency" => array (
									'element' => "type",
									'value' => array (
											'slider' 
									) 
							),
							'description' => __ ( 'Create rules to show or hide this field depending on the values of other fields ', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Rate", DHVC_FORM ),
			"base" => "dhvc_form_rate",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-rate",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_rate_option",
							"heading" => __ ( "Options", DHVC_FORM ),
							"param_name" => "rate_option" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_conditional",
							"heading" => __ ( "Conditional Logic", DHVC_FORM ),
							"param_name" => "conditional",
							'description' => __ ( 'Create rules to show or hide this field depending on the values of other fields ', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Hidden", DHVC_FORM ),
			"base" => "dhvc_form_hidden",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-hidden",
			"params" => array (
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Default value", DHVC_FORM ),
							"param_name" => "default_value" 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Captcha", DHVC_FORM ),
			"base" => "dhvc_form_captcha",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-captcha",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form reCaptcha", DHVC_FORM ),
			"base" => "dhvc_form_recaptcha",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-recaptcha",
			"params" => array (
					array (
						"type" => "dropdown",
						"heading" => __ ( "reCaptcha Version", DHVC_FORM ),
						"param_name" => "captcha_type",
						'std'=>'2',
						"value" => array (
							__ ( 'Version 1', DHVC_FORM ) => '1',
							__ ( 'Version 2', DHVC_FORM ) => '2',
						),
						'description' => __ ( 'Select reCaptcha version you want use.', DHVC_FORM )
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Theme", DHVC_FORM ),
							"param_name" => "theme",
							"value" => array (
									__ ( 'Red', DHVC_FORM ) => 'red',
									__ ( 'Clean', DHVC_FORM ) => 'clean',
									__ ( 'White', DHVC_FORM ) => 'white',
									__ ( 'BlackGlass', DHVC_FORM ) => 'blackglass' 
							),
							"dependency" => array (
								'element' => "captcha_type",
								'value' => array (
									'1'
								)
							),
							'description' => __ ( 'Defines which theme to use for reCAPTCHA.', DHVC_FORM ) 
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Language", DHVC_FORM ),
							"param_name" => "language",
							"dependency" => array (
								'element' => "captcha_type",
								'value' => array (
									'1'
								)
							),
							"value" => dhvc_form_get_recaptcha_lang (),
							'description' => __ ( 'Select the language you would like to use for the reCAPTCHA display from the available options.', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form DateTime", DHVC_FORM ),
			"base" => "dhvc_form_datetime",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-datetime",
			"params" => array (
					array (
							"type" => "dropdown",
							"heading" => __ ( "Type", DHVC_FORM ),
							"param_name" => "type",
							'admin_label' => true,
							"value" => array (
									__ ( 'Date', DHVC_FORM ) => 'date',
									__ ( 'Time', DHVC_FORM ) => 'time' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Maximum length characters", DHVC_FORM ),
							"param_name" => "maxlength" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Read only ? ", DHVC_FORM ),
							"param_name" => "readonly",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Color", DHVC_FORM ),
			"base" => "dhvc_form_color",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-color",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "colorpicker",
							"heading" => __ ( "Default value", DHVC_FORM ),
							"param_name" => "default_value" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Read only ? ", DHVC_FORM ),
							"param_name" => "readonly",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Password", DHVC_FORM ),
			"base" => "dhvc_form_password",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-password",
			"params" => array (
					
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Is confirmation ? ", DHVC_FORM ),
							"param_name" => "confirmation",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Password field ", DHVC_FORM ),
							"param_name" => "password_field",
							"dependency" => array (
									'element' => "confirmation",
									'not_empty' => true 
							),
							'description' => __ ( 'enter passwords field name to validate match', DHVC_FORM ) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "dropdown",
							"heading" => __ ( "Icon", DHVC_FORM ),
							"param_name" => "icon",
							"param_holder_class" => 'dhvc-form-font-awesome',
							"value" => dhvc_form_font_awesome (),
							'description' => __ ( 'Select icon add-on for this control.', DHVC_FORM ) 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Read only ? ", DHVC_FORM ),
							"param_name" => "readonly",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Password validator ? ", DHVC_FORM ),
							"param_name" => "validator",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	
	vc_map ( array (
			"name" => __ ( "Form Radio", DHVC_FORM ),
			"base" => "dhvc_form_radio",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-radio",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_option",
							"heading" => __ ( "Options", DHVC_FORM ),
							"param_name" => "options" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Disabled ? ", DHVC_FORM ),
							"param_name" => "disabled",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "dhvc_form_conditional",
							"heading" => __ ( "Conditional Logic", DHVC_FORM ),
							"param_name" => "conditional",
							'description' => __ ( 'Create rules to show or hide this field depending on the values of other fields ', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	
	vc_map ( array (
			"name" => __ ( "Form File", DHVC_FORM ),
			"base" => "dhvc_form_file",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-file",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Checkboxes", DHVC_FORM ),
			"base" => "dhvc_form_checkbox",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-checkbox",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_option",
							"heading" => __ ( "Options", DHVC_FORM ),
							"param_name" => "options",
							'option_checkbox' => true 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Disabled ? ", DHVC_FORM ),
							"param_name" => "disabled",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "dhvc_form_conditional",
							"heading" => __ ( "Conditional Logic", DHVC_FORM ),
							"param_name" => "conditional",
							'description' => __ ( 'Create rules to show or hide this field depending on the values of other fields ', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Select", DHVC_FORM ),
			"base" => "dhvc_form_select",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-select",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_option",
							"heading" => __ ( "Options", DHVC_FORM ),
							"param_name" => "options" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Disabled ? ", DHVC_FORM ),
							"param_name" => "disabled",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_conditional",
							"heading" => __ ( "Conditional Logic", DHVC_FORM ),
							"param_name" => "conditional",
							'description' => __ ( 'Create rules to show or hide this field depending on the values of other fields ', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Multiple Select", DHVC_FORM ),
			"base" => "dhvc_form_multiple_select",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-select",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "dhvc_form_option",
							"heading" => __ ( "Options", DHVC_FORM ),
							"param_name" => "options",
							'option_checkbox' => true 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Disabled ? ", DHVC_FORM ),
							"param_name" => "disabled",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	vc_map ( array (
			"name" => __ ( "Form Textarea", DHVC_FORM ),
			"base" => "dhvc_form_textarea",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-textarea",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "control_label",
							'admin_label' => true 
					),
					array (
							"type" => "dhvc_form_name",
							"heading" => __ ( "Name", DHVC_FORM ),
							"param_name" => "control_name",
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Default value", DHVC_FORM ),
							"param_name" => "default_value" 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Placeholder text", DHVC_FORM ),
							"param_name" => "placeholder" 
					),
					array (
							"type" => "textarea",
							"heading" => __ ( "Help text", DHVC_FORM ),
							"param_name" => "help_text",
							'description' => __ ( 'This is the help text for this form control.', DHVC_FORM ) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Required ? ", DHVC_FORM ),
							"param_name" => "required",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "checkbox",
							"heading" => __ ( "Read only ? ", DHVC_FORM ),
							"param_name" => "readonly",
							"value" => array (
									__ ( 'Yes, please', DHVC_FORM ) => '1' 
							) 
					),
					array (
							"type" => "textfield",
							"heading" => __ ( "Attributes", DHVC_FORM ),
							"param_name" => "attributes",
							'description' => __ ( 'Add attribute for this form control,eg: <em>onclick="" onchange="" </em> or \'<em>data-*</em>\'  attributes HTML5, not in attributes: <span style="color:#ff0000">type, value, name, required, placeholder, maxlength, id</span>', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );
	
	vc_map ( array (
			"name" => __ ( "Form Button Submit", DHVC_FORM ),
			"base" => "dhvc_form_submit_button",
			"category" => __ ( "Form Control", DHVC_FORM ),
			"icon" => "icon-dhvc-form-submit-button",
			"params" => array (
					array (
							"type" => "textfield",
							"heading" => __ ( "Label", DHVC_FORM ),
							"param_name" => "label",
							'value'=>__('Submit',DHVC_FORM),
							'admin_label' => true,
							"description" => __ ( 'Field name is required.  Please enter single word, no spaces. Underscores(_) allowed', DHVC_FORM ) 
					),
					array (
							'type' => 'textfield',
							'heading' => __ ( 'Extra class name', DHVC_FORM ),
							'param_name' => 'el_class',
							'description' => __ ( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', DHVC_FORM ) 
					) 
			) 
	) );


endif;