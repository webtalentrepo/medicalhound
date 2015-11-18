<?php
class DHVCFormAdmin {
	
	protected $setting_fields = array();
	protected $meta_boxs = array();
	public function __construct(){
		
		add_action( 'admin_init',array( &$this, 'check_version' ), 1 );
		
		add_action('admin_init', array(&$this,'init'));
		
		add_action( 'admin_print_scripts', array( &$this, 'setting_assets' ) );
		
		add_filter( 'post_updated_messages', array( &$this, 'post_updated_messages' ) );
		add_action( 'admin_print_scripts', array( &$this, 'disable_autosave' ) );
		
		add_action('admin_menu',array(&$this,'admin_menu'));
		
		add_action('delete_post', array(&$this,'delete_post'));
		add_action( 'save_post', array(&$this,'save_post'),1,2 );
		
		// Admin Columns
		add_filter( 'manage_edit-dhvcform_columns', array( $this, 'edit_columns' ) );
		add_action( 'manage_dhvcform_posts_custom_column', array( $this, 'custom_columns' ), 2 );
		
		add_action( 'add_meta_boxes', array( &$this, 'remove_meta_boxes' ), 1000 );
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ), 30 );
		
		// Views and filtering
		add_filter( 'views_edit-dhvcform', array( &$this, 'custom_order_views' ) );
		add_filter( 'post_row_actions', array( $this, 'remove_row_actions' ), 10, 1 );
		add_filter( 'post_row_actions', array( $this, 'add_row_actions' ), 10, 2 );
		
		add_action( 'current_screen', array( $this, 'conditonal_includes' ) );
		
	}
	
	// check for use wp_registration_url
	
	public function check_version(){
		global $wp_version;
		
		if ( version_compare( $wp_version, '3.6', '<' ) ) {
			add_action( 'admin_notices', array( $this, 'version_notification' ) );
			if ( is_plugin_active( plugin_basename(DHVC_FORM_FILE ) )){
				deactivate_plugins( plugin_basename(DHVC_FORM_FILE ) );
			}
		}
	}
	
	public function version_notification(){
		global $wp_version;
		
		$html  = '<div class="error"><p>';
		$html .= sprintf( __( 'Custom Login has been deactivated because it requires a WordPress version greater than 3.6. You are running <code>%s</code>', DHVC_FORM ), $wp_version );
		$html .= '</p></div>';
		
		echo $html;
	}
	
	public function setting_assets(){
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
		wp_register_script('dhvc-form-setting',DHVC_FORM_URL.'/assets/js/admin.js', array('jquery','wpb_js_composer_js_custom_views','thickbox'), DHVC_FORM_VERSION,true);
		wp_register_style('dhvc-form-setting',DHVC_FORM_URL.'/assets/css/admin.css', array('thickbox'), DHVC_FORM_VERSION);
		
		$conditional_tmpl = '';
		$conditional_tmpl .='<tr>';
		$conditional_tmpl .= '<td>';
		$conditional_tmpl .='<label>'.__('If value this element',DHVC_FORM).'</label>';
		$conditional_tmpl .='<select id="conditional-type" onchange="dhvc_form_conditional_select_type(this)">';
		$conditional_tmpl .='<option value="=">'.__('equals',DHVC_FORM).'</option>';
		$conditional_tmpl .='<option value=">">'.__('is greater than',DHVC_FORM).'</option>';
		$conditional_tmpl .='<option value="<">'.__('is less than',DHVC_FORM).'</option>';
		$conditional_tmpl .='<option value="not_empty">'.__('not empty',DHVC_FORM).'</option>';
		$conditional_tmpl .='<option value="is_empty">'.__('is empty',DHVC_FORM).'</option>';
		$conditional_tmpl .='</select>';
		$conditional_tmpl .= '</td>';
		$conditional_tmpl .= '<td>';
		$conditional_tmpl .='<label>'.__('Value',DHVC_FORM).'</label>';
		$conditional_tmpl .='<input type="text" id="conditional-value" />';
		$conditional_tmpl .= '</td>';
		$conditional_tmpl .= '<td>';
		$conditional_tmpl .='<label>'.__('Then',DHVC_FORM).'</label>';
		$conditional_tmpl .='<select id="conditional-action">';
		$conditional_tmpl .='<option value="hide">'.__('Hide',DHVC_FORM).'</option>';
		$conditional_tmpl .='<option value="show">'.__('Show',DHVC_FORM).'</option>';
		$conditional_tmpl .='</select>';
		$conditional_tmpl .= '</td>';
		$conditional_tmpl .= '<td>';
		$conditional_tmpl .='<label>'.__('Element(s) name',DHVC_FORM).'</label>';
		$conditional_tmpl .='<input type="text" placeholder="element_1,element_2" id="conditional-element" />';
		$conditional_tmpl .= '</td>';
		$conditional_tmpl .= '<td class="dhvc-form-conditional">';
		$conditional_tmpl .='<a href="#" onclick="dhvc_form_conditional_remove(this);"  id="conditional-remove" title="'.__('Remove',DHVC_FORM).'">-</a>';
		$conditional_tmpl .= '</td>';
		$conditional_tmpl .='</tr>';
		
		$rate_option_tmpl = '';
		$rate_option_tmpl .='<tr>';
		$rate_option_tmpl .= '<td>';
		$rate_option_tmpl .='<input type="text" id="rate-label" value="" />';
		$rate_option_tmpl .= '</td>';
		$rate_option_tmpl .= '<td>';
		$rate_option_tmpl .= __('Value',DHVC_FORM).':<span></span>';
		$rate_option_tmpl .='<input type="hidden" id="rate-value" value="" />';
		$rate_option_tmpl .= '</td>';
		$rate_option_tmpl .= '<td class="dhvc-form-conditional">';
		$rate_option_tmpl .='<a href="#" onclick="dhvc_form_rate_option_remove(this);"  title="'.__('Remove',DHVC_FORM).'">-</a>';
		$rate_option_tmpl .= '</td>';
		$rate_option_tmpl .='</tr>';
		
		$option_tmpl = '';
		$option_tmpl .='<tr>';
		$option_tmpl .= '<td>';
		$option_tmpl .='<input type="radio" id="is_default" value="1" name="is_default" />';
		$option_tmpl .= '</td>';
		$option_tmpl .= '<td>';
		$option_tmpl .='<input type="text" id="label" value="" />';
		$option_tmpl .= '</td>';
		$option_tmpl .= '<td>';
		$option_tmpl .='<input type="text" id="value" value="" />';
		$option_tmpl .= '</td>';
		$option_tmpl .= '<td class="dhvc-form-conditional">';
		$option_tmpl .='<a href="#" onclick="dhvc_form_option_remove(this);"  title="'.__('Remove',DHVC_FORM).'">-</a>';
		$option_tmpl .= '</td>';
		$option_tmpl .='</tr>';
		
		$recipient_tmpl = '';
		$recipient_tmpl .=  '<tr>';
		$recipient_tmpl .=  '<td>';
		$recipient_tmpl .=  '<input type="text" name="" value="" />';
		$recipient_tmpl .=  '</td>';
		$recipient_tmpl .=  '<td>';
		$recipient_tmpl .=  '<a href="#" class="button" onclick="return dhvc_form_recipient_remove(this)">'.__('Remove',DHVC_FORM).'</a>';
		$recipient_tmpl .=  '</td>';
		$recipient_tmpl .=  '</tr>';
		
		wp_localize_script('dhvc-form-setting', 'dhvcformAdminL10n', array(
			'ajax_url'=>admin_url( 'admin-ajax.php', 'relative' ),
			'plugin_url'=>DHVC_FORM_URL,
			'delete_confirm'=>__('Are your sure?',DHVC_FORM),
			'conditional_tmpl'=>$conditional_tmpl,
			'rate_option_tmpl'=>$rate_option_tmpl,
			'option_tmpl'=>$option_tmpl,
			'recipient_tmpl'=>$recipient_tmpl,
		));
		wp_enqueue_style('dhvc-form-font-awesome');
		wp_enqueue_script('dhvc-form-setting');
		wp_enqueue_style('dhvc-form-setting');
		
	}
	
	
	public function init(){
		
		register_setting('dhvc_form','dhvc_form');
		if(post_type_exists('dhvcform')){
			if(class_exists('WPBakeryVisualComposer') && method_exists('WPBakeryVisualComposer', 'isTheme') && WPBakeryVisualComposer::getInstance()->isTheme()){
				$wpb_js_content_types = 'wpb_js_theme_content_types';
			}else{
				$wpb_js_content_types = 'wpb_js_content_types';
			}
			$pt_array = ( $pt_array = get_option( $wpb_js_content_types ) ) ? ( $pt_array ) :  array( 'page' );

			if(!in_array('dhvcform', $pt_array)){
				array_push($pt_array,'dhvcform');
				update_option($wpb_js_content_types, $pt_array);
			}
			
		}
		
		$this->setting_fields = array(
				'general'=>array(
					'type'=>'heading',
					'label'=>__('General settings',DHVC_FORM),
				),
				'allowed_file_extension'=>array(
					'type'=>'textarea',
					'default'=>'zip,rar,tar,7z,jpg,jpeg,png,gif,pdf,doc,docx,ppt,pptx,xls,xlsx',
					'label'=>__('Allowed Files Upload Types',DHVC_FORM),
					'help'=>__('Which files are allowed in the attachments? (Separate the extensions by a comma)',DHVC_FORM),
				),
				'date_format'=>array(
					'type'=>'text',
					'label'=>__('Date Format',DHVC_FORM),
					'default'=>'Y/m/d',
				),
				'time_format'=>array(
					'type'=>'text',
					'label'=>__('Time Format',DHVC_FORM),
					'default'=>'H:i',
					'help'=>sprintf('<a href="http://codex.wordpress.org/Formatting_Date_and_Time">%s</a>',__('Documentation on date and time formatting',DHVC_FORM))
				),
				'time_picker_step'=>array(
					'type'=>'select',
					'label'=>__('Time picker step',DHVC_FORM),
					'default'=>'60',
					'options'=>array(
						'5'=>5,
						'10'=>10,
						'15'=>15,
						'30'=>30,
						'60'=>60,
					),
				),
				'datetimepicker_lang'=>array(
					'type'=>'select',
					'label'=>__('Datetime Picker Language',DHVC_FORM),
					'default'=>'en',
					'options'=>array(
						'ar'=>'Arabic',
						'az'=>'Azerbaijanian (Azeri)',
						'bg'=>'Bulgarian',
						'bs'=>'Bosanski',
						'ca'=>'Català',
						'ch'=>'Simplified Chinese',
						'cs'=>'Čeština',
						'da'=>'Dansk',
						'de'=>'German',
						'el'=>'Ελληνικά',
						'en'=>'English',
						'en-GB'=>'English (British)',
						'es'=>'Spanish',
						'et'=>'"Eesti"',
						'eu'=>'Euskara',
						'fa'=>'Persian',
						'fi'=>'Finnish (Suomi)',
						'fr'=>'French',
						'gl'=>'Galego',
						'he'=>'Hebrew (עברית)',
						'hr'=>'Hrvatski',
						'hu'=>'Hungarian',
						'id'=>'Indonesian',
						'it'=>'Italian',
						'ja'=>'Japanese',
						'ko'=>'Korean (한국어)',
						'kr'=>'Korean',
						'lt'=>'Lithuanian (lietuvių)',
						'lv'=>'Latvian (Latviešu)',
						'mk'=>'Macedonian (Македонски)',
						'mn'=>'Mongolian (Монгол)',
						'nl'=>'Dutch',
						'no'=>'Norwegian',
						'pl'=>'Polish',
						'pt'=>'Portuguese',
						'pt-BR'=>'Português(Brasil)',
						'ro'=>'Romanian',
						'ru'=>'Russian',
						'se'=>'Swedish',
						'sk'=>'Slovenčina',
						'sl'=>'Slovenščina',
						'sq'=>'Albanian (Shqip)',
						'sr'=>'Serbian Cyrillic (Српски)',
						'sr-YU'=>'Serbian (Srpski)',
						'sv'=>'Svenska',
						'th'=>'Thai',
						'tr'=>'Turkish',
						'uk'=>'Ukrainian',
						'vi'=>'Vietnamese',
						'zh'=>'Simplified Chinese (简体中文)',
						'zh-TW'=>'Traditional Chinese (繁體中文)',
					),
				),
				'container_class'=>array(
					'type'=>'text',
					'label'=>__('Conditional Container Element',DHVC_FORM),
					'default'=>'.vc_row-fluid',
				),
				'user'=>array(
						'type'=>'heading',
						'label'=>__('Users page settings',DHVC_FORM),
				),
				'user_login'=>array (
						"type" => "select",
						"label" => __ ( "Login page", DHVC_FORM ),
						"options" => dhvc_form_get_pages(true),
				),
				'user_logout_redirect_to'=>array (
						"type" => "select",
						"label" => __ ( "Logout redirect to page", DHVC_FORM ),
						"options" => dhvc_form_get_pages(true),
				),
				'user_regiter'=>array (
						"type" => "select",
						"label" => __ ( "Register page", DHVC_FORM ),
						"options" => dhvc_form_get_pages(true),
				),
				'user_forgotten'=>array (
						"type" => "select",
						"label" => __ ( "Lost password page", DHVC_FORM ),
						"options" => dhvc_form_get_pages(true),
				),
				'email'=>array(
						'type'=>'heading',
						'label'=>__('Email settings',DHVC_FORM),
				),
				'email_method'=>array(
						'type'=>'select',
						'label'=>__('Sender method',DHVC_FORM),
						'default'=>'default',
						'options'=>array(
							'default'=>__('PHP Mailer',DHVC_FORM),
							'smtp'=>__('SMTP',DHVC_FORM)
						)
				),
				'smtp_host'=>array(
						'type'=>'text',
						'label'=>__('SMTP host',DHVC_FORM),
				),
				'smtp_post'=>array(
						'type'=>'text',
						'value'=>25,
						'label'=>__('SMTP port',DHVC_FORM),
				),
				'smtp_encryption'=>array(
						'type'=>'select',
						'label'=>__('SMTP encryption',DHVC_FORM),
						'options'=>array(
							''=>__('None',DHVC_FORM),
							'tls'=>__('TLS',DHVC_FORM),
							'ssl'=>__('SSL',DHVC_FORM)
						),
				),
				'smtp_username'=>array(
						'type'=>'text',
						'label'=>__('SMTP username',DHVC_FORM),
				),
				'smtp_password'=>array(
						'type'=>'password',
						'label'=>__('SMTP password',DHVC_FORM),
				),
				'recaptcha'=>array(
						'type'=>'heading',
						'label'=>__('reCaptcha settings',DHVC_FORM),
						'help'=>__('In order to use the reCAPTCHA element in your form you must <a target="_blank" href="https://www.google.com/recaptcha">sign up</a> for a free account to get your set of API keys.',DHVC_FORM),
				),
				'recaptcha_public_key'=>array(
						'type'=>'text',
						'label'=>__('Public key (Site Key)',DHVC_FORM),
				),
				'recaptcha_private_key'=>array(
						'type'=>'text',
						'label'=>__('Private key (Secret Key)',DHVC_FORM),
				),
				'mailchimp'=>array(
						'type'=>'heading',
						'label'=>__('MailChimp settings',DHVC_FORM),
				),
				'mailchimp_api'=>array(
						'type'=>'text',
						'label'=>__('MailChimp API Key',DHVC_FORM),
						'help'=>__('Enter your API Key. <a href="http://admin.mailchimp.com/account/api-key-popup" target="_blank">Get your API key</a>',DHVC_FORM)
				),
				'mailchimp_list'=>array(
						'type'=>'mailchimp_list',
						'label'=>__('MailChimp List',DHVC_FORM),
						'options'=>array(''=>__('Nothing Found...',DHVC_FORM)),
						'help'=>__('After you add your MailChimp API Key above and save it this list will be populated.',DHVC_FORM)
				),
				'mailchimp_opt_in'=>array(
						'type'=>'checkbox',
						'label'=>__('Enable Double Opt-In',DHVC_FORM),
						'help'=>__("Learn more about <a href='http://kb.mailchimp.com/article/how-does-confirmed-optin-or-double-optin-work' target='_blank'>Double Opt-in</a>.",DHVC_FORM)
				),
				'mailchimp_welcome_email'=>array(
						'type'=>'checkbox',
						'label'=>__('Send Welcome Email',DHVC_FORM),
						'help'=>__("If your Double Opt-in is false and this is true, MailChimp will send your lists Welcome Email if this subscribe succeeds - this will not fire if MailChimp ends up updating an existing subscriber. If Double Opt-in is true, this has no effect. Learn more about <a href='http://blog.mailchimp.com/sending-welcome-emails-with-mailchimp/' target='_blank'>Welcome Emails</a>.",DHVC_FORM)
				),
				'mailchimp_group_name'=>array(
						'type'=>'text',
						'label'=>__('Group Name',DHVC_FORM),
						'help'=>__('Optional: Enter the name of the group. Learn more about <a href="http://mailchimp.com/features/groups/" target="_blank">Groups</a>',DHVC_FORM)
				),
				'mailchimp_group'=>array(
						'type'=>'text',
						'label'=>__('Group',DHVC_FORM),
						'help'=>__('Optional: Comma delimited list of interest groups to add the email to.',DHVC_FORM)
				),
				'mailchimp_replace_interests'=>array(
						'type'=>'checkbox',
						'label'=>__('Replace Interests',DHVC_FORM),
						'help'=>__("Whether MailChimp will replace the interest groups with the groups provided or add the provided groups to the member's interest groups.",DHVC_FORM)
				),
				
		);
		$this->meta_boxs = array(
				array (
						"type" => "heading",
						"label"=>__('General',DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Save Submitted Form to Data ?", DHVC_FORM ),
						"name" => "save_data",
						"cbvalue" =>1,
						'description' => __('If checked, the submitted form data will be saved to your database.',DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Use Form AJAX ? ", DHVC_FORM ),
						"name" => "use_ajax",
						'description'=>__('You can not upload file if use form AJAX',DHVC_FORM),
						"cbvalue" =>1
				),
				array (
						"type" => "select",
						"label" => __ ( "Action Type", DHVC_FORM ),
						"name" => "action_type",
						"options" => array (
								'default'=>__ ( 'Default', DHVC_FORM ),
								'external_url'=>__ ( 'External URL', DHVC_FORM )
						)
				),
				array (
						"type" => "select",
						"label" => __ ( "Use form action", DHVC_FORM ),
						"name" => "form_action",
						"options"=>$this->_get_form_acition_options()
				),
				array (
					"type" => "checklist",
					"label" => __ ( "Mailpoet subscribers to These Lists", DHVC_FORM ),
					"name" => "mailpoet",
					"options" => dhvc_form_get_mailpoet_subscribers_list(),
				),
				array (
					"type" => "checklist",
					"label" => __ ( "Mymail subscribers to These Lists", DHVC_FORM ),
					"name" => "mymail",
					"options" => dhvc_form_get_mymail_subscribers_list(),
				),
				array (
					"type" => "checkbox",
					"label" => __ ( "Mymail Double Opt In ", DHVC_FORM ),
					"name" => "mymail_double_opt_in",
					'description'=>__('Users have to confirm their subscription',DHVC_FORM),
					"cbvalue" =>1
				),
				array (
						"type" => "text",
						"label" => __ ( "Enter URL", DHVC_FORM ),
						"name" => "action_url",
						"dependency" => array ('element' => "action_type",'value' => array ('external_url')),
						'description' => __('Enter a action URL.',DHVC_FORM)
				),
				array (
						"type" => "select",
						"label" => __ ( "Method", DHVC_FORM ),
						"name" => "method",
						"options" => array (
								'post'=>__ ( 'Post', DHVC_FORM ),
								'get'=>__ ( 'Get', DHVC_FORM )
						)
				),
				array (
						"type" => "heading",
						"label"=>__('Successful submit settings',DHVC_FORM)
				),
				array (
						"type" => "select",
						"label" => __ ( "On successful submit", DHVC_FORM ),
						"name" => "on_success",
						"options" => array (
								'message'=>__ ( 'Display a message', DHVC_FORM ),
								'redirect'=>__ ( 'Redirect to another page', DHVC_FORM )
						)
				),
				array (
						"type" => "textarea_variable",
						"label" => __ ( "Message", DHVC_FORM ),
						"name" => "message",
						"value"=>'Your message has been sent. Thanks!',
						"dependency" => array ('element' => "on_success",'value' => array ('message')),
						'description' =>  __('This is the text or HTML that is displayed when the form is successfully submitted',DHVC_FORM)
				),
				array (
						"type" => "select",
						"label" => __ ( "Message Position", DHVC_FORM ),
						"name" => "message_position",
						"options"=>array(
							'top'=>__('Top',DHVC_FORM),
							'bottom'=>__('Bottom',DHVC_FORM)
						),
				),
				array (
						"type" => "select",
						"label" => __ ( "Redirect to", DHVC_FORM ),
						"name" => "redirect_to",
						"dependency" => array ('element' => "on_success",'value' => array ('redirect')),
						"options" => array (
								'to_page'=>__ ( 'Page', DHVC_FORM ),
								'to_post'=>__ ( 'Post', DHVC_FORM ),
								'to_url'=>__ ( 'Url', DHVC_FORM )
						),
						"description"=>__('When the form is successfully submitted you can redirect the user to post, page or URL.',DHVC_FORM),
				),
				array (
						"type" => "select",
						"label" => __ ( "Select page", DHVC_FORM ),
						"name" => "page",
						"options" => dhvc_form_get_pages(),
						"dependency" => array ('element' => "redirect_to",'value' => array ('to_page')),
				),
				array (
						"type" => "select",
						"label" => __ ( "Select post", DHVC_FORM ),
						"name" => "post",
						"options" => dhvc_form_get_posts(),
						"dependency" => array ('element' => "redirect_to",'value' => array ('to_post')),
				),
				array (
						"type" => "text",
						"label" => __ ( "Enter URL", DHVC_FORM ),
						"name" => "url",
						"dependency" => array ('element' => "redirect_to",'value' => array ('to_url')),
				),
				array (
						"type" => "heading",
						"label"=>__('Notifications email settings',DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Send form data via email ?", DHVC_FORM ),
						"name" => "notice",
						"cbvalue" =>1
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Sender Name', DHVC_FORM ),
						'name' => 'notice_name',
						'value'=>get_bloginfo('name'),
						"dependency" => array ('element' => "notice",'not_empty' => true),
				),
				array (
					'type' => 'select',
					'label' => __ ( 'Sender Email Type', DHVC_FORM ),
					'name' => 'notice_email_type',
					'value'=>'email_text',
					'options'=>array(
						'email_text'=>__ ( 'Email', DHVC_FORM ),
						'email_field'=>__ ( 'Email Field', DHVC_FORM ),
					),
					"dependency" => array ('element' => "notice",'not_empty' => true),
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Sender Email', DHVC_FORM ),
						'name' => 'notice_email',
						'value'=>get_bloginfo('admin_email'),
						"dependency" => array ('element' => "notice",'not_empty' => true),
				),
				array (
					'type' => 'select_recipient',
					'label' => __ ( 'Sender Field', DHVC_FORM ),
					'name' => 'notice_variables',
					"description"=>__('The form must have at least one Email Address element to use this feature.',DHVC_FORM)
				),
				array (
						'type' => 'recipient',
						'label' => __ ( 'Recipients', DHVC_FORM ),
						'name' => 'notice_recipients',
						'value'=>get_bloginfo('admin_email'),
						"dependency" => array ('element' => "notice",'not_empty' => true),
						"description"=>__('Add email address(es) which the submitted form data will be sent to.',DHVC_FORM)
				),
				array (
						'type' => 'input_variable',
						'label' => __ ( 'Email subject', DHVC_FORM ),
						'name' => 'notice_subject',
						"dependency" => array ('element' => "notice",'not_empty' => true),
						'value'=>__('New form submission',DHVC_FORM)
				),
				array (
						'type' => 'textarea_variable',
						'label' => __ ( 'Email body', DHVC_FORM ),
						'name' => 'notice_body',
						'value'=>'[form_body]',
						"description"=>__("Use the label [form_body] to insert the form data in the email body. To use form control in email. please enter form control variables <strong>[form_control_name]</strong> in email.",DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Use HTML content type ?", DHVC_FORM ),
						"name" => "notice_html",
						"cbvalue" =>1
				),
				array (
						"type" => "heading",
						"label"=>__('Autoreply email settings',DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Send autoreply email ?", DHVC_FORM ),
						"name" => "reply",
						"cbvalue" => 1
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Sender Name', DHVC_FORM ),
						'name' => 'reply_name',
						'value'=>get_bloginfo('name'),
						"dependency" => array ('element' => "reply",'not_empty' => true),
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Sender Email', DHVC_FORM ),
						'name' => 'reply_email',
						'value'=>get_bloginfo('admin_email'),
						"dependency" => array ('element' => "reply",'not_empty' => true),
				),
				array (
						'type' => 'select_recipient',
						'label' => __ ( 'Recipients', DHVC_FORM ),
						'name' => 'reply_recipients',
						"description"=>__('The form must have at least one Email Address element to use this feature.',DHVC_FORM)
				),
				array (
						'type' => 'input_variable',
						'label' => __ ( 'Email subject', DHVC_FORM ),
						'name' => 'reply_subject',
						"dependency" => array ('element' => "reply",'not_empty' => true),
						'value'=>__('Just Confirming',DHVC_FORM)
				),
				array (
						'type' => 'textarea_variable',
						'label' => __ ( 'Email body', DHVC_FORM ),
						'name' => 'reply_body',
						"dependency" => array ('element' => "reply",'not_empty' => true),
						'value'=>__('This is just a confirmation message. We have received you reply.',DHVC_FORM),
						"description"=>__("Use the label [form_body] to insert the form data in the email body. To use form control in email. please enter form control variables <strong>[form_control_name]</strong> in email.",DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Use HTML content type ?", DHVC_FORM ),
						"name" => "reply_html",
						"cbvalue" =>1
				),
				array (
						"type" => "heading",
						"label"=>__('Form popup settings',DHVC_FORM)
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Display the form in a popup ?", DHVC_FORM ),
						"name" => "form_popup",
						"cbvalue" =>1
				),
				array (
						"type" => "labelpopup",
						"name" => 'form_popup_labelpopup',
						"label" => __ ('Set data-toggle="dhvcformpopup" on a controller element, like a button, along with a data-target="#dhvcformpopup-{form_ID}" or href="#dhvcformpopup-{form_ID}" to target a specific form popup to toggle.', DHVC_FORM ),
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Show popup title ?", DHVC_FORM ),
						"name" => "form_popup_title",
						"cbvalue" =>1
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Form popup width (px)', DHVC_FORM ),
						'name' => 'form_popup_width',
						'value'=>600,
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Auto open popup ?", DHVC_FORM ),
						"name" => "form_popup_auto_open",
						"cbvalue" =>1,
						"description"=>__('If selected, form popup will auto open when load page.',DHVC_FORM),
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Popup open delay (ms)', DHVC_FORM ),
						'name' => 'form_popup_auto_open_delay',
						'value'=>2000,
						"description"=>__('Time delay for open popup.',DHVC_FORM),
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Auto close popup ?", DHVC_FORM ),
						"name" => "form_popup_auto_close",
						"cbvalue" =>1,
						"description"=>__('If selected, form popup will auto close.',DHVC_FORM),
				),
				array (
						'type' => 'text',
						'label' => __ ( 'Popup close delay (ms)', DHVC_FORM ),
						'name' => 'form_popup_auto_close_delay',
						'value'=>10000,
						"description"=>__('Time delay for close popup.',DHVC_FORM),
				),
				array (
						"type" => "checkbox",
						"label" => __ ( "Only one time ?", DHVC_FORM ),
						"name" => "form_popup_one",
						"cbvalue" =>1,
						"description"=>__('If selected,form will opens only on the first visit your site.',DHVC_FORM),
				),
				array (
						"type" => "heading",
						"label"=>__('Style settings',DHVC_FORM)
				),
				array (
						"type" => "select",
						"label" => __ ( "Form layout", DHVC_FORM ),
						"name" => "form_layout",
						"options" => array (
								'vertical'=>__ ( 'Vertical', DHVC_FORM ),
								'horizontal'=>__ ( 'Horizontal', DHVC_FORM ),
						),
				),
				array (
					"type" => "select",
					"label" => __ ( "Input icon position", DHVC_FORM ),
					"name" => "input_icon_position",
					"options" => array (
						'right'=>__ ( 'Right', DHVC_FORM ),
						'left'=>__ ( 'Left', DHVC_FORM ),
					),
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Label Color', DHVC_FORM ),
					'name' => 'label_color',
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Input Placeholder Text Color', DHVC_FORM ),
					'name' => 'placeholder_color',
				),
				array (
					'type' => 'text',
					'label' => __ ( 'Input Height (example enter:40px)', DHVC_FORM ),
					'name' => 'input_height',
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Input Background Color', DHVC_FORM ),
					'name' => 'input_bg_color',
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Input Text Color', DHVC_FORM ),
					'name' => 'input_text_color',
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Input border color', DHVC_FORM ),
					'name' => 'input_border_color',
				),
				array (
					'type' => 'text',
					'label' => __ ( 'Input border Size (example enter:1px)', DHVC_FORM ),
					'name' => 'input_border_size',
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Input hover border color', DHVC_FORM ),
					'name' => 'input_hover_border_color',
				),
				array (
					'type' => 'color',
					'label' => __ ( 'Input focus border color', DHVC_FORM ),
					'name' => 'input_focus_border_color',
				),
				array (
					'type' => 'text',
					'label' => __ ( 'Button Height (example enter:40px)', DHVC_FORM ),
					'name' => 'button_height',
				),
				
				array (
					'type' => 'color',
					'label' => __ ( 'Button background color', DHVC_FORM ),
					'name' => 'button_bg_color',
				),
				array(
					'type'=>'textarea',
					'label'=>__('Additional Settings',DHVC_FORM),
					"description"=>__('Trigger with form AJAX.',DHVC_FORM),
					'name'=>'additional_setting'
				)
		);
		
	}
	
	protected function _get_form_acition_options(){
		$actions = dhvc_form_get_actions();
		$options = array('');
		foreach ($actions as $action){
			$options[$action] = ucfirst($action);
		}
		return $options;
	}
	
	public function disable_autosave(){
		global $post;
	
		if ( $post && get_post_type( $post->ID ) === 'dhvcform' ) {
			wp_dequeue_script( 'autosave' );
		}
	}
	
	public function post_updated_messages( $messages ) {
		global $post;
		$messages['dhvcform'] = array(
				0 => '', // Unused. Messages start at index 1.
				1 => __( 'Form updated.', DHVC_FORM ),
				2 => __( 'Custom field updated.', DHVC_FORM ),
				3 => __( 'Custom field deleted.', DHVC_FORM ),
				4 => __( 'Form updated.', DHVC_FORM ),
				5 => isset($_GET['revision']) ? sprintf( __( 'Form restored to revision from %s', DHVC_FORM ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
				6 => __( 'Form updated.', DHVC_FORM ),
				7 => __( 'Form saved.', DHVC_FORM ),
				8 => __( 'Form submitted.', DHVC_FORM ),
				9 => sprintf( __( 'Form scheduled for: <strong>%1$s</strong>.', DHVC_FORM ),
						date_i18n( __( 'M j, Y @ G:i', DHVC_FORM ), strtotime( $post->post_date ) ) ),
				10 => __( 'Form draft updated.', DHVC_FORM )
		);
		return $messages;
	}
	
	public function custom_order_views($views){
		unset( $views['publish'] );
		
		if ( isset( $views['trash'] ) ) {
			$trash = $views['trash'];
			unset( $views['draft'] );
			unset( $views['trash'] );
			$views['trash'] = $trash;
		}
		
		return $views;
	}
	
	public function add_row_actions($actions){
		global $post;
		$actions['delete'] = "<a class='submitdelete' id='dhvc_form_submitdelete' title='" . esc_attr( __( 'Delete this item permanently' ) ) . "' href='" . get_delete_post_link( $post->ID, '', true ) . "'>" . __( 'Delete Permanently' ) . "</a>";
		return $actions;
	}
	
	public function remove_row_actions( $actions ) {
		if ( 'dhvcform' === get_post_type() ) {
			unset( $actions['view'] );
			unset( $actions['trash'] );
			unset( $actions['inline hide-if-no-js'] );
		}
	
		return $actions;
	}
	public function edit_columns( $existing_columns ) {
		$columns = array();
		
		$columns['cb']             = $existing_columns['cb'];
		$columns['form_id']          = __( 'ID', DHVC_FORM );
		$columns['title']          = __( 'Title', DHVC_FORM );
		$columns['shortcode']      = __( 'Shortcode', DHVC_FORM );
		
		unset($existing_columns['title']);
		unset($existing_columns['cb']);
		
		return array_merge($columns,$existing_columns);
	}
	
	public function custom_columns( $column ) {
		global $post;
		switch ( $column ) {
			case 'shortcode':
				echo '<input class="wp-ui-text-highlight code" type="text" onfocus="this.select();" readonly="readonly" value="'.esc_attr('[dhvc_form id="'.$post->ID.'"]').'" style="width:99%">';
			break;
			case 'form_id':
				echo get_the_ID();
			break;
		}
	}
	
	public function remove_meta_boxes() {
		remove_meta_box( 'vc_teaser', 'dhvcform' , 'side' );
		remove_meta_box( 'commentsdiv', 'dhvcform' , 'normal' );
		remove_meta_box( 'commentstatusdiv', 'dhvcform' , 'normal' );
		remove_meta_box( 'slugdiv', 'dhvcform' , 'normal' );
	}
	
	public function add_meta_boxes(){
		add_meta_box( 'dhvcform-actions', __( 'Form Actions', DHVC_FORM ), array($this,'actions_output'), 'dhvcform', 'side', 'high' );
		add_meta_box( 'dhvcform-options', __( 'Form Options', DHVC_FORM ), array($this,'options_output'), 'dhvcform', 'normal', 'high' );
	}
	public function actions_output(){
		global $post;
		?>
<style type="text/css">
#major-publishing-actions,#minor-publishing-actions,#visibility,#submitdiv {display: none }
</style>
<ul class="dhvcform_actions submitbox">
	<li class="wide">
		<div id="delete-action"><?php
			if ( current_user_can( "delete_dhvcform", $post->ID ) ) {
				$delete_text = __( 'Delete Permanently', DHVC_FORM );
				?><a class="submitdelete deletion" href="<?php echo esc_url( get_delete_post_link( $post->ID, '', true ) ); ?>"><?php echo $delete_text; ?></a>
				<?php
			}
		?>
		</div>
		<input type="submit"class="button dhvc_form_save button-primary" name="save" value="<?php _e( 'Save Form', DHVC_FORM ); ?>" />
	</li>
</ul>
<?php
	}
	
	public function options_output(){
		global $post;
		$form_control = get_post_meta($post->ID,'_form_control',true);
?>
<div class="dhvcform_options">
	<input name="post_status" type="hidden" value="publish" />
	<input id="form_control" type="hidden" value="<?php echo esc_attr($form_control) ?>" name="form_control">
	<?php 
	foreach ($this->meta_boxs as $meta_box){
		$this->render_metabox_field($meta_box);
	}	
	?>
</div>
<?php
	}
	
	protected function render_metabox_field($field){
		global $post;
		
		if(!isset($field['type']))
			echo '';
		
		$field['name']          = isset( $field['name'] ) ? $field['name'] : '';
		
		$value = get_post_meta( $post->ID, '_'.$field['name'], true );
		$field['value']         = isset( $field['value'] ) ? $field['value'] : '';
		if($value)
			$field['value']         = $value;
		
		
		$field['id'] 			= isset( $field['id'] ) ? $field['id'] : $field['name'];
		$field['description'] 	= isset($field['description']) ? $field['description'] : '';
		$field['label'] 		= isset( $field['label'] ) ? $field['label'] : '';
		$field['placeholder']   = isset( $field['placeholder'] ) ? $field['placeholder'] : $field['label'];
		$field['dependency']    = isset($field['dependency']) ? $field['dependency'] : array();
		$data_dependency = '';
		switch ($field['type']){
			case 'heading':
				echo '<h3>'.esc_html($field['label']).'</h3>';
			break;
			case 'labelpopup':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field ">';
				echo $field['label'].__('Example:',DHVC_FORM).'<br><strong><em>'.esc_html('<button type="button" data-toggle="dhvcformpopup" data-target="#dhvcformpopup-'.get_the_ID().'">'.__('Launch form popup',DHVC_FORM).'</button>').'</strong></em>';
				echo '</p>';
				break;
			case 'input_variable':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';
				echo '<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
				echo '<option value="">'.__('Insert variable...',DHVC_FORM).'</option>';
				foreach (dhvc_form_get_variables() as $label=>$key){
					echo '<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
				}
				echo  '</select>';
				echo '<input type="text" class="input_text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
					
				if ( ! empty( $field['description'] ) ) {
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				}
				echo '</p>';
			break;
			case 'text':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input type="text" class="input_text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
			
				if ( ! empty( $field['description'] ) ) {
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				}
				echo '</p>';
			break;
			case 'color':
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input data-default-color="'.esc_attr( $field['value'] ).'" type="text" class="input_text" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" /> ';
				if ( ! empty( $field['description'] ) ) {
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				}
				echo '<script type="text/javascript">
						jQuery(document).ready(function($){
						    $("#'.$field['id'].'").wpColorPicker();
						});
					 </script>
					 ';
				echo '</p>';
			break;
			case 'hidden':
				echo '<input type="hidden" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['value'] ) .  '" /> ';
			break;
			case 'textarea_variable':
				echo '<p  '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';
				echo '<select onchange="dhvc_form_select_variable(this)" class="dhvc-form-select-variable">';
				echo '<option value="">'.__('Insert variable...',DHVC_FORM).'</option>';
				foreach (dhvc_form_get_variables() as $label=>$key){
					echo '<option value="'.esc_attr($key).'">'.esc_html($label).'</option>';
				}
				echo  '</select>';
				echo '<textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20">' . esc_textarea( $field['value'] ) . '</textarea> ';
				
				if ( ! empty( $field['description'] ) ) {
				
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				
				}
				echo '</p>';
			break;
			case 'textarea':
				echo '<p  '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20">' . esc_textarea( $field['value'] ) . '</textarea> ';
				
				if ( ! empty( $field['description'] ) ) {
				
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				
				}
				echo '</p>';
			break;
			case 'recipient':
				echo '<div  '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field "><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';
				//echo '<textarea name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" placeholder="' . esc_attr( $field['placeholder'] ) . '" rows="5" cols="20">' . esc_textarea( $field['value'] ) . '</textarea> ';
				
				$values = (array)$field['value'];
				echo '<table  cellspacing="0" data-name="' . esc_attr( $field['name'] ) . '" class="dhvc-form-recipient-lists">';
				echo '<thead><tr><td>'.__('Email',DHVC_FORM).'</td><td></td></tr></thead>';
				echo '<tbody>';
				foreach ($values as $val){
					echo '<tr>';
					echo '<td>';
					echo '<input type="text" name="' . esc_attr( $field['name'] ) . '[]" value="'.esc_attr($val).'" />';
					echo '</td>';
					echo '<td>';
					echo '<a href="#" class="button" onclick="return dhvc_form_recipient_remove(this)">'.__('Remove',DHVC_FORM).'</a>';
					echo '</td>';
					echo '</tr>';
				}
				echo '<thead><tr><td><a href="#" class="button" onclick="return dhvc_form_recipient_add(this)">'.__('Add',DHVC_FORM).'</a></td><td></td></tr></thead>';
				echo '</tbody>';
				echo '</table>';
				if ( ! empty( $field['description'] ) ) {
				
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				
				}
				echo '</div>';
			break;
			
			case 'checkbox':
				
				$field['cbvalue']       = isset( $field['cbvalue'] ) ? $field['cbvalue'] : 'yes';
				
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><input class="checkbox" type="checkbox" name="' . esc_attr( $field['name'] ) . '" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $field['cbvalue'] ) . '" ' . checked( $field['value'], $field['cbvalue'], false ) . ' /> ';
				
				if ( ! empty( $field['description'] ) ) echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
				
				echo '</p>';
			break;
			case 'checklist':
				$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
				
				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';
				
				foreach ( $field['options'] as $key => $value ) {
					echo '<input class="checkbox" type="checkbox" '.(in_array(esc_attr($key), $field['value']) ? 'checked':'').' name="' . esc_attr( $field['name'] ) . '[]" id="' . esc_attr( $field['id'] ) . '" value="' . esc_attr( $key ) . '"  /> '.esc_html( $value ) .'<br/>';
				
				}
				
				
				if ( ! empty( $field['description'] ) ) {
				
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				
				}
				echo '</p>';
			break;
			case 'select':
				$field['options']       = isset( $field['options'] ) ? $field['options'] : array();

				echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label><select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '">';
				
				foreach ( $field['options'] as $key => $value ) {
				
					echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
				
				}
				
				echo '</select> ';
				
				if ( ! empty( $field['description'] ) ) {
				
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				
				}
				echo '</p>';
			break;
			case 'select_recipient':
				$form_control = get_post_meta($post->ID,'_form_control',true);
				if($form_control){
					$form_control_arr = json_decode($form_control);
					if(is_array($form_control_arr) && !empty($form_control_arr)){
						$options = array();
						foreach ($form_control_arr as $control){
							if($control->tag == 'dhvc_form_email'){
								$option_label = !empty($control->control_label) ? $control->control_label : $control->control_name;
								if(!empty($control->control_name))
									$options[$control->control_name] = $option_label;
							}
						}
						$field['options']       = $options;
						
						echo '<p '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><label for="' . esc_attr( $field['id'] ) . '">' . wp_kses_post( $field['label'] ) . '</label>';
						if(!empty($options)){
							echo '<select id="' . esc_attr( $field['id'] ) . '" name="' . esc_attr( $field['id'] ) . '">';
							echo '<option value="" ></option>';
							foreach ( $field['options'] as $key => $value ) {
							
								echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '>' . esc_html( $value ) . '</option>';
							
							}
							
							echo '</select> ';
						}
						
						if ( ! empty( $field['description'] ) ) {
						
							if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
								echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' . DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
							} else {
								echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
							}
						
						}
						echo '</p>';
					}
				}
			break;
			case 'radio':
				$field['options']       = isset( $field['options'] ) ? $field['options'] : array();
				echo '<fieldset '.$data_dependency.' class="form-field ' . esc_attr( $field['id'] ) . '_field"><legend>' . wp_kses_post( $field['label'] ) . '</legend><ul class="dhvc-form-meta-radios">';
				
				foreach ( $field['options'] as $key => $value ) {
				
					echo '<li><label><input
				        		name="' . esc_attr( $field['name'] ) . '"
				        		value="' . esc_attr( $key ) . '"
				        		type="radio"
								class="radio"
				        		' . checked( esc_attr( $field['value'] ), esc_attr( $key ), false ) . '
				        		/> ' . esc_html( $value ) . '</label>
				    	</li>';
				}
				echo '</ul>';
				
				if ( ! empty( $field['description'] ) ) {
				
					if ( isset( $field['desc_tip'] ) && false !== $field['desc_tip'] ) {
						echo '<img class="help_tip" data-tip="' . esc_attr( $field['description'] ) . '" src="' .DHVC_FORM_URL . '/assets/images/help.png" height="16" width="16" />';
					} else {
						echo '<span class="description">' . wp_kses_post( $field['description'] ) . '</span>';
					}
				
				}
				echo '</fieldset>';
			break;
			
			default:
			break;
		}
		
	}
	
	public function edit_post(){

	}
	
	public function delete_post($id){
		global $dhvcform_db;
		if ( ! current_user_can( 'delete_posts' ) )
			return;
		

		if ( $id > 0 ) {
		
			$post_type = get_post_type( $id );
			if($post_type === 'dhvcform')
				$dhvcform_db->delete_entry_by_form($id);
		}
	}
	
	public function save_post($post_id,$post){
		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}
		
		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}
		
		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}
		
		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		// Check the post type
		if ($post->post_type != 'dhvcform' ) {
			return;
		}
		
		$form_control = isset($_POST['form_control']) ? $_POST['form_control'] : null;
		
		if (empty( $form_control ) ) {
			delete_post_meta( $post_id, '_form_control' );
		} elseif($form_control !== null) {
			update_post_meta( $post_id, '_form_control', $form_control );
		}
		
		foreach ($this->meta_boxs as $meta_box){
			$meta_name = $meta_box['name'];
			$meta_value = isset($_POST[$meta_name]) ? $_POST[$meta_name] : null;
			if(is_array($meta_value)){
				$meta_value = array_filter($meta_value);
			}
			if (empty( $meta_value ) ) {
				delete_post_meta( $post_id, '_'.$meta_name );
			} elseif($meta_value !== null) {
				update_post_meta( $post_id, '_'.$meta_name , $meta_value );
			}
		}
		
	}
	
	public function admin_menu(){
		add_menu_page(__('Forms',DHVC_FORM), __('Forms',DHVC_FORM), 'edit_dhvcforms', 'dhvc-form',array(&$this,'forms_page'),DHVC_FORM_URL.'/assets/images/visual_composer.png','50.5');
		add_submenu_page('dhvc-form',  __('Entries',DHVC_FORM),   __('Entries',DHVC_FORM), 'edit_dhvcforms', 'dhvc-form-entry',array(&$this,'entries_page'));
		add_submenu_page('dhvc-form',  __('Settings',DHVC_FORM),   __('Settings',DHVC_FORM), 'edit_dhvcforms', 'dhvc-form-setting',array(&$this,'settings_page'));
	}
	
	public function conditonal_includes(){
		$screen = get_current_screen();
		if(in_array($screen->id,array('users','user','profile','user-edit'))){
			
		}
	}
	
	protected function _get_current_page_num(){
		$current = isset($_GET['paged']) ? absint($_GET['paged']) : 0;
		return  max(1, $current);
	}
	
	protected function _get_pagination($per_page, $total_items, $which)
	{
		$total_pages = ceil( $total_items / $per_page );
		$current = $this->_get_current_page_num();
		$output = '<span class="displaying-num">' . sprintf( _n( '1 item', '%s items', $total_items ), number_format_i18n( $total_items ) ) . '</span>';
	
		$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	
		$page_links = array();
	
		$disable_first = $disable_last = '';
		
		if ( $current == 1 )
			$disable_first = ' disabled';
		if ( $current == $total_pages )
			$disable_last = ' disabled';
	
		$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
				'first-page' . $disable_first,
				esc_attr__( 'Go to the first page' ),
				esc_url( remove_query_arg( 'paged', $current_url ) ),
				'&laquo;'
		);
	
		$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
				'prev-page' . $disable_first,
				esc_attr__( 'Go to the previous page' ),
				esc_url( add_query_arg( 'paged', max( 1, $current-1 ), $current_url ) ),
				'&lsaquo;'
		);
	
		if ( 'bottom' == $which )
			$html_current_page = $current;
		else
			$html_current_page = sprintf( "<input class='current-page' title='%s' type='text' name='%s' value='%s' size='%d' />",
					esc_attr__( 'Current page' ),
					esc_attr( 'paged' ),
					$current,
					strlen( $total_pages )
		);
	
		$html_total_pages = sprintf( "<span class='total-pages'>%s</span>", number_format_i18n( $total_pages ) );
		$page_links[] = '<span class="paging-input">' . sprintf( _x( '%1$s of %2$s', 'paging' ), $html_current_page, $html_total_pages ) . '</span>';
	
		$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
				'next-page' . $disable_last,
				esc_attr__( 'Go to the next page' ),
				esc_url( add_query_arg( 'paged', min( $total_pages, $current+1 ), $current_url ) ),
				'&rsaquo;'
		);
	
		$page_links[] = sprintf( "<a class='%s' title='%s' href='%s'>%s</a>",
				'last-page' . $disable_last,
				esc_attr__( 'Go to the last page' ),
				esc_url( add_query_arg( 'paged', $total_pages, $current_url ) ),
				'&raquo;'
		);
	
		$output .= "\n<span class='pagination-links'>" . join( "\n", $page_links ) . '</span>';
	
		if ( $total_pages )
			$page_class = $total_pages < 2 ? ' one-page' : '';
		else
			$page_class = ' no-pages';
	
		return "<div class='tablenav-pages{$page_class}'>$output</div>";
	}
	
	protected function _list_entry(){
	
		global $dhvcform_db;
		$message = '';
		$action = isset($_GET['action']) ? $_GET['action'] : '';
		switch ($action){
			case 'read':
				$entry_id = absint($_GET['entry_id']);
				if(wp_verify_nonce($_GET['_wpnonce'], 'read_entry_' . $entry_id)){
					$count = $dhvcform_db->read_entry($entry_id);
					$message = $count > 0 ? sprintf(__("%s entry mask as read",DHVC_FORM),$count) : '';
				}
				break;
			case 'unread':
				$entry_id = absint($_GET['entry_id']);
				if(wp_verify_nonce($_GET['_wpnonce'], 'unread_entry_' . $entry_id)){
					$count = $dhvcform_db->unread_entry($entry_id);
					$message = $count > 0 ?  sprintf(__("%s entry mask as un-read",DHVC_FORM),$count): '';
				}
				break;
			default:
			case 'delete':
				$entry_id = absint($_GET['entry_id']);
				if(wp_verify_nonce($_GET['_wpnonce'], 'delete_entry_' . $entry_id)){
					$count = $dhvcform_db->delete_entry($entry_id);
					$message =  $count > 0 ?  sprintf(__("%s entry deleted",DHVC_FORM),$count): '';
				}
				break;
			default:
				break;
		}
		
		$bulk_action = '';
		if (isset($_GET['bulk_action']) && $_GET['bulk_action'] != '-1') {
			$bulk_action = $_GET['bulk_action'];
		} elseif (isset($_GET['bulk_action2']) && $_GET['bulk_action2'] != '-1') {
			$bulk_action = $_GET['bulk_action2'];
		}
		switch ($bulk_action){
			case 'read':
				$entry_id = isset($_GET['entry']) ? $_GET['entry'] : array();
				$count = $dhvcform_db->read_entry($entry_id);
				$message = $count > 0 ? sprintf(__("%s entry mask as read",DHVC_FORM),$count) : '';
				
				break;
			case 'unread':
				$entry_id = isset($_GET['entry']) ? $_GET['entry'] : array();
				$count = $dhvcform_db->unread_entry($entry_id);
				$message = $count > 0 ?  sprintf(__("%s entry mask as un-read",DHVC_FORM),$count): '';
				
				break;
			default:
			case 'delete':
				$entry_id = isset($_GET['entry']) ? $_GET['entry'] : array();
				$count = $dhvcform_db->delete_entry($entry_id);
				$message =  $count > 0 ?  sprintf(__("%s entry deleted",DHVC_FORM),$count): '';
				break;
			default:
				break;
		}
		
		
		$orderby = (isset($_GET['orderby'])  ) ? $_GET['orderby'] : 'submitted';
		$order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'asc' : 'desc';
		$reverseOrder = $order == 'asc' ? 'desc' : 'asc';
		
		$form_id = isset($_GET['form_id']) ? $_GET['form_id'] : 0;
		$limit = isset($_GET['limit']) ? $_GET['limit'] : 10;
		
		$offset =  $limit * ($this->_get_current_page_num() - 1);
		
		$columns= array('id'=>__('ID',DHVC_FORM),'date'=>__('Date',DHVC_FORM),'form_name'=>__('Form Name',DHVC_FORM));
		$topPagination ='';
		$entries = $dhvcform_db->get_entries($form_id,$orderby,$order,$limit,$offset);
		$total = $dhvcform_db->get_entries_count($form_id);
?>
<div class="wrap">
	<h2><?php echo __('Entries',DHVC_FORM)?></h2>
	<?php if(!empty($message)):?>
	<div id="message" class="updated below-h2">
		<p><?php echo $message?></p>
	</div>
	<?php endif;?>
	<form id="dhvc_form_entry" action="" method="get">
		<input type="hidden" value="dhvc-form-entry" name="page">
		<ul class="subsubsub">
			<li class="all">
				<a class="current" href="#"><?php echo __('All',DHVC_FORM)?> <span class="count">(<?php echo (int) $total ?>)</span></a>
			</li>
		</ul>
		<div class="tablenav top">
            <div class="alignleft actions bulkactions">
                <select name="bulk_action">
                    <option selected="selected" value="-1"><?php esc_html_e('Bulk Actions', DHVC_FORM); ?></option>
                    <option value="read"><?php esc_html_e('Mark as read', DHVC_FORM); ?></option>
                    <option value="unread"><?php esc_html_e('Mark as unread', DHVC_FORM); ?></option>
                    <option value="delete"><?php esc_html_e('Delete', DHVC_FORM); ?></option>
                </select>
                <input type="submit" value="<?php esc_attr_e('Apply', DHVC_FORM); ?>" class="button action dhvc-form-action" id="doaction" name="" />
           </div>
           <div class="alignleft actions">
               	<select name="limit" class="dhvc-form-entry-select-action" style="float: none">
                    <option value="10" <?php selected($limit, 10); ?>>10</option>
                    <option value="20" <?php selected($limit, 20); ?>>20</option>
                    <option value="40" <?php selected($limit, 40); ?>>40</option>
                    <option value="60" <?php selected($limit, 60); ?>>60</option>
                    <option value="80" <?php selected($limit, 80); ?>>80</option>
                    <option value="100" <?php selected($limit, 100); ?>>100</option>
                    <option value="-1" <?php selected($limit, -1); ?>><?php esc_html_e('All', DHVC_FORM); ?></option>
                </select>
                <span><?php esc_html_e('per page', DHVC_FORM); ?></span>
                <?php 
                $forms = get_posts(array(
					'numberposts'=>-1,
					'post_type'=>'dhvcform'
				));
                ?>
                <span style="margin-left: 30px;font-weight: bold;"><?php esc_html_e('Filter by form to export:', DHVC_FORM); ?></span>
                <select name="form_id" class="dhvc-form-entry-select-action" style="float: none;margin-left: 10px">
                	<option value="0" <?php selected($limit, 0); ?>><?php echo __('View all form')?></option>
                	<?php foreach ($forms as $form):?>
                    <option value="<?php echo $form->ID ?>" <?php selected($form_id,$form->ID); ?>><?php echo $form->ID.' - '.$form->post_title ?></option>
                    <?php endforeach;?>
                </select>
                <?php if(!empty($form_id)):?>
                <a href="<?php echo plugins_url('/dhvc-form/export.php?form_id='.$form_id); ?>" target="_blank" class="button"><?php _e('Export',DHVC_FORM)?></a>
            	<?php endif;?>
            </div>
             <?php echo $this->_get_pagination($limit, $total, 'top'); ?>
            <br class="clear" />
        </div>
        <table class="wp-list-table widefat fixed dhvc-form-entry-list">
            <thead>
                <tr>
                    <th class="manage-column column-cb check-column" id="cb" scope="col">
                        <input type="checkbox" class="headercb" />
                    </th>
                    <?php ob_start(); ?>
                    
                        <?php foreach ($columns as $key=>$label) : ?>
                            <?php if ($key == $orderby) : ?>
                                <th class="manage-column entry-<?php echo $key; ?> sorted <?php echo $order; ?>" scope="col">
                                    <a href="<?php echo esc_url(add_query_arg(array('orderby' => $key, 'order' => strtolower($reverseOrder)))); ?>">
                            <?php else : ?>
                                <th class="manage-column entry-<?php echo $key; ?> sortable desc" scope="col">
                                    <a href="<?php echo esc_url(add_query_arg(array('orderby' => $key, 'order' => 'asc'))); ?>">
                            <?php endif; ?>
                                    <span><?php echo esc_html($label); ?></span>
                                    <span class="sorting-indicator"></span>
                                    </a>
                                </th>

                        <?php endforeach; ?>
                    <?php echo $headings = ob_get_clean(); ?>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th class="manage-column column-cb check-column" scope="col">
                        <input type="checkbox" />
                    </th>
                    <?php echo $headings; ?>
                </tr>
            </tfoot>

            <tbody id="the-list">
                <?php if (count($entries)) : ?>
                    <?php $i = 1; ?>
                    <?php foreach ($entries as $entry) : ?>
                        <tr valign="top" class="<?php echo (++$i % 2 == 1) ? 'alternate ' : ''; ?> dhvc-form-entry-<?php echo ($entry->readed == 0 ? 'read' : 'unread')?>" id="dhvc-form-entry-<?php echo $entry->id; ?>">
                            <th class="check-column" scope="row">
                                <input type="checkbox" value="<?php echo $entry->id; ?>" name="entry[]" />
                            </th>
                            <td class="dhvc-form-entry-id">
                            	<?php echo $entry->id?>
                            		<span class="dhvc-form-entry-icon dhvc-form-entry-icon-<?php echo ($entry->readed == 0 ? 'read' : 'unread')?>"></span>
                            </td>
                            <td class="dhvc-form-entry-date">
                            	<?php 
                            	$t_time = mysql2date( __( 'Y/m/d g:i:s A' ),$entry->submitted,true );
                            	?>
                            	<a href="<?php echo esc_url(add_query_arg(array('action' => 'view', 'entry_id' => $entry->id),'admin.php?page=dhvc-form-entry')); ?>"><strong class="row-title"><abbr title="<?php echo $t_time ?>"><?php echo $t_time ?></abbr></strong></a>
                            	<div class="row-actions">
								    <span class="view"><a href="<?php echo esc_url(add_query_arg(array('action' => 'view', 'entry_id' => $entry->id),'admin.php?page=dhvc-form-entry')); ?>" title="<?php esc_attr_e('View this entry', DHVC_FORM); ?>"><?php esc_html_e('View', DHVC_FORM); ?></a> |</span>
								    <?php if ($entry->readed == 0) : ?>
								        <span class="mark-read"><a href="<?php echo esc_url(add_query_arg(array('action' => 'read', 'entry_id' => $entry->id, '_wpnonce' => wp_create_nonce('read_entry_' . $entry->id)), 'admin.php?page=dhvc-form-entry')); ?>" title="<?php esc_attr_e('Mark as read', DHVC_FORM); ?>"><?php esc_html_e('Mark as read', DHVC_FORM); ?></a> |</span>
								    <?php else : ?>
								        <span class="mark-unread"><a href="<?php echo esc_url(add_query_arg(array('action' => 'unread', 'entry_id' => $entry->id, '_wpnonce' => wp_create_nonce('unread_entry_' . $entry->id)), 'admin.php?page=dhvc-form-entry')); ?>" title="<?php esc_attr_e('Mark as unread', DHVC_FORM); ?>"><?php esc_html_e('Mark as unread',DHVC_FORM); ?></a> |</span>
								    <?php endif; ?>
								    <span class="trash"><a class="submitdelete " title="<?php esc_attr_e('Delete this entry', DHVC_FORM); ?>" href="<?php echo esc_url(add_query_arg(array('action' => 'delete', 'entry_id' => $entry->id, '_wpnonce' => wp_create_nonce('delete_entry_' . $entry->id)), 'admin.php?page=dhvc-form-entry')); ?>"><?php esc_html_e('Delete',DHVC_FORM); ?></a></span>
								</div>	
                            </td>
                            <td class="dhvc-form-entry-form-name">
                            	<a href="<?php echo get_edit_post_link($entry->form_id); ?>" title="<?php esc_attr_e('Edit Form',DHVC_FORM)?>"><?php echo get_the_title($entry->form_id)?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr class="no-items">
                        <td colspan="<?php echo (count($columns) + 1); ?>" class="colspanchange"><p><?php esc_html_e('No entries found.', DHVC_FORM); ?></p></td>
                    </tr>
                <?php endif; ?>
                </tbody>
        </table>
        <div class="tablenav bottom">
            <div class="alignleft actions bulkactions">
                <select name="bulk_action2">
                    <option selected="selected" value="-1"><?php esc_html_e('Bulk Actions', DHVC_FORM); ?></option>
                    <option value="read"><?php esc_html_e('Mark as read', DHVC_FORM); ?></option>
                    <option value="unread"><?php esc_html_e('Mark as unread', DHVC_FORM); ?></option>
                    <option value="delete"><?php esc_html_e('Delete', DHVC_FORM); ?></option>
                </select>
                <input type="submit" value="<?php esc_attr_e('Apply', DHVC_FORM); ?>" class="button action dhvc-form-action2" id="doaction" name="" />
            </div>
            <?php echo $this->_get_pagination($limit, $total, 'buttom'); ?>
            <br class="clear" />
        </div>
	</form>
</div>
<?php
	}
	protected function _view_entry(){
	global $dhvcform_db;
	$entry_id = isset($_GET['entry_id']) ? absint($_GET['entry_id']) : 0;
 	$entry = $dhvcform_db->get_entry($entry_id);
	if(!empty($entry)):
	//mask as read
	$dhvcform_db->read_entry($entry_id);
	$form_control = get_post_meta($entry->form_id,'_form_control',true);
	$current_user = wp_get_current_user();
	
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	switch ($action){
		case 'add_note':
			check_admin_referer('_dhvc_form_entry_note', '_dhvc_form_entry_note');
			$note_data = array(
				'entry_id'=>$entry->id,
				'user_id'=>( isset( $current_user->ID ) ? (int) $current_user->ID : 0 ),
				'message'=>isset($_POST['entry_message']) ? $_POST['entry_message']:'',
				'created'=>gmdate('Y-m-d H:i:s'),
			);
			$dhvcform_db->insert_entry_note($note_data);
		break;
		case 'delete_note':
			check_admin_referer('_dhvc_form_entry_note', '_dhvc_form_entry_note');
			$note_id = isset($_POST['note_id']) ? absint($_POST['note_id']) : 0;
			$dhvcform_db->delete_entry_note($note_id);
		break;
		default:
		break;
	}
	
?>
<div class="wrap">
	<h2><?php echo sprintf(__('Entry "%s"',DHVC_FORM),$entry->id)?></h2>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<div id="post-body-content">
				<div class="postbox ">
					<div class="handlediv" title="<?php echo esc_html_e('Click to toggle',DHVC_FORM) ?>"><br></div>
					<h3 class="hndle"><span><?php echo esc_html_e('Submitted form data',DHVC_FORM)?></span></h3>
					<div class="inside">
						<div class="dhvcform_options">
							<?php if($form_control):?>
							<?php $entry_data =  maybe_unserialize($entry->entry_data)?>
							<?php $form_control_arr = json_decode($form_control)?>
							<?php foreach ($form_control_arr as $control):?>
								<?php if(property_exists($control, 'control_name')):?>
									<?php if(!array_key_exists( $control->control_name, $entry_data) || empty($entry_data[$control->control_name])) continue;?>
									
									<div class="form-field">
										<label><strong><?php echo (!empty($control->control_label) ? $control->control_label : $control->control_name)?></strong></label>
										<div>
										<?php if($control->tag !='dhvc_form_file'):?>
											<?php if($control->tag == 'dhvc_form_password' && apply_filters('dhvc_form_password_not_view_entry_password', true)):?>
												<?php if(array_key_exists( $control->control_name, $entry_data)):?>
													<?php echo '*****' ?>
												<?php endif;?>
											<?php else:?>
												<?php if(array_key_exists( $control->control_name, $entry_data)):?>
													<?php echo $entry_data[$control->control_name] ?>
												<?php endif;?>
											<?php endif;?>
										<?php elseif($control->tag =='dhvc_form_file' && array_key_exists( $control->control_name, $entry_data)):?>
											<?php 
											$file_arr = $entry_data[$control->control_name];
											if(isset($file_arr['path']) && !empty($file_arr['path']) && isset($file_arr['filename']) && !empty($file_arr['filename'])):
											?>
											<a href="<?php echo dhvc_form_get_upload_url().'/'.$file_arr['path']; ?>" title="<?php echo esc_html_e('Click to download',DHVC_FORM)?>"><?php echo (isset($file_arr['filename']) ? $file_arr['filename']:'No filename')?></a>
											<?php endif;?>
										<?php endif;?>
										</div>
									</div>
								<?php endif;?>
							<?php endforeach;?>
							<?php endif;?>
						</div>
					</div>
				</div>
				
				<div class="postbox" id="entry_note_box">
					<div class="handlediv" title="<?php echo esc_html_e('Click to toggle',DHVC_FORM) ?>"><br></div>
					<h3 class="hndle"><span><?php echo esc_html_e('Notes',DHVC_FORM)?></span></h3>
					<div class="inside">
						<form method="post" id="entry_note_form">
							<input id="action" type="hidden" value="" name="action">
							<input id="note_id" type="hidden" value="0" name="note_id">
                            <?php wp_nonce_field('_dhvc_form_entry_note', '_dhvc_form_entry_note') ?>
                            <table class="widefat fixed entry-detail-notes">
                            	<tbody id="the-comment-list" class="list:comment">
                            		<?php 
                            		$notes = $dhvcform_db->get_entry_notes($entry->id);
                            		if(count($notes)):
                            		?>
                            		<?php foreach ($notes as $note):?>
                            		<?php $note_author = get_userdata($note->user_id);?>
                            		<tr valign="top">
				                        <td class="entry-note">
				                            <div style="margin-top:4px;">
				                                <div class="note-avatar"><?php echo  get_avatar($note->user_id, 48) ?></div>
				                                <div class="note-author"> <?php echo esc_html($note_author->display_name)?></div>
				                                <p style="line-height:130%; text-align:left; margin-top:3px;">
				                                	<a href="mailto:<?php echo esc_attr($note_author->user_email)?>"><?php echo esc_html($note_author->user_email) ?></a><br />
				                                	<span style="font-size: 11px;color: #999">
				                                	<?php _e("added on", DHVC_FORM); ?> <?php echo esc_html(mysql2date( __( 'Y/m/d g:i:s A' ),$note->created,true )) ?>  <a href="javascript:void(0)" id="delete_note" data-note-id = "<?php echo $note->id ?>" style="color: #a00;text-decoration: underline;"><?php _e('Delete note',DHVC_FORM)?></a>
				                                	</span>	
				                                </p>
				                            </div>
				                            <div class="detail-note-content"><?php echo esc_html($note->message) ?></div>
				                        </td>
					                </tr>
                            		<?php endforeach;?>
                            		<?php endif;?>
					                <tr>
										<td style="padding:10px;" class="lastrow">
											<textarea name="entry_message" style="width:100%; height:50px; margin-bottom:4px;"></textarea>
											<?php
											$note_button = '<input type="button" id="add_note" name="add_note" value="' . __("Add Note", DHVC_FORM) . '" class="button" style="width:auto;padding-bottom:2px;"/>';
											echo $note_button;
											?>
										</td>
									</tr>
					        	</tbody>
                            </table>       
                        </form>
					</div>
				</div>
			</div>
			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox ">
					<div class="handlediv" title="<?php echo esc_html_e('Click to toggle',DHVC_FORM) ?>"><br></div>
					<h3 class="hndle"><span><?php echo esc_html_e('Additional information',DHVC_FORM)?></span></h3>
					<div class="inside">
						<div class="dhvcform_additional_information">
							<p>
								<label><strong><?php echo esc_html_e('Date',DHVC_FORM) ?>:</strong></label>
								<span style="display: block;margin:5px 0 0"><?php echo mysql2date( __( 'Y/m/d g:i:s A' ),$entry->submitted,true ); ?></span>
							</p>
							<p>
								<label><strong><?php echo esc_html_e('Form',DHVC_FORM) ?>:</strong></label>
								<span style="display: block;margin:5px 0 0;"><a href="<?php echo get_edit_post_link($entry->form_id); ?>"><?php echo get_the_title($entry->form_id); ?></a></span>
							</p>
							<p>
								<label><strong><?php echo esc_html_e('Embed Url',DHVC_FORM) ?>:</strong></label>
								<span style="display: block;margin:5px 0 0;"><a href="<?php echo $entry->form_url; ?>"><?php echo $entry->form_url; ?></a></span>
							</p>
							<?php if(!empty($entry->user_id) &&  $usermeta = get_userdata($entry->user_id)):?>
							<p>
								<label><strong><?php echo esc_html_e('User',DHVC_FORM) ?>:</strong></label>
								<span style="display: block;margin:5px 0 0;">
									<a href="user-edit.php?user_id=<?php echo absint($entry->user_id) ?>" title="<?php _e("View user profile",DHVC_FORM); ?>"><?php echo esc_html($usermeta->user_login) ?></a>                                     
								</span>
							</p>
							<?php endif;?>
							<p>
								<label><strong><?php echo esc_html_e('IP Address',DHVC_FORM) ?>:</strong></label>
								<span style="display: block;margin:5px 0 0;"> <?php echo $entry->ip_address; ?> </span>
							</p>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
	endif;
	}
	
	public function entries_page(){
		if(isset($_GET['action']) && $_GET['action'] == 'view'){
			if ( ! current_user_can('edit_dhvcforms') )
				wp_die( __( 'Cheatin&#8217; uh?' ) );
			
			$this->_view_entry();
		}else{
			if ( ! current_user_can('edit_dhvcforms'))
				wp_die( __( 'Cheatin&#8217; uh?' ) );
			
			$this->_list_entry();
		}
	}
	
	public function settings_page(){
		?>
<div class="wrap">
	<h2><?php echo __('Settings',DHVC_FORM)?></h2>
	<form action="options.php" method="post">	
		<?php settings_fields('dhvc_form'); ?>
		<table class="form-table">
			<tbody>
				<?php 
				foreach ($this->setting_fields as $id=>$params): 
				$params = wp_parse_args((array)$params,array(
						'type'=>'',
						'help'=>'',
						'label'=>'',
						'default'=>'',
						'options'=>array()
				));

				extract($params);
				?>
				<tr valign="top">
					<?php if($type=='heading'):?>
					<td colspan="2" style="padding: 0;">
						<h3 style="margin-bottom: 0px;"><?php echo $label ?></h3>
						<p><?php echo $help?></p></td>
					<?php else:?>
						<th scope="row"><label for="<?php echo $id ?>"><?php echo $label ?></label></th>
						<?php $this->render_seting_field($id, $params);?>
					<?php endif;?>
				</tr>
				<?php endforeach;?>
			</tbody>
		</table>
		<p class="submit">
			<input type="submit" value="<?php echo __('Save Changes',DHVC_FORM) ?>" class="button button-primary" id="submit" name="submit">
		</p>
	</form>
</div>
<?php
	}
	
	public function render_seting_field($id,$params){
		$params = wp_parse_args((array)$params,array(
			'type'=>'',
			'help'=>'',
			'label'=>'',
			'default'=>'',
			'help' =>'',
			'options'=>array()
		));
		
		extract($params,EXTR_SKIP);
		
		$name = 'dhvc_form['.$id.']';
		
		echo '<td scope="row">';
		switch ($type){
			case 'text':
				echo '<input type="text" id="'.$id.'" value="'.dhvc_form_get_option($id,$default).'" name="'.$name.'" />';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'textarea':
				echo '<textarea id="'.$id.'" name="'.$name.'" style=" height: 99px;width: 441px;">'.esc_textarea(dhvc_form_get_option($id,$default)).'</textarea>';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'password':
				echo '<input type="password" id="'.$id.'" value="'.dhvc_form_get_option($id,$default).'" name="'.$name.'" />';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'checkbox':
				echo '<input type="checkbox" id="'.$id.'" '.(dhvc_form_get_option($id,$default) == '1' ? ' checked="checked"' : '' ).' value="1" name="'.$name.'">';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'color':
				echo '<input data-default-color="#336CA6" type="text" id="'.$id.'" value="'.dhvc_form_get_option($id,$default).'" name="'.$name.'" />';
				echo '<script type="text/javascript">
								jQuery(document).ready(function($){
								    $("#'.$id.'").wpColorPicker();
								});
							 </script>
							 ';
				break;
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
			case 'select':
				echo '<select id="'.$id.'" name="'.$name.'">';
				foreach ($options as $key=>$value){
					$selected = dhvc_form_get_option($id,$default) == $key ? ' selected="selected"' : '';
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				echo '</select>';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
				break;
			case 'mailchimp_list':
				echo '<select id="'.$id.'" name="'.$name.'">';
				if($mailchimp_api = dhvc_form_get_option('mailchimp_api',false)){
					if(!class_exists('MCAPI'))
						require_once DHVC_FORM_DIR.'/includes/MCAPI.class.php';
					$api = new MCAPI($mailchimp_api);
					$lists = $api->lists();
					if ($api->errorCode){
						$options = array(__("Unable to load MailChimp lists, check your API Key.", DHVC_FORM));
					}else{
						if ($lists['total'] == 0){
							$options = array(__("You have not created any lists at MailChimp",DHVC_FORM));
						}
						$options = array(__('Select a list',DHVC_FORM));
						foreach ($lists['data'] as $list){
							$options[$list['id']] = $list['name'];
						}
					}
				}
				foreach ($options as $key=>$value){
					$selected = dhvc_form_get_option($id,$default) == $key ? ' selected="selected"' : '';
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				echo '</select>';
				if(!empty($help)){
					echo '<p>'.$help.'</p>';
				}
			break;
			default:
				break;
		}
		echo '</td>';
	}
	
}

new DHVCFormAdmin();