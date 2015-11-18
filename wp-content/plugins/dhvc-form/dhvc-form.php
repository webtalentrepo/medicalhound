<?php
/*
* Plugin Name: DHVC Form
* Plugin URI: http://sitesao.com/dhvcform/
* Description: Easy Form Bulder for Wordpress with Visual Composer
* Version: 1.3.7
* Author: Sitesao
* Author URI: http://sitesao.com/
* License: License GNU General Public License version 2 or later;
* Copyright 2014  Sitesao
* ULT ID: 34
*/
$current_default= get_option( 'stylesheet' );
$theme = wp_get_theme( $current_default );
if(strtolower($theme->get('Template')) =='ultimatum' || strtolower($theme->get('Name')) =='ultimatum') {

	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	} // Exit if accessed directly

	if ( ! defined( 'DHVC_FORM' ) ) {
		define( 'DHVC_FORM', 'dhvc-form' );
	}

	if ( ! defined( 'DHVC_FORM_FILE' ) ) {
		define( 'DHVC_FORM_FILE', __FILE__ );
	}

	if ( ! defined( 'DHVC_FORM_VERSION' ) ) {
		define( 'DHVC_FORM_VERSION', '1.3.7' );
	}

	if ( ! defined( 'DHVC_FORM_URL' ) ) {
		define( 'DHVC_FORM_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
	}

	if ( ! defined( 'DHVC_FORM_DIR' ) ) {
		define( 'DHVC_FORM_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
	}

	if ( ! defined( 'DHVC_FORM_TEMPLATE_DIR' ) ) {
		define( 'DHVC_FORM_TEMPLATE_DIR', DHVC_FORM_DIR . '/templates/' );
	}


	global $dhvc_form_popup;
	$dhvc_form_popup = null;

	class DHVCForm {

		public function __construct() {

			add_action( 'init', array( &$this, 'init' ) );
			add_action( 'init', array( &$this, 'register_post_type' ), 0 );

			//includes
			require_once( DHVC_FORM_DIR . '/includes/query.php' );
			require_once( DHVC_FORM_DIR . '/includes/functions.php' );

			register_activation_hook( DHVC_FORM_FILE, array( &$this, 'activate' ) );
			register_deactivation_hook( DHVC_FORM_FILE, array( &$this, 'deactivate' ) );
		}

		public function init() {

			if ( class_exists( 'WYSIJA' ) ) {
				define( 'DHVC_FORM_SUPORT_WYSIJA', true );
			}

			if ( defined( 'MYMAIL_DIR' ) ) {
				define( 'DHVC_FORM_SUPORT_MYMAIL', true );
			}

			if ( ! defined( 'WPB_VC_VERSION' ) ) {
				add_action( 'admin_notices', array( &$this, 'notice' ) );

				return;
			}

			if ( ! session_id() ) {
				session_start();
			}

			load_plugin_textdomain( DHVC_FORM, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );


			if ( is_admin() ) {
				require_once( DHVC_FORM_DIR . '/includes/admin.php' );
			}
			add_action( 'wp_ajax_dhvc_form_recaptcha', array( $this, 'check_recaptcha' ) );
			add_action( 'wp_ajax_nopriv_dhvc_form_recaptcha', array( $this, 'check_recaptcha' ) );

			add_action( 'wp_ajax_dhvc_form_recaptcha2', array( $this, 'dhvc_form_recaptcha2' ) );
			add_action( 'wp_ajax_nopriv_dhvc_form_recaptcha2', array( $this, 'dhvc_form_recaptcha2' ) );

			add_action( 'wp_ajax_dhvc_form_captcha', array( $this, 'check_captcha' ) );
			add_action( 'wp_ajax_nopriv_dhvc_form_captcha', array( $this, 'check_captcha' ) );

			add_action( 'wp_ajax_dhvc_form_ajax', array( $this, 'ajax_processor' ) );
			add_action( 'wp_ajax_nopriv_dhvc_form_ajax', array( $this, 'ajax_processor' ) );

			add_filter( 'login_url', array( &$this, 'login_url' ) );
			add_filter( 'logout_url', array( &$this, 'logout_url' ) );
			add_filter( 'register_url', array( &$this, 'register_url' ) );
			add_filter( 'lostpassword_url', array( &$this, 'lostpassword_url' ) );

			require_once( DHVC_FORM_DIR . '/includes/shortcodes.php' );
			require_once( DHVC_FORM_DIR . '/includes/map.php' );
			if ( is_admin() ) {
				$this->register_assets();
			} else {
				add_action( 'template_redirect', array( &$this, 'register_assets' ) );
			}
			if ( ! is_admin() ) {
				add_action( 'wp_enqueue_scripts', array( &$this, 'frontend_assets' ) );
				add_action( 'wp_head', array( &$this, 'dhvc_form_popup' ), 100 );
				add_action( 'wp_footer', array( &$this, 'dhvc_form_print_form_popup' ), 50 );
				add_action( 'wp_footer', 'dhvc_form_print_js_declaration', 100 );
			}
			if ( isset( $_REQUEST['dhvc_form'] ) && ! isset( $_REQUEST['_dhvc_form_is_ajax_call'] ) ) {
				$this->processor();
			}
		}

		public function activate() {
			global $dhvcform_db;
			$dhvcform_db->create_table();

			$this->create_roles();
			$this->register_post_type();
		}

		public function create_roles() {
			global $wp_roles;

			if ( class_exists( 'WP_Roles' ) ) {
				if ( ! isset( $wp_roles ) ) {
					$wp_roles = new WP_Roles();
				}
			}

			if ( is_object( $wp_roles ) ) {

				$capability = array(
					"edit_dhvcform",
					"read_dhvcform",
					"delete_dhvcform",
					"edit_dhvcforms",
					"edit_others_dhvcforms",
					"publish_dhvcforms",
					"read_private_dhvcforms",
					"delete_dhvcforms",
					"delete_private_dhvcforms",
					"delete_published_dhvcforms",
					"delete_others_dhvcforms",
					"edit_private_dhvcforms",
					"edit_published_dhvcforms",
				);
				foreach ( $capability as $cap ) {
					$wp_roles->add_cap( 'administrator', $cap );
				}
			}
		}

		public function deactivate() {
			global $wp_roles;

			if ( class_exists( 'WP_Roles' ) ) {
				if ( ! isset( $wp_roles ) ) {
					$wp_roles = new WP_Roles();
				}
			}

			if ( is_object( $wp_roles ) ) {

				$capability = array(
					"edit_dhvcform",
					"read_dhvcform",
					"delete_dhvcform",
					"edit_dhvcforms",
					"edit_others_dhvcforms",
					"publish_dhvcforms",
					"read_private_dhvcforms",
					"delete_dhvcforms",
					"delete_private_dhvcforms",
					"delete_published_dhvcforms",
					"delete_others_dhvcforms",
					"edit_private_dhvcforms",
					"edit_published_dhvcforms",
				);
				foreach ( $capability as $cap ) {
					$wp_roles->remove_cap( 'administrator', $cap );
				}
			}
		}

		public function register_post_type() {
			if ( post_type_exists( 'dhvcform' ) ) {
				return;
			}

			register_post_type( "dhvcform",
				apply_filters( 'dhvc_form_register_post_type',
					array(
						'labels'              => array(
							'name'               => __( 'Forms', DHVC_FORM ),
							'singular_name'      => __( 'Form', DHVC_FORM ),
							'menu_name'          => _x( 'Forms', 'Admin menu name', DHVC_FORM ),
							'add_new'            => __( 'Add Form', DHVC_FORM ),
							'add_new_item'       => __( 'Add New Form', DHVC_FORM ),
							'edit'               => __( 'Edit', DHVC_FORM ),
							'edit_item'          => __( 'Edit Form', DHVC_FORM ),
							'new_item'           => __( 'New Form', DHVC_FORM ),
							'view'               => __( 'View Form', DHVC_FORM ),
							'view_item'          => __( 'View Form', DHVC_FORM ),
							'search_items'       => __( 'Search Forms', DHVC_FORM ),
							'not_found'          => __( 'No Forms found', DHVC_FORM ),
							'not_found_in_trash' => __( 'No Forms found in trash', DHVC_FORM ),
							'parent'             => __( 'Parent Form', DHVC_FORM )
						),
						'description'         => __( 'This is where you can add new form.', DHVC_FORM ),
						'public'              => true,
						'show_ui'             => true,
						'capability_type'     => 'dhvcform',
						'map_meta_cap'        => true,
						'publicly_queryable'  => false,
						'exclude_from_search' => false,
						'show_in_menu'        => 'dhvc-form',
						'hierarchical'        => false, // Hierarchical causes memory issues - WP loads all records!
						'rewrite'             => false,
						'query_var'           => false,
						'supports'            => array( 'title', 'editor', 'custom-fields' ),
						'show_in_nav_menus'   => false,
						'show_in_admin_bar'   => false
					)
				)
			);
		}

		public function login_url( $login_url ) {
			$user_login = dhvc_form_get_option( 'user_login' );
			if ( $user_login ) {
				$login_url = get_permalink( $user_login );
			}

			return $login_url;
		}

		public function register_url( $register_url ) {
			$user_regiter = dhvc_form_get_option( 'user_regiter' );
			if ( $user_regiter ) {
				$register_url = get_permalink( $user_regiter );
			}

			return $register_url;
		}

		public function logout_url( $logout_url, $redirect = '' ) {
			$user_logout = dhvc_form_get_option( 'user_logout_redirect_to' );
			$args        = array();
			if ( $user_logout ) {
				$redirect_to         = get_permalink( $user_logout );
				$args['redirect_to'] = urlencode( $redirect_to );
			}

			return add_query_arg( $args, $logout_url );
		}

		public function lostpassword_url( $lostpassword_url ) {
			$user_forgotten = dhvc_form_get_option( 'user_forgotten' );
			if ( $user_forgotten ) {
				$lostpassword_url = get_permalink( $user_forgotten );
			}

			return $lostpassword_url;
		}

		public function register_assets() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

			wp_register_style( 'dhvc-form-font-awesome', DHVC_FORM_URL . '/assets/fonts/font-awesome/css/font-awesome' . $suffix . '.css', array(), '4.1.0' );
			wp_register_style( 'dhvc-form-datetimepicker', DHVC_FORM_URL . '/assets/datetimepicker/jquery.datetimepicker.css', array(), '2.2.9' );
			wp_register_script( 'dhvc-form-datetimepicker', DHVC_FORM_URL . '/assets/datetimepicker/jquery.datetimepicker.js', array( 'jquery' ), '2.2.9' );
			wp_register_style( 'dhvc-form-minicolor', DHVC_FORM_URL . '/assets/minicolors/jquery.minicolors' . $suffix . '.css', array(), '2.1' );
			wp_register_script( 'dhvc-form-minicolor', DHVC_FORM_URL . '/assets/minicolors/jquery.minicolors' . $suffix . '.js', array( 'jquery' ), '2.1' );

			wp_register_script( 'dhvc-form-validate-methods', DHVC_FORM_URL . '/assets/validate/additional-methods' . $suffix . '.js', array( 'jquery' ), '1.12.0' );
			wp_register_script( 'dhvc-form-validate', DHVC_FORM_URL . '/assets/validate/jquery.validate' . $suffix . '.js', array( 'jquery' ), '1.12.0' );

			wp_register_script( 'dhvc-form-recaptcha', 'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js', array( 'jquery' ) );

		}

		public function frontend_assets() {
			$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_register_style( 'dhvc-form', DHVC_FORM_URL . '/assets/css/style.css', array(), DHVC_FORM_VERSION );
			wp_register_script( 'dhvc-form', DHVC_FORM_URL . '/assets/js/script.js', array(
				'jquery',
				'dhvc-form-validate'
			), DHVC_FORM_VERSION, true );

			$args         = array(
				'post_type'      => 'dhvcform',
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
			);
			$form         = new WP_Query( $args );
			$inline_style = '';
			if ( $form->have_posts() ) {
				while ( $form->have_posts() ):
					$form->the_post();
					global $post;

					if ( $label_color = get_post_meta( get_the_ID(), '_label_color', true ) ) {
						$inline_style .= '
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-label,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group label{
	color:' . $label_color . '
}';
					}
					if ( $placeholder_color = get_post_meta( get_the_ID(), '_placeholder_color', true ) ) {
						$inline_style .= '
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-add-on{
	color:' . $placeholder_color . ';
}
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-control::-webkit-input-placeholder {
	color:' . $placeholder_color . ';
}

#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-control:-moz-placeholder {
	color:' . $placeholder_color . ';
}

#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-control::-moz-placeholder {
	color:' . $placeholder_color . ';
}

#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-control:-ms-input-placeholder {
	color:' . $placeholder_color . ';
}
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-control:focus::-webkit-input-placeholder {
	color: transparent;
}';
					}
					if ( $input_height = get_post_meta( get_the_ID(), '_input_height', true ) ) {
						$inline_style .= '
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file input[type="text"], 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select select,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-add-on,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file-button i,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select i{
 height:' . $input_height . ';
}
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select i,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file-button i,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-group .dhvc-form-add-on{
  line-height:' . $input_height . ';
}
';
					}

					if ( $input_bg_color = get_post_meta( get_the_ID(), '_input_bg_color', true ) ) {
						$inline_style .= '
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file input[type="text"], 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select select,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-radio i,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-checkbox i,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-textarea textarea{
	background-color:' . $input_bg_color . ';			
}';
					}
					if ( $input_text_color = get_post_meta( get_the_ID(), '_input_text_color', true ) ) {
						$inline_style .= '
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file input[type="text"], 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select select,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-textarea textarea{
	color:' . $input_text_color . ';			
}';
					}
					if ( $input_border_size = get_post_meta( get_the_ID(), '_input_border_size', true ) ) {
						$inline_style .= '
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file input[type="text"], 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha input, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select select, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-radio i, 
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-checkbox i,
#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-textarea textarea{
	border-width:' . $input_border_size . ';
}';
					}
					if ( $input_border_color = get_post_meta( get_the_ID(), '_input_border_color', true ) ) {
						$inline_style .= '#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input input,#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha input, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file input[type="text"], #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select select, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-textarea textarea, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-radio i, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-checkbox i,#dhvcform-' . get_the_ID() . '.dhvc-form-flat .ui-slider{border-color:' . $input_border_color . '}';
					}
					if ( $input_hover_border_color = get_post_meta( get_the_ID(), '_input_hover_border_color', true ) ) {
						$inline_style .= '#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input:hover input,#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha:hover input, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file:hover input[type="text"], #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select:hover select, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-textarea:hover textarea, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-radio label:hover i, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-checkbox label:hover i,#dhvcform-' . get_the_ID() . '.dhvc-form-flat .ui-slider-range{border-color:' . $input_hover_border_color . '}';
					}
					if ( $input_focus_border_color = get_post_meta( get_the_ID(), '_input_focus_border_color', true ) ) {
						$inline_style .= '#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-input input:focus,#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-captcha input:focus,  #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-file:hover input[type="text"]:focus, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-select select:focus, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-textarea textarea:focus, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-radio input:checked + i, #dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-checkbox input:checked + i{border-color:' . $input_focus_border_color . '}';
						$inline_style .= '#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-radio input + i:after{background-color:' . $input_focus_border_color . '}';
						$inline_style .= '#dhvcform-' . get_the_ID() . '.dhvc-form-flat .dhvc-form-checkbox input + i:after{color:' . $input_focus_border_color . '}';
					}
					if ( $button_height = get_post_meta( get_the_ID(), '_button_height', true ) ) {
						$inline_style .= '.dhvc-form-submit,.dhvc-form-submit:focus,.dhvc-form-submit:hover,.dhvc-form-submit:active{
				height:' . $button_height . ';
					line-height:' . $button_height . ';
			}';
					}

					if ( $button_bg_color = get_post_meta( get_the_ID(), '_button_bg_color', true ) ) {
						$inline_style .= '#dhvcform-' . get_the_ID() . ' .dhvc-form-submit, #dhvcform-' . get_the_ID() . ' .dhvc-form-submit:hover,#dhvcform-' . get_the_ID() . ' .dhvc-form-submit:active,#dhvcform-' . get_the_ID() . ' .dhvc-form-submit:focus,#dhvcform-' . get_the_ID() . ' .dhvc-form-file-button{background:' . $button_bg_color . '}';
					}
					if ( $wpb_custom_css = get_post_meta( get_the_ID(), '_wpb_post_custom_css', true ) ) {
						$inline_style .= $wpb_custom_css;
					}

				endwhile;
			}

			wp_reset_postdata();

			wp_add_inline_style( 'dhvc-form', dhvc_form_css_minify( $inline_style ) );
			wp_enqueue_style( 'dhvc-form-font-awesome' );
			wp_enqueue_style( 'dhvc-form' );

			$dhvcformL10n = array(
				'ajax_url'               => admin_url( 'admin-ajax.php', 'relative' ),
				'plugin_url'             => DHVC_FORM_URL,
				'allowed_file_extension' => str_replace( ',', '|', dhvc_form_get_option( 'allowed_file_extension', 'zip,rar,tar,7z,jpg,jpeg,png,gif,pdf,doc,docx,ppt,pptx,xls,xlsx' ) ),
				'date_format'            => dhvc_form_get_option( 'date_format', 'Y/m/d' ),
				'time_format'            => dhvc_form_get_option( 'time_format', 'H:i' ),
				'time_picker_step'       => dhvc_form_get_option( 'time_picker_step', 60 ),
				'datetimepicker_lang'    => dhvc_form_get_option( 'datetimepicker_lang', 'en' ),
				'container_class'        => dhvc_form_get_option( 'container_class', '.vc_row-fluid' ),
				'validate_messages'      => array(
					'required'    => __( "This field is required.", DHVC_FORM ),
					'remote'      => __( "Please fix this field.", DHVC_FORM ),
					'email'       => __( "Please enter a valid email address.", DHVC_FORM ),
					'url'         => __( "Please enter a valid URL.", DHVC_FORM ),
					'date'        => __( "Please enter a valid date.", DHVC_FORM ),
					'dateISO'     => __( "Please enter a valid date (ISO).", DHVC_FORM ),
					'number'      => __( "Please enter a valid number.", DHVC_FORM ),
					'digits'      => __( "Please enter only digits.", DHVC_FORM ),
					'creditcard'  => __( "Please enter a valid credit card number.", DHVC_FORM ),
					'equalTo'     => __( "Please enter the same value again.", DHVC_FORM ),
					'maxlength'   => __( "Please enter no more than {0} characters.", DHVC_FORM ),
					'minlength'   => __( "Please enter at least {0} characters.", DHVC_FORM ),
					'rangelength' => __( "Please enter a value between {0} and {1} characters long.", DHVC_FORM ),
					'range'       => __( "Please enter a value between {0} and {1}.", DHVC_FORM ),
					'max'         => __( "Please enter a value less than or equal to {0}.", DHVC_FORM ),
					'min'         => __( "Please enter a value greater than or equal to {0}.", DHVC_FORM ),
					'alpha'       => __( 'Please use letters only (a-z or A-Z) in this field.', DHVC_FORM ),
					'alphanum'    => __( 'Please use only letters (a-z or A-Z) or numbers (0-9) only in this field. No spaces or other characters are allowed.', DHVC_FORM ),
					'url'         => __( 'Please enter a valid URL. Protocol is required (http://, https:// or ftp://)', DHVC_FORM ),
					'zip'         => __( 'Please enter a valid zip code. For example 90602 or 90602-1234.', DHVC_FORM ),
					'fax'         => __( 'Please enter a valid fax number. For example (123) 456-7890 or 123-456-7890.', DHVC_FORM ),
					'cpassword'   => __( 'Please make sure your passwords match.', DHVC_FORM ),
					'select'      => __( 'Please select an option', DHVC_FORM ),
					'recaptcha'   => __( 'Please enter captcha words correctly', DHVC_FORM ),
					'captcha'     => __( 'Please enter captcha words correctly', DHVC_FORM ),
					'extension'   => __( 'Please enter a value with a valid extension.', DHVC_FORM )
				)
			);

			wp_localize_script( 'dhvc-form', 'dhvcformL10n', $dhvcformL10n );
			wp_enqueue_script( 'dhvc-form' );
		}

		public function dhvc_form_popup() {
			global $dhvc_form_popup;
			$args  = array(
				'post_type'      => 'dhvcform',
				'posts_per_page' => - 1,
				'post_status'    => 'publish',
			);
			$form  = new WP_Query( $args );
			$popup = array();
			if ( $form->have_posts() ):
				while ( $form->have_posts() ):
					$form->the_post();

					if ( get_post_meta( get_the_ID(), '_form_popup', true ) ) {

						$auto_open = get_post_meta( get_the_ID(), '_form_popup_auto_open', true );

						$one       = get_post_meta( get_the_ID(), '_form_popup_one', true );
						$close     = get_post_meta( get_the_ID(), '_form_popup_auto_close', true );
						$title     = get_post_meta( get_the_ID(), '_form_popup_title', true );
						$data_attr = '';
						if ( ! empty( $auto_open ) ) {
							$data_attr = 'data-auto-open="1" data-open-delay="' . absint( get_post_meta( get_the_ID(), '_form_popup_auto_open_delay', true ) ) . '" ' . ( ! empty( $one ) ? 'data-one-time="1"' : 'data-one-time="0"' ) . ' ' . ( ! empty( $close ) ? 'data-auto-close="1" data-close-delay="' . absint( get_post_meta( get_the_ID(), '_form_popup_auto_close_delay', true ) ) . '"' : 'data-auto-close="0"' );
						}
						$popup[] = '<div id="dhvcformpopup-' . get_the_ID() . '" data-id="' . get_the_ID() . '" class="dhvc-form-popup" ' . $data_attr . ' style="display:none">';
						$popup[] = '<div class="dhvc-form-popup-container" style="width:' . absint( get_post_meta( get_the_ID(), '_form_popup_width', true ) ) . 'px">';
						$popup[] = '<div class="dhvc-form-popup-header">';
						if ( ! empty( $title ) ) {
							$popup[] = '<h3>' . get_the_title( get_the_ID() ) . '</h3>';
						}
						$popup[] = '<a class="dhvc-form-popup-close"><span aria-hidden="true">&times;</span></a>';
						$popup[] = '</div>';
						$popup[] = '<div class="dhvc-form-popup-body">';
						$popup[] = do_shortcode( '[dhvc_form id="' . get_the_ID() . '"]' );
						$popup[] = '</div>';
						$popup[] = '</div>';
						$popup[] = '</div>';
					}
				endwhile;
			endif;
			$dhvc_form_popup = implode( "\n", $popup );
			if ( ! empty( $popup ) ) {
				$dhvc_form_popup .= '<div class="dhvc-form-pop-overlay"></div>';
			}
			wp_reset_postdata();

			return false;
		}

		public function dhvc_form_print_form_popup() {
			global $dhvc_form_popup;
			echo $dhvc_form_popup;

			return false;
		}

		public function dhvc_form_recaptcha2() {
			$recaptcha_value = isset( $_POST['recaptcha2_response'] ) ? (string) $_POST['recaptcha2_response'] : '';
			$site_key        = dhvc_form_get_option( 'recaptcha_public_key' );
			$secret_key      = dhvc_form_get_option( 'recaptcha_private_key' );
			$result          = array();
			if ( ! empty( $site_key ) && ! empty( $secret_key ) ) {
				if ( 0 == strlen( trim( $recaptcha_value ) ) ) {   //recaptcha is uncheked
					$result['success'] = false;
					$result['message'] = '<span class="dhvc-form-error">' . __( 'No CAPTCHA reCAPTCHA is unchecked, Check to proceed', DHVC_FORM ) . '</span>';
				} else {
					$captcha_value = $this->_check_recaptcha2( $recaptcha_value );
					if ( ! $captcha_value ) {  //google returned false
						$result['success'] = false;
						$result['message'] = '<span class="dhvc-form-error">' . __( 'It seems that you are a bot, Please try again.', DHVC_FORM ) . '</span>';
					}
					if ( $captcha_value ) {
						$result['success'] = true;
					}
				}
			}
			wp_send_json( $result );
		}

		private function _check_recaptcha2( $recaptcha_value ) {
			$secret_key = dhvc_form_get_option( 'recaptcha_private_key' );
			if ( isset( $_COOKIE['dhvc_form_captcha2_cookie'] ) && hash( 'sha512', $recaptcha_value . $secret_key ) == $_COOKIE['dhvc_form_captcha2_cookie'] ) {
				return true;
			}

			if ( empty( $secret_key ) ) {
				return false;
			}

			$no_ssl_array = array(
				'ssl' => array(
					'verify_peer'      => false,
					'verify_peer_name' => false
				)
			);

			//complusory for 5.6
			$ctx        = stream_context_create( $no_ssl_array );
			$json_reply = file_get_contents( "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret_key . "&response=" . $recaptcha_value, false, $ctx );

			$reply_obj = json_decode( $json_reply );

			if ( $reply_obj->success == 1 ) {
				setcookie( 'dhvc_form_captcha2_cookie', hash( 'sha512', $recaptcha_value . $secret_key ), strtotime( '+3 minutes' ) );

				return true;
			}

			return false;
		}


		public function check_recaptcha() {
			require_once( DHVC_FORM_DIR . '/includes/recaptchalib.php' );
			$privatekey = dhvc_form_get_option( 'recaptcha_private_key' );
			// reCaptcha looks for the POST to confirm
			$resp = recaptcha_check_answer( $privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"] );
			if ( $resp->is_valid ) {
				echo 1;
			} else {
				echo 0;
			}
			die;
		}

		public function check_captcha() {
			$answer = isset( $_POST['answer'] ) ? $_POST['answer'] : '';
			if ( empty( $_SESSION['dhvcformsecret'] ) || trim( strtolower( $answer ) ) !== $_SESSION['dhvcformsecret'] ) {
				unset( $_SESSION['dhvcformsecret'] );
				echo 0;
			} else {
				echo 1;
			}
			die;
		}

		public function notice() {
			$plugin = get_plugin_data( __FILE__ );
			echo '<div class="updated">
			    <p>' . sprintf( __( '<strong>%s</strong> requires <strong><a href="http://bit.ly/1gKaeh5" target="_blank">Visual Composer</a></strong> plugin to be installed and activated on your site.', DHVC_FORM ), $plugin['Name'] ) . '</p>
			  </div>';
		}


		public function processor( $is_ajax = false ) {

			global $dhvc_form_messages;

			if ( $_REQUEST['dhvc_form'] ) {
				// Strip slashes from the submitted data (WP adds them automatically)
				$_POST    = stripslashes_deep( $_POST );
				$_REQUEST = stripslashes_deep( $_REQUEST );
				$_GET     = stripslashes_deep( $_GET );


				$nonce   = $_REQUEST['_dhvc_form_nonce'];
				$form_id = $_REQUEST['dhvc_form'];

				$key = md5( 'dhvc_form_' . $form_id );

				$_SESSION[ $key ] = null;
				unset( $_SESSION[ $key ] );

				$result = wp_verify_nonce( $nonce, 'dhvc-form-' . $form_id );
				if ( false != $result && ( get_post_meta( $form_id, '_action_type', true ) === 'default' ) ) {
					//processor
					do_action( 'dhvc_form_before_processor', $form_id );
					$_on_success   = get_post_meta( $form_id, '_on_success', true );
					$_form_control = get_post_meta( $form_id, '_form_control', true );

					$default_action     = dhvc_form_get_actions();
					$additional_setting = get_post_meta( $form_id, '_additional_setting', true );
					$additional_setting = dhvc_form_additional_setting( 'on_sent_ok', $additional_setting, false );
					$additional_setting = apply_filters( 'dhvc_form_on_sent_ok', $additional_setting );
					if ( isset( $_REQUEST['_dhvc_form_action'] ) && in_array( $_REQUEST['_dhvc_form_action'], $default_action ) ) {
						$action = '_' . $_REQUEST['_dhvc_form_action'];
						if ( method_exists( $this, $action ) ) {
							$ajax_result = array();
							if ( ! empty( $additional_setting ) ) {
								$ajax_result['scripts_on_sent_ok'] = array_map( 'dhvc_form_strip_quote', $additional_setting );
							}
							$ajax_result['on_success']   = $_on_success;
							$ajax_result['redirect_url'] = '';
							$result                      = $this->$action( $_REQUEST );

							if ( ! $is_ajax ) {
								$_SESSION[ $key ] = $result['message'];
							}

							$ajax_result['message'] = $result['message'];
							$redirect_url           = $_REQUEST['form_url'];
							if ( $result['success'] ) {
								//save form register data
								$save_data = get_post_meta( $form_id, '_save_data', true );
								if ( $_form_control && ! empty( $save_data ) && $action == '_register' ) {
									$form_controls = json_decode( $_form_control );
									$this->_form_handler( $form_id, $form_controls, true, false, false );
								}
								//end save data
								if ( $_on_success === 'message' ) {
									$redirect_url = $_REQUEST['form_url'];
								} else {
									$redirect_to = get_post_meta( $form_id, '_redirect_to', true );
									if ( $redirect_to === 'to_url' ) {
										$redirect_url = get_post_meta( $form_id, '_url', true );
									} else {
										if ( $redirect_to === 'to_page' ) {
											$redirect_url = get_permalink( get_post_meta( $form_id, '_page', true ) );
										} else {
											$redirect_url = get_permalink( get_post_meta( $form_id, '_post', true ) );
										}
									}
									$_SESSION[ $key ] = null;
									unset( $_SESSION[ $key ] );
								}
								$ajax_result['redirect_url'] = $redirect_url;
								if ( $is_ajax ) {
									return $ajax_result;
								}

								wp_redirect( $redirect_url );
								exit;
							}
							$ajax_result['success'] = 0;
							if ( $is_ajax ) {
								return $ajax_result;
							}

							return false;

						}
					} else {
						if ( $_form_control ) {
							$form_controls = json_decode( $_form_control );
							$this->_form_handler( $form_id, $form_controls );
						}

						do_action( 'dhvc_form_after_processor', $form_id );

						$ajax_result               = array();
						$ajax_result['on_success'] = $_on_success;
						if ( ! empty( $additional_setting ) ) {
							$ajax_result['scripts_on_sent_ok'] = array_map( 'dhvc_form_strip_quote', $additional_setting );
						}
						$key = md5( 'dhvc_form_' . $form_id );

						if ( $_on_success === 'message' ) {
							$message                = get_post_meta( $form_id, '_message', true );
							$message                = dhvc_form_translate_variable( $message, $posted_data );
							$message                = apply_filters( 'dhvc_form_success_message', $message, $form_id );
							$ajax_result['message'] = $message;
							//$dhvc_form_messages[$form_id] = $message;
							if ( ! $is_ajax ) {
								$_SESSION[ $key ] = $message;
							}
						}

						$redirect_url = '';
						if ( $_on_success === 'message' ) {
							$redirect_url = $_REQUEST['form_url'];
							$redirect_url .= '#dhvcform-' . $form_id;
						} else {
							$redirect_to = get_post_meta( $form_id, '_redirect_to', true );
							if ( $redirect_to === 'to_url' ) {
								$redirect_url = get_post_meta( $form_id, '_redirect_url', true );
							} else {
								if ( $redirect_to === 'to_page' ) {
									$redirect_url = get_permalink( get_post_meta( $form_id, '_page', true ) );
								} else {
									$redirect_url = get_permalink( get_post_meta( $form_id, '_post', true ) );
								}
							}
							$_SESSION[ $key ] = null;
							unset( $_SESSION[ $key ] );
						}
						$ajax_result['redirect_url'] = $redirect_url;
						if ( $is_ajax ) {
							return $ajax_result;
						}

						wp_redirect( $redirect_url );
						exit;

					}
				}//
			}

			return false;
		}

		/**
		 * Form Hander
		 *
		 * @param unknown $form_id
		 * @param unknown $form_controls
		 * @param string $save_entery
		 * @param string $send_notice
		 * @param string $autoreply
		 *
		 * @throws phpmailerException
		 */
		private function _form_handler( $form_id, $form_controls, $save_entry = true, $send_notice = true, $autoreply = true ) {
			$entry_data  = array();
			$email_data  = array();
			$attachments = array();
			foreach ( $form_controls as $form_control ) {
				if ( $form_control->tag == 'dhvc_form_captcha' || $form_control->tag == 'dhvc_form_recaptcha' || $form_control->tag == 'dhvc_form_submit_button' ) {
					continue;
				}
				$email_data_key = ! empty( $form_control->control_label ) ? $form_control->control_label : $form_control->control_name;
				$email_data_key = ucfirst( $email_data_key );
				if ( array_key_exists( $form_control->control_name, $_FILES ) && is_array( $_FILES[ $form_control->control_name ] ) ) {
					$file = $_FILES[ $form_control->control_name ];

					$entry_data[ $form_control->control_name ] = '';
					$email_data[ $email_data_key ]             = '';
					if ( is_array( $file['error'] ) ) {

					} else {
						if ( $file['error'] === UPLOAD_ERR_OK ) {
							$pathInfo  = pathinfo( $file['name'] );
							$extension = isset( $pathInfo['extension'] ) ? $pathInfo['extension'] : '';

							$filename = strlen( $extension ) ? str_replace( ".$extension", '', $pathInfo['basename'] ) : $pathInfo['basename'];
							$filename = sanitize_file_name( $filename );
							if ( strlen( $extension ) ) {
								$filename = ( strlen( $filename ) ) ? "$filename.$extension" : "upload.$extension";
							} else {
								$filename = ( strlen( $filename ) ) ? $filename : 'upload';
							}
							$fullPath = $file['tmp_name'];

							$result = dhvc_form_upload( $fullPath, $filename );

							if ( is_array( $result ) ) {
								$fullpath = $result['fullpath'];
								$filename = $result['filename'];

								$value                                     = array(
									'filename' => $filename,
									'path'     => $result['path'] . $filename
								);
								$attachments[]                             = $result['fullpath'];
								$email_data[ $email_data_key ]             = $filename;
								$entry_data[ $form_control->control_name ] = $value;
							}

						}
					}
				} else {
					$entry_data[ $form_control->control_name ] = isset( $_REQUEST[ $form_control->control_name ] ) ? dhvc_form_format_value( $_REQUEST[ $form_control->control_name ] ) : '';
					$email_data[ $email_data_key ]             = $entry_data[ $form_control->control_name ];
				}
			}
			$save_data = get_post_meta( $form_id, '_save_data', true );
			//save entry
			$current_user = wp_get_current_user();
			if ( $save_data && $save_entry ) {
				global $dhvcform_db;
				$data = array(
					'entry_data' => maybe_serialize( $entry_data ),
					'submitted'  => gmdate( 'Y-m-d H:i:s' ),
					'ip_address' => dhvc_form_get_user_ip(),
					'form_id'    => $form_id,
					'post_id'    => isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : '',
					'form_url'   => isset( $_REQUEST['form_url'] ) ? $_REQUEST['form_url'] : '',
					'referer'    => isset( $_REQUEST['referer'] ) ? $_REQUEST['referer'] : '',
					'user_id'    => ( isset( $current_user->ID ) ? (int) $current_user->ID : 0 )

				);
				$dhvcform_db->insert_entry_data( $data );
			}
			$posted_data                      = $entry_data;
			$posted_data['site_url']          = get_site_url();
			$posted_data['ip_address']        = dhvc_form_get_user_ip();
			$posted_data['user_display_name'] = ( isset( $current_user->ID ) ? $current_user->display_name : '' );
			$posted_data['user_email']        = ( isset( $current_user->ID ) ? $current_user->user_email : '' );
			$posted_data['user_login']        = ( isset( $current_user->ID ) ? $current_user->ID : 0 );
			$posted_data['form_url']          = isset( $_REQUEST['form_url'] ) ? $_REQUEST['form_url'] : '';
			$posted_data['form_id']           = $form_id;
			$posted_data['form_title']        = get_the_title( $form_id );
			$posted_data['post_id']           = isset( $_REQUEST['post_id'] ) ? $_REQUEST['post_id'] : 0;
			$posted_data['post_title']        = get_the_title( $posted_data['post_id'] );
			$posted_data['submitted']         = date_i18n( dhvc_form_get_option( 'date_format', 'Y/m/d' ) ) . ' ' . date_i18n( dhvc_form_get_option( 'time_format', 'H:i' ) );

			$email_form_body                       = '';
			$newline                               = dhvc_form_email_newline();
			$dhvc_form_use_email_empty_field_value = apply_filters( 'dhvc_form_use_email_empty_field_value', true );
			foreach ( $email_data as $k => $v ) {
				if ( ! $dhvc_form_use_email_empty_field_value && empty( $v ) ) {
					continue;
				}

				$email_form_body .= '<strong>' . $k . ':</strong> ' . $v . $newline;
			}

			$posted_data['form_body'] = $email_form_body;

			$notice = get_post_meta( $form_id, '_notice', true );

			if ( $notice && $send_notice ) {
				//send email notice
				$mailer = dhvc_form_phpmailer();

				$notice_email_type = dhvc_get_post_meta( $form_id, '_notice_email_type', 'email_text' );
				if ( $notice_email_type == 'email_field' ) {
					$notice_variables = dhvc_get_post_meta( $form_id, '_notice_variables' );
					if ( $notice_variables ) {
						if ( isset( $posted_data[ $notice_variables ] ) && dhvc_form_validate_email( $posted_data[ $notice_variables ] ) ) {
							$mailer->From = trim( (string) $posted_data[ $notice_variables ] );
						}
					}
				} else {
					$mailer->From = trim( (string) dhvc_get_post_meta( $form_id, '_notice_email', get_option( 'admin_email' ) ) );

				}

				$mailer->FromName = trim( (string) dhvc_get_post_meta( $form_id, '_notice_name', get_option( 'blogname' ) ) );

				$recipients = get_post_meta( $form_id, '_notice_recipients', true );
				//$recipients_arr = explode("\n", $recipients);
				if ( is_array( $recipients ) && ! empty( $recipients ) ) {
					foreach ( (array) $recipients as $recipient ) {
						$recipient_email = trim( $recipient );
						if ( dhvc_form_validate_email( $recipient_email ) ) {
							$mailer->AddAddress( $recipient_email );
						}
					}
				}

				$subject         = get_post_meta( $form_id, '_notice_subject', true );
				$subject         = dhvc_form_translate_variable( $subject, $posted_data );
				$mailer->Subject = trim( (string) $subject );

				$body = get_post_meta( $form_id, '_notice_body', true );
				$html = false;
				if ( get_post_meta( $form_id, '_notice_html', true ) ) {
					$html = true;
				}

				$body = dhvc_form_translate_variable( $body, $posted_data, $html );
				$body = apply_filters( 'dhvc_form_notice_body', $body, $form_id );

				if ( $html ) {
					$mailer->MsgHTML( wpautop( $body ) );
				} else {
					$mailer->Body = $body;
				}

				if ( ! empty( $attachments ) ) {
					foreach ( $attachments as $attachment ) {
						try {
							$mailer->AddAttachment( $attachment );
						} catch ( phpmailerException $e ) {
							continue;
						}
					}
				}

				try {
					$r = $mailer->Send();
				} catch ( phpmailerException $e ) {
					if ( WP_DEBUG ) {
						throw $e;
					}
				}

			}

			$reply = get_post_meta( $form_id, '_reply', true );
			//send reply
			if ( $reply && $autoreply ) {
				//send email reply

				$recipients = get_post_meta( $form_id, '_reply_recipients', true );
				if ( $recipients ) {
					if ( isset( $posted_data[ $recipients ] ) && dhvc_form_validate_email( $posted_data[ $recipients ] ) ) {
						$mailer = dhvc_form_phpmailer();

						$mailer->From     = trim( (string) dhvc_get_post_meta( $form_id, '_reply_email', get_option( 'admin_email' ) ) );
						$mailer->FromName = trim( (string) dhvc_get_post_meta( $form_id, '_reply_name', get_option( 'blogname' ) ) );


						$mailer->AddAddress( $posted_data[ $recipients ] );

						$subject         = get_post_meta( $form_id, '_reply_subject', true );
						$subject         = dhvc_form_translate_variable( $subject, $posted_data );
						$mailer->Subject = trim( (string) $subject );

						$body = get_post_meta( $form_id, '_reply_body', true );
						$html = false;
						if ( get_post_meta( $form_id, '_reply_html', true ) ) {
							$html = true;
						}

						$body = dhvc_form_translate_variable( $body, $posted_data, $html );
						$body = apply_filters( 'dhvc_form_reply_body', $body, $form_id );
						if ( $html ) {
							$mailer->MsgHTML( $body );
						} else {
							$mailer->Body = $body;
						}


						try {
							$r = $mailer->Send();
						} catch ( phpmailerException $e ) {
							if ( WP_DEBUG ) {
								throw $e;
							}
						}
					}
				}
			}
		}


		public function ajax_processor() {
			if ( dhvc_form_is_xhr() && $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$result = $this->processor( true );
				$echo   = array();
				if ( false === $result ) {
					$echo['success'] = isset( $result['success'] ) ? $result['success'] : 0;
				} else {
					$echo            = $result;
					$echo['success'] = isset( $result['success'] ) ? $result['success'] : 1;
				}

				echo json_encode( $echo );
				exit;
			}
		}

		protected function _mymail( $data ) {
			if ( ! defined( 'MYMAIL_DIR' ) ) {
				return array(
					'success' => false,
					'message' => __( 'myMail Newsletters not exists!.', DHVC_FORM ),
				);
			}
			$form_id               = $_REQUEST['dhvc_form'];
			$lists                 = dhvc_get_post_meta( $form_id, '_mymail', array() );
			$double_opt_in         = dhvc_get_post_meta( $form_id, '_mymail_double_opt_in', 0 ) == '1' ? true : false;
			$userdata['firstname'] = isset( $data['firstname'] ) ? trim( preg_replace( '/\s*\[[^)]*\]/', '', $data['firstname'] ) ) : '';
			$userdata['lastname']  = isset( $data['lastname'] ) ? trim( preg_replace( '/\s*\[[^)]*\]/', '', $data['lastname'] ) ) : '';
			$email                 = isset( $data['email'] ) ? $data['email'] : '';
			if ( ! is_email( $email ) ) {
				return array(
					'success' => false,
					'message' => __( 'The email address isn\'t correct.', DHVC_FORM ),
				);
			}
			$ret = mymail_subscribe( $email, $userdata, $lists, $double_opt_in, true );
			if ( ! $ret ) {
				return array(
					'success' => false,
					'message' => __( 'Not Subscribe to our Newsletters!', DHVC_FORM ),
				);
			} else {
				return array(
					'success' => true,
					'message' => __( 'Subscribe to our Newsletters successful!', DHVC_FORM ),
				);
			}
		}

		protected function _mailpoet( $data ) {
			if ( ! class_exists( 'WYSIJA' ) ) {
				return array(
					'success' => false,
					'message' => __( 'MailPoet Newsletters not exists!.', DHVC_FORM ),
				);
			}
			$form_id                              = $_REQUEST['dhvc_form'];
			$list_submit['user_list']['list_ids'] = dhvc_get_post_meta( $form_id, '_mailpoet', array() );
			$list_submit['user']['firstname']     = isset( $data['firstname'] ) ? trim( preg_replace( '/\s*\[[^)]*\]/', '', $data['firstname'] ) ) : '';
			$list_submit['user']['lastname']      = isset( $data['lastname'] ) ? trim( preg_replace( '/\s*\[[^)]*\]/', '', $data['lastname'] ) ) : '';
			$list_submit['user']['email']         = isset( $data['email'] ) ? $data['email'] : '';
			if ( ! is_email( $list_submit['user']['email'] ) ) {
				return array(
					'success' => false,
					'message' => __( 'The email address isn\'t correct.', DHVC_FORM ),
				);
			}
			//WYSIJA_help_user
			$helper_user = WYSIJA::get( 'user', 'helper' );
			$result      = $helper_user->addSubscriber( $list_submit );
			if ( ! $result ) {
				$message = $helper_user->getMsgs();

				return array(
					'success' => false,
					'message' => implode( '<br>', $message['error'] ),
				);
			} else {
				return array(
					'success' => true,
					'message' => sprintf( __( 'MailPoet Added: %s to list <strong>%s</strong>', DHVC_FORM ), $list_submit['user']['email'], implode( ', ', dhvc_form_get_mailpoet_subscribers_list( $list_submit['user']['list_ids'] ) ) ),
				);
			}
		}

		protected function _mailchimp( $data ) {
			$mailchimp_api = dhvc_form_get_option( 'mailchimp_api', false );
			$success       = false;
			$message       = '';
			if ( $mailchimp_api ) {
				if ( ! class_exists( 'MCAPI' ) ) {
					require_once DHVC_FORM_DIR . '/includes/MCAPI.class.php';
				}

				$api                  = new MCAPI( $mailchimp_api );
				$fname                = isset( $data['name'] ) ? '' : '';
				$list_id              = dhvc_form_get_option( 'mailchimp_list', 0 );
				$list_id              = apply_filters( 'dhvc_form_mailchimp_list', $list_id, $data );
				$first_name           = isset( $data['first_name'] ) ? $data['first_name'] : ( isset( $data['name'] ) ? $data['name'] : '' );
				$last_name            = isset( $data['last_name'] ) ? $data['last_name'] : ( isset( $data['name'] ) ? $data['name'] : '' );
				$email_address        = isset( $data['email'] ) ? $data['email'] : '';
				$merge_vars           = array(
					'FNAME' => $first_name,
					'LNAME' => $last_name,
				);
				$mailchimp_group_name = dhvc_form_get_option( 'mailchimp_group_name', '' );
				$mailchimp_group      = dhvc_form_get_option( 'mailchimp_group', '' );
				if ( ! empty( $mailchimp_group ) && ! empty( $mailchimp_group_name ) ) {
					$merge_vars['GROUPINGS'] = array(
						array( 'name' => $mailchimp_group_name, 'groups' => $mailchimp_group ),
					);
				}
				$merge_vars        = apply_filters( 'dhvc_form_mailchimp_groupings', $merge_vars, $data );
				$double_optin      = dhvc_form_get_option( 'mailchimp_opt_in', '' ) === '1' ? true : false;
				$replace_interests = dhvc_form_get_option( 'mailchimp_replace_interests', '' ) === '1' ? true : false;
				$send_welcome      = dhvc_form_get_option( 'mailchimp_welcome_email', '' ) === '1' ? true : false;

				try {
					$retval  = $api->listSubscribe( $list_id, $email_address, $merge_vars, $email_type = 'html', $double_optin, false, $replace_interests, $send_welcome );
					$success = $retval;
				} catch ( Exception $e ) {
					if ( $e->getCode() == 214 ) {
						$success = true;
					} else {
						$message = $e->getMessage();
					}
				}


			}
			// Check the results of our Subscribe and provide the needed feedback
			if ( ! $success ) {
				return array(
					'success' => false,
					'message' => __( 'Not Subscribe to Mailchimp!', DHVC_FORM ),
				);
			} else {
				return array(
					'success' => true,
					'message' => __( 'Subscribe to Mailchimp Successful!', DHVC_FORM ),
				);
			}
		}

		protected function _login( $data ) {
			$data['user_login']    = isset( $data['username'] ) ? $data['username'] : '';
			$data['user_password'] = isset( $data['password'] ) ? $data['password'] : '';
			$data['remember']      = isset( $data['rememberme'] ) ? $data['rememberme'] : '';

			$user = wp_signon( $data, false );
			// Check the results of our login and provide the needed feedback
			if ( is_wp_error( $user ) ) {
				return array(
					'success' => false,
					'message' => __( 'Wrong Username or Password!', DHVC_FORM ),
				);
			} else {
				return array(
					'success' => true,
					'message' => __( 'Login Successful!', DHVC_FORM ),
				);
			}
		}

		protected function _register( $data ) {
			if ( get_option( 'users_can_register' ) ) {
				$user_login     = isset( $data['user_login'] ) ? $data['user_login'] : '';
				$user_email     = isset( $data['user_email'] ) ? $data['user_email'] : '';
				$user_password  = isset( $data['user_password'] ) ? $data['user_password'] : '';
				$cuser_password = isset( $data['cuser_password'] ) ? $data['cuser_password'] : '';

				$ret = $this->_register_new_user( $user_login, $user_email, $user_password, $cuser_password );

				if ( is_wp_error( $ret ) ) {
					return array(
						'success' => false,
						'message' => $ret->get_error_message(),
					);
				} else {
					return array(
						'success' => true,
						'message' => __( 'Registration complete.', DHVC_FORM )
					);
				}
			} else {
				return array(
					'success' => false,
					'message' => __( 'Not allow register in site.', DHVC_FORM ),
				);
			}
		}

		private function _register_new_user( $user_login, $user_email, $user_password = '', $cuser_password = '' ) {

			$errors               = new WP_Error();
			$sanitized_user_login = sanitize_user( $user_login );
			$user_email           = apply_filters( 'user_registration_email', $user_email );

			// Check the username was sanitized
			if ( $sanitized_user_login == '' ) {
				$errors->add( 'empty_username', __( 'Please enter a username.', DHVC_FORM ) );
			} elseif ( ! validate_username( $user_login ) ) {
				$errors->add( 'invalid_username', __( 'This username is invalid because it uses illegal characters. Please enter a valid username.', DHVC_FORM ) );
				$sanitized_user_login = '';
			} elseif ( username_exists( $sanitized_user_login ) ) {
				$errors->add( 'username_exists', __( 'This username is already registered. Please choose another one.', DHVC_FORM ) );
			}

			// Check the email address
			if ( $user_email == '' ) {
				$errors->add( 'empty_email', __( 'Please type your email address.', DHVC_FORM ) );
			} elseif ( ! is_email( $user_email ) ) {
				$errors->add( 'invalid_email', __( 'The email address isn\'t correct.', DHVC_FORM ) );
				$user_email = '';
			} elseif ( email_exists( $user_email ) ) {
				$errors->add( 'email_exists', __( 'This email is already registered, please choose another one.', DHVC_FORM ) );
			}
			//Check the password

			if ( empty( $user_password ) ) {
				$user_password = wp_generate_password( 12, false );
			} else {
				if ( strlen( $user_password ) < 6 ) {
					$errors->add( 'minlength_password', __( 'Password must be 6 character long.', DHVC_FORM ) );
				} elseif ( empty( $cuser_password ) ) {
					$errors->add( 'not_cpassword', __( 'Not see password confirmation field.', DHVC_FORM ) );
				} elseif ( $user_password != $cuser_password ) {
					$errors->add( 'unequal_password', __( 'Passwords do not match.', DHVC_FORM ) );
				}
			}

			$errors = apply_filters( 'registration_errors', $errors, $sanitized_user_login, $user_email );

			if ( $errors->get_error_code() ) {
				return $errors;
			}

			$user_pass = $user_password;
			$user_id   = wp_create_user( $sanitized_user_login, $user_pass, $user_email );

			if ( ! $user_id ) {
				$errors->add( 'registerfail', __( 'Couldn\'t register you... please contact the site administrator', DHVC_FORM ) );

				return $errors;
			}

			update_user_option( $user_id, 'default_password_nag', true, true ); // Set up the Password change nag.

			$user = get_userdata( $user_id );
			//@todo
			wp_new_user_notification( $user_id, $user_pass );

			if ( ! empty( $user_password ) ) {
				$data_login['user_login']    = $user->user_login;
				$data_login['user_password'] = $user_password;
				$user_login                  = wp_signon( $data_login, false );
			}


			return $user_id;
		}

		protected function _forgotten( $data ) {
			$user_login = isset( $data['user_login'] ) ? $data['user_login'] : '';
			if ( dhvc_form_validate_email( $user_login ) ) {
				$username = sanitize_email( $user_login );
			} else {
				$username = sanitize_user( $user_login );
			}

			$user_forgotten = $this->_retrieve_password( $username );

			if ( is_wp_error( $user_forgotten ) ) {
				return array(
					'success' => false,
					'message' => $user_forgotten->get_error_message(),
				);
			} else {
				return array(
					'success' => true,
					'message' => __( 'Password Reset. Please check your email.', DHVC_FORM ),
				);
			}

		}

		protected function _retrieve_password( $user_login ) {
			global $wpdb, $wp_hasher;

			$errors = new WP_Error();

			if ( empty( $user_login ) ) {
				$errors->add( 'empty_username', __( 'Enter a username or e-mail address.' ) );
			} else if ( strpos( $user_login, '@' ) ) {
				$user_data = get_user_by( 'email', trim( $user_login ) );
				if ( empty( $user_data ) ) {
					$errors->add( 'invalid_email', __( 'There is no user registered with that email address.' ) );
				}
			} else {
				$login     = trim( $user_login );
				$user_data = get_user_by( 'login', $login );
			}

			do_action( 'lostpassword_post' );

			if ( $errors->get_error_code() ) {
				return $errors;
			}

			if ( ! $user_data ) {
				$errors->add( 'invalidcombo', __( 'Invalid username or e-mail.' ) );

				return $errors;
			}

			// redefining user_login ensures we return the right case in the email
			$user_login = $user_data->user_login;
			$user_email = $user_data->user_email;


			do_action( 'retreive_password', $user_login );


			$allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

			if ( ! $allow ) {
				return new WP_Error( 'no_password_reset', __( 'Password reset is not allowed for this user' ) );
			} else if ( is_wp_error( $allow ) ) {
				return $allow;
			}

			// Generate something random for a password reset key.
			$key = wp_generate_password( 20, false );

			do_action( 'retrieve_password_key', $user_login, $key );

			// Now insert the key, hashed, into the DB.
			if ( empty( $wp_hasher ) ) {
				require_once ABSPATH . 'wp-includes/class-phpass.php';
				$wp_hasher = new PasswordHash( 8, true );
			}
			$hashed = $wp_hasher->HashPassword( $key );
			$wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

			$message = __( 'Someone requested that the password be reset for the following account:' ) . "\r\n\r\n";
			$message .= network_home_url( '/' ) . "\r\n\r\n";
			$message .= sprintf( __( 'Username: %s' ), $user_login ) . "\r\n\r\n";
			$message .= __( 'If this was a mistake, just ignore this email and nothing will happen.' ) . "\r\n\r\n";
			$message .= __( 'To reset your password, visit the following address:' ) . "\r\n\r\n";
			$message .= '<' . network_site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . ">\r\n";

			if ( is_multisite() ) {
				$blogname = $GLOBALS['current_site']->site_name;
			} else
				// The blogname option is escaped with esc_html on the way into the database in sanitize_option
				// we want to reverse this for the plain text arena of emails.
			{
				$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );
			}

			$title = sprintf( __( '[%s] Password Reset' ), $blogname );

			$title = apply_filters( 'retrieve_password_title', $title );

			$message = apply_filters( 'retrieve_password_message', $message, $key );

			if ( $message && ! wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) ) {
				wp_die( __( 'The e-mail could not be sent.' ) . "<br />\n" . __( 'Possible reason: your host may have disabled the mail() function.' ) );
			}

			return true;
		}

	}

	new DHVCForm();
}