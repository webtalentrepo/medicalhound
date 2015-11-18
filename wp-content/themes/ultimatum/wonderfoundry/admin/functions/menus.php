<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
this file under any circumstances.
*/

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */

if(ultimatum_menu_access_rights()){add_action('admin_menu', 'ultimatum_add_admin_menu');}
add_action('admin_menu', 'ultimatum_hidden_menu');
if(ultimatum_menu_access_rights()) {add_action('admin_menu', 'ultimatum_add_admin_submenus');}
function ultimatum_add_admin_menu() {
	global $menu;
	global $ultimatum_notifier_count;
	global $ultimatum_main_menu;
	
	$notification_count = "<span class='update-plugins count-".$ultimatum_notifier_count."'><span class='plugin-count'>" . number_format_i18n($ultimatum_notifier_count) . '</span></span>';
	$ultimatum_main_menu = add_menu_page(THEME_NAME, THEME_NAME.' '.$notification_count.'', 'manage_options', THEME_SLUG, 'wonderworks_default', ULTIMATUM_ADMIN_URL.'/assets/images/ultimatum-icon.png', '58.998');
}


function ultimatum_add_admin_submenus() {
	global $ultimatum_notifier_count;
	$notification_count = "<span class='update-plugins count-".$ultimatum_notifier_count."'><span class='plugin-count'>" . number_format_i18n($ultimatum_notifier_count) . '</span></span>';
	$user = wp_get_current_user();
	add_submenu_page( 'index.php',__( 'Welcome to Ultimatum',  'ultimatum' ),__( 'Welcome to Ultimatum',  'ultimatum' ),'manage_options','ultimatum-about','about_screen');
	remove_submenu_page( 'index.php', 'ultimatum-about'   );
	add_submenu_page( 'index.php',__( 'Ultimatum Installer',  'ultimatum' ),__( 'Ultimatum Installer',  'ultimatum' ),'manage_options','ultimatum-install','install_ultimatum');
	remove_submenu_page( 'index.php', 'ultimatum-install'   );
	$ultimatum_main_menu = add_submenu_page(THEME_SLUG, __('Settings','ultimatum'), __('Settings','ultimatum'), 'manage_options',THEME_SLUG, 'wonderworks_default');
	$ultimatum_templates_menu = add_submenu_page(THEME_SLUG, __('Templates','ultimatum'), __('Templates','ultimatum'), 'manage_options', 'wonder-templates', 'ultimatum_themes');
	$ultimatum_layouts_menu = add_submenu_page('wonder-templates', __('Layout Settings','ultimatum'), __('Layout Settings','ultimatum'), 'manage_options', 'wonder-layout', 'ultimatum_layouts', THEME_URL.'/wonderfoundry/images/ultimatum-icon.png');
	$ultimatum_css_menu = add_submenu_page('wonder-templates', __('CSS Editor','ultimatum'), __('CSS Editor','ultimatum'), 'manage_options', 'wonder-css', 'cssDefaults', THEME_URL.'/wonderfoundry/images/ultimatum-icon.png');
	$ultimatum_posttype_menu = add_submenu_page(THEME_SLUG, __('Custom Post Types','ultimatum'), __('Custom Post Types','ultimatum'), 'manage_options', 'wonder-types', 'PostTypes');
	$ultimatum_library_menu = add_submenu_page(THEME_SLUG, __('Library','ultimatum'), __('Library','ultimatum'), 'manage_options', 'wonder-library', 'wonderLibrary');
	$ultimatum_notes_menu = add_submenu_page(THEME_SLUG, __('System Report','ultimatum'), __('System Report','ultimatum').' '.$notification_count.'', 'manage_options', 'wonder-notes', 'wonderNotes');
	$ultimatum_fonts_menu = add_submenu_page('wonder-library', __('Fonts Library','ultimatum'), __('Fonts Library','ultimatum'), 'manage_options', 'wonder-fonts', 'fonts', THEME_URL.'/wonderfoundry/images/ultimatum-icon.png');
    do_action('ultimatum_admin_menus');
}

// Adds hidden menu items so that we can call iframes
function ultimatum_hidden_menu()
{
	add_submenu_page(null,'Layout Assigner','Layout Assigner','manage_options','layout-assigner','ultimatum_layout_assigner');
	add_submenu_page(null,'Layout Creator','Layout Creator','manage_options','layout-create','ultimatum_layout_creator');
	add_submenu_page(null,'ShortCode Generator','ShortCode Generator','edit_posts','shortcode-create','ultimatum_shortcode_creator');
	add_submenu_page(null,'Row Style Selector','Row Style Selector','manage_options','ultimatum-row-layouts','ultimatum_row_selector_screen');
    add_submenu_page(null,'Layout Options','Layout Options','manage_options','ultimatum-layout-options','ultimatum_layout_options_screen');
    add_submenu_page(null,'Custom CSS','Custom CSS','manage_options','ultimatum-custom-css','ultimatum_custom_css_screen');
	add_submenu_page(null,'CSS Regenerator','CSS Regenerator','manage_options','ultimatum-css-regen','ultimatum_css_regen');
	add_submenu_page(null,'CSS Generator','CSS Generator','manage_options','ultimatum-css-gen','ultimatum_css_gen');
	add_submenu_page(null,'Mobile App Assigner','Mobile App Assigner','manage_options','ultimatum-mobile-assign','ultimatum_mobile_assign');
	add_submenu_page(null,'Exporter','Exporter','manage_options','ultimatum-export','ultimatum_export');
	
}

$ultimatum_admin_pages	=	array(
		THEME_SLUG => array('interface' => 'wonder-defaults'),
		'wonder-css' => array('interface' => 'wonder-css'),
		'wonder-notes' => array('interface' => 'wonder-notes'),
		'wonder-fonts' => array('interface' => 'wonder-fonts'),
		'wonder-library' => array('interface' => 'wonder-library'),
		'wonder-access' => array('interface' => 'wonder-access'),
		'wonder-layout' => array('interface' => 'wonder-layout'),
		'wonder-slideshows' => array('interface' => 'wonder-slideshows'),
		'wonder-forms' => array('interface' => 'wonder-forms'),
		'layout-assigner' => array('interface' => 'wonder-framed','file' => 'assigner.php'),
		'layout-create' => array('interface' => 'wonder-framed','file' => 'create.php'),
		'shortcode-create' => array('interface' => 'wonder-framed','file' => 'shortcodes.php'),
		'ultimatum-row-layouts' => array('interface' => 'wonder-framed','file' => 'row-layouts.php'),
        'ultimatum-layout-options' => array('interface' => 'wonder-framed','file' => 'layout-options.php'),
        'ultimatum-custom-css' => array('interface' => 'wonder-framed','file' => 'custom-css.php'),
		'ultimatum-css-regen' => array('interface' => 'wonder-framed','file' => 'css-regenerator.php'),
		'ultimatum-css-gen' => array('interface' => 'wonder-framed','file' => 'css-generator.php'),
		'ultimatum-mobile-assign' => array('interface' => 'wonder-framed','file' => 'mobile-assigner.php'),
		'ultimatum-export' => array('interface' => 'wonder-framed','file' => 'ultimatum-export.php'),
		'wonder-types' => array('interface' => 'wonder-types'),
		'wonder-seo' => array('interface' => 'wonder-seo'),
		'wonder-templates' => array('interface' => 'wonder-templates'),
		'wonder-update' => array('interface' => 'wonder-update'),
		'ultimatum-about' => array('interface' => 'wonder-core'),
		'ultimatum-install' => array('interface' => 'wonder-core'),
		'ultimatum_toolset' => array('interface' => 'wonder-tools'),
		'ultimatum_toolset_setup' => array('interface' => 'wonder-tools','file'=>'setup.php'),
		'ultimatum_toolset_plugins' => array('interface' => 'wonder-tools','file'=>'plugins.php'),
		'ultimatum_toolset_updates' => array('interface' => 'wonder-tools','file'=>'updates.php'),
		'ultimatum_toolset_settings' => array('interface' => 'wonder-tools'),
		'ultimatum_toolset_themes' => array('interface' => 'wonder-tools','file'=>"themes.php"),
		'ultimatum_toolset_children' => array('interface' => 'wonder-tools'),
		'ultimatum_toolset_awake' => array('interface' => 'wonder-tools'),
		);
if(isset($_GET['page']) && array_key_exists($_GET['page'], $ultimatum_admin_pages)){
	add_action('admin_enqueue_scripts','ultimatum_scripts_base');
	add_action('admin_enqueue_scripts','ultimatum_styles_base');
	function ultimatum_styles_base(){
		global $wp_version;
		if ( version_compare( $wp_version, '3.7.9', '>=' ) ) {
			wp_enqueue_style( 'backend style',ULTIMATUM_ADMIN_ASSETS.'/css/admin-style-38.css' );
		} else {
			wp_enqueue_style( 'backend style',ULTIMATUM_ADMIN_ASSETS.'/css/admin-style.css' );
		}
		wp_enqueue_style( 'bootsrap-admin-style',ULTIMATUM_ADMIN_ASSETS.'/css/admin.styles.css' );
        wp_enqueue_style('font-awesome');
		wp_enqueue_style('thickbox');
	}
	function ultimatum_scripts_base(){
		global $wp_version;
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'ultimatum-bootstrap',ULTIMATUM_ADMIN_ASSETS.'/js/admin.bootstrap.min.js' );
		wp_enqueue_script('ultimatum-admin-js',ULTIMATUM_ADMIN_ASSETS.'/js/ultimatum.admin.js',array(),'2.8.0',true);
	}
	$pagefile = (isset($ultimatum_admin_pages[$_GET['page']]['file']) ? $ultimatum_admin_pages[$_GET['page']]['file'] : 'index.php');
	$page = include(ULTIMATUM_ADMIN.'/interfaces/'.$ultimatum_admin_pages[$_GET['page']]['interface'] . '/'.$pagefile);
}







