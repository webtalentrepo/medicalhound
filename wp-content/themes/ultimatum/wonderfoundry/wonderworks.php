<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */
require_once ('helpers/wonderworkshelper.php');
do_action('ultimatum_pre_load_fw');
class WonderWorks {
	/**
	 * Starts the Framework
	 * @param array $theme
	 */
	function init($theme) {

		// Define the constants eg. directories and urls
		$this->DefineConstants($theme);
		// After having contants in place add a hook
		do_action('ultimatum_before_init');
		// Load the Database
		$this->LoadDatabase();
		// Add language support.
		add_action('init',array(&$this, 'language'));
		// Add theme support.
		add_action('after_setup_theme', array(&$this, 'supports'));
		global $layout;
		$layout=false;
		// Load Functions
		$this->commonFunctions();
		$this->frontFunctions();
		if (is_admin()) {
			$this->adminFunctions();
		}
		// Load Plugins
		
		WonderWorksHelper::requireFromFolder(ULTIMATUM_PLUGINS,"plugins");
		// Load Widgets
		global $pagenow;
		if($pagenow != "widgets.php" ) {
		WonderWorksHelper::requireFromFolder(ULTIMATUM_WIDGETS,"widgets");
		}
		// Do Admin thingies :) 
		
	}

	function commonFunctions(){
		require_once (ULTIMATUM_FUNCTIONS.DS.'common'.DS.'functions.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'common'.DS.'queries.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'common'.DS.'image.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'common'.DS.'layout-helper.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'common'.DS.'types.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'common'.DS.'wpml.php');
        require_once (ULTIMATUM_FUNCTIONS.DS.'loop.php');
        require_once (ULTIMATUM_FUNCTIONS.DS.'common/initialize.php');
	}

	function frontFunctions(){
		if(is_admin())
			return;
		require_once (ULTIMATUM_FUNCTIONS.DS."print-head.php");
		require_once (ULTIMATUM_FUNCTIONS.DS."filters.php");
		require_once (ULTIMATUM_FUNCTIONS.DS.'layout-finder.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'loop.php');
		require_once (ULTIMATUM_FUNCTIONS.DS.'layout-parser.php');

		if(is_dir(ULTIMATUM_FUNCTIONS.DS.'pro')){
			WonderWorksHelper::requireFromFolder(ULTIMATUM_FUNCTIONS.DS.'pro');
		}
	}
	function adminFunctions(){
		if(is_dir(ULTIMATUM_ADMIN_FUNCTIONS.DS.'pro')){
			WonderWorksHelper::requireFromFolder(ULTIMATUM_ADMIN_FUNCTIONS.DS.'pro');
		}
		require_once (ULTIMATUM_ADMIN_FUNCTIONS . '/init.php');
		require_once (ULTIMATUM_ADMIN_FUNCTIONS . '/ajax_callbacks.php');
		require_once (ULTIMATUM_ADMIN_FUNCTIONS . '/toolset.php');
		require_once (ULTIMATUM_ADMIN_FUNCTIONS . '/menus.php');

		
	}
	
	function supports() {
		if (function_exists('add_theme_support')) {
			add_theme_support( 'menus' );
			add_theme_support( 'post-thumbnails' );
			add_theme_support('editor-style');
			add_theme_support( 'woocommerce' );
			register_nav_menus(array(
				'primary-menu' => __(THEME_NAME . ' Default Menu', 'ultimatum' ),
				'secondary-menu' => __(THEME_NAME . ' Secondary Menu', 'ultimatum' ),
			));
		  }
	}

	/**
	 * Make theme available for translation
	 */
	function language(){
		$locale = get_locale();
		//echo $locale;
		load_theme_textdomain( 'ultimatum', THEME_DIR . '/languages' );
		$locale_file = THEME_DIR . "/languages/$locale.php";
		if ( is_readable( $locale_file ) ){
			require_once( $locale_file );
		}
	}
	
	
	
	/**
	 * Defines the Constants
	 * @param array $theme
	 */
	function DefineConstants($theme){
		global $wpdb;
       // print_r($thm);
		$upload_dir = wp_upload_dir();
		define('ULTIMATUM_VERSION',"2.8.5");
		defined('ULTIMATUM_PREFIX') ? null : define('ULTIMATUM_PREFIX','ult25');
		// Define Core Folder and Child seperation 
		defined('DS') ? null : define('DS', '/');//DIRECTORY_SEPARATOR
		define('ULTIMATUM_DIR',get_template_directory());
		define('ULTIMATUM_LANGUAGES',ULTIMATUM_DIR.'/langauges/');
		define('ULTIMATUM_URL',get_template_directory_uri());
		define('THEME_DIR', get_stylesheet_directory());
		define('THEME_URL', get_stylesheet_directory_uri());
		define('THEME_LANG_DOMAIN','ultimatum');
		define('THEME_ADMIN_LANG_DOMAIN','ultimatum');
		ULTIMATUM_DIR != THEME_DIR ? define('CHILD_THEME',true) : define('CHILD_THEME',false);

		CHILD_THEME ? define('THEME_NAME',$theme['theme_name']) : define('THEME_NAME','Ultimatum');
		CHILD_THEME ? define('THEME_SLUG',$theme['theme_slug']) : define('THEME_SLUG','ultimatum');
		
		// Define the Cache Folder and URL
		$uploaddir = $upload_dir["basedir"];
		$uploadurl = $upload_dir["baseurl"];
		define('THEME_CACHE_DIR', $uploaddir.DS.THEME_SLUG);
		define('ULTLOOPBUILDER_DIR', $uploaddir.DS.'wonderloops');
		if(!is_dir(THEME_CACHE_DIR)) mkdir(THEME_CACHE_DIR);
		define('THEME_CACHE_URL', $uploadurl.'/'.THEME_SLUG);
		define('THEME_LOOPS_DIR', get_stylesheet_directory().DS.'loops');
		
		/*
		 * Define Ultimatum Versioning
		 */
		
		/*
		 * Define the CORE Directory and URL Structure
		 */
		define('ULTIMATUM_FW',ULTIMATUM_DIR.DS.'wonderfoundry');
		define('ULTIMATUM_FUNCTIONS',ULTIMATUM_FW.DS.'functions');
		define('ULTIMATUM_API','https://api.ultimatumtheme.com/toolset/');
			
		// Admin Related
		define('ULTIMATUM_ADMIN',ULTIMATUM_FW.DS.'admin');
		define('ULTIMATUM_ADMIN_URL',ULTIMATUM_URL.'/wonderfoundry/admin');
		define('ULTIMATUM_WIDGETS',ULTIMATUM_FW.DS.'widgets');
		define('ULTIMATUM_ADMIN_AJAX',ULTIMATUM_ADMIN.DS.'ajax');
		define('ULTIMATUM_ADMIN_FUNCTIONS',ULTIMATUM_ADMIN.DS.'functions');
		define('ULTIMATUM_ADMIN_HELP',ULTIMATUM_ADMIN.DS.'help');
		define('ULTIMATUM_ADMIN_INTERFACES',ULTIMATUM_ADMIN.DS.'interfaces');
		define('ULTIMATUM_ADMIN_HELPERS',ULTIMATUM_ADMIN.DS.'helpers');
		define('ULTIMATUM_ADMIN_OPTIONS', ULTIMATUM_ADMIN_HELPERS.DS.'options');
		define('ULTIMATUM_ADMIN_METABOXES', ULTIMATUM_ADMIN_HELPERS.DS.'metaboxes');
		define('ULTIMATUM_ADMIN_ASSETS', ULTIMATUM_URL.'/wonderfoundry/admin/assets');
		// Add-On Related
		define('ULTIMATUM_ADDONS',ULTIMATUM_FW.DS.'addons');
		define('ULTIMATUM_PLUGINS',ULTIMATUM_ADDONS.DS.'plugins');
		define('ULTIMATUM_PLUGINS_URL',ULTIMATUM_URL.'/wonderfoundry/addons/plugins');
		define('ULTIMATUM_MCE',ULTIMATUM_PLUGINS.DS.'tinymce');
		define('ULTIMATUM_MCE_URL',ULTIMATUM_URL.'/wonderfoundry/addons/plugins/tinymce');
		define('UTIMATUM_SHORTCODES',ULTIMATUM_ADDONS.DS.'shortcodes');
		
		
		// Ultimatum Library Plugin Define
		define('ULTIMATUM_LIBRARY_DIR', WP_PLUGIN_DIR.DS.'ultimatum-library');
		define('ULTIMATUM_LIBRARY_URI', WP_PLUGIN_URL.DS.'ultimatum-library');
		define('THEME_CUFON_DIR', ULTIMATUM_LIBRARY_DIR. '/fonts/cufon');
		define('THEME_CUFON_URI', ULTIMATUM_LIBRARY_URI . '/fonts/cufon');
		define('THEME_IMGLIB_URI', ULTIMATUM_LIBRARY_URI . '/images');
		define('THEME_IMGLIB_DIR', ULTIMATUM_LIBRARY_DIR . '/images');
		define('THEME_FONTFACE_DIR', ULTIMATUM_LIBRARY_DIR . '/fonts/fontface');
		define('THEME_FONTFACE_URI', ULTIMATUM_LIBRARY_URI . '/fonts/fontface');
		/*
		 * Tables in Database
		 */
		
		define('ULTIMATUM_TABLE_CLASSES',$wpdb->prefix.ULTIMATUM_PREFIX.'_classes');
		define('ULTIMATUM_TABLE_CSS',$wpdb->prefix.ULTIMATUM_PREFIX.'_css');
		define('ULTIMATUM_TABLE_FORMS',$wpdb->prefix.ULTIMATUM_PREFIX.'_forms');
		define('ULTIMATUM_TABLE_LAYOUT',$wpdb->prefix.ULTIMATUM_PREFIX.'_layout');
		define('ULTIMATUM_TABLE_LAYOUT_ASSIGN',$wpdb->prefix.ULTIMATUM_PREFIX.'_layout_assign');
		define('ULTIMATUM_TABLE_MOBILE',$wpdb->prefix.ULTIMATUM_PREFIX.'_mobile');
		define('ULTIMATUM_TABLE_PTYPES',$wpdb->prefix.ULTIMATUM_PREFIX.'_ptypes');
		define('ULTIMATUM_TABLE_ROWS',$wpdb->prefix.ULTIMATUM_PREFIX.'_rows');
		define('ULTIMATUM_TABLE_SC',$wpdb->prefix.ULTIMATUM_PREFIX.'_sc');
		define('ULTIMATUM_TABLE_SLIDES',$wpdb->prefix.ULTIMATUM_PREFIX.'_slides');
		define('ULTIMATUM_TABLE_TAX',$wpdb->prefix.ULTIMATUM_PREFIX.'_tax');
		define('ULTIMATUM_TABLE_TEMPLATES',$wpdb->prefix.ULTIMATUM_PREFIX.'_templates');
		
		$ultimatumversion = get_option('ultimatum_version');
		
	}
	function LoadDatabase(){
		global $wpdb;
		$prefix = $wpdb->prefix;
		$table_name_check = $prefix.ULTIMATUM_PREFIX."_classes";
		$ultimatumversion = get_option('ultimatum_version');
		if($ultimatumversion<2.5 && $ultimatumversion >= 2.37038){
			require_once (ULTIMATUM_ADMIN_FUNCTIONS.'/23upgrader.php');
		}
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name_check'") != $table_name_check) {
			$this->ultimatum_db_install();
			$ultextras = unserialize('a:11:{s:15:"ultimatum_forms";b:0;s:20:"ultimatum_slideshows";b:0;s:20:"ultimatum_shortcodes";b:0;s:24:"ultimatum_visualcomposer";b:0;s:21:"ultimatum_layerslider";b:0;s:20:"ultimatum_revolution";b:0;s:17:"ultimatum_showbiz";b:0;s:18:"ultimatum_postgals";b:0;s:13:"ultimatum_pto";b:0;s:16:"element_position";b:0;s:11:"woocommerce";b:0;}');
			add_option('ultimatum_extras',$ultextras,false);
			$ult_general_options = unserialize('a:5:{s:9:"text_logo";b:1;s:4:"logo";s:0:"";s:17:"display_site_desc";b:1;s:7:"favicon";s:0:"";s:7:"noimage";s:0:"";}');
			add_option('ultimatum_general',$ult_general_options,false);
			add_option('ult_installed','DONE',false);
			add_option('ultimatum_version',2.5105,false);
			
		}
		
		if($ultimatumversion<2.5101){
			$prefix = $wpdb->prefix;
			$table_modify_sql = array(
				"ALTER TABLE `".$prefix.ULTIMATUM_PREFIX."_mobile` CHANGE `theme` `theme` VARCHAR(255) NOT NULL;",
				"ALTER TABLE `".$prefix.ULTIMATUM_PREFIX."_mobile` ADD `mpush` INT(1) NOT NULL DEFAULT '0';",
				"ALTER TABLE `".$prefix.ULTIMATUM_PREFIX."_extra_rows` CHANGE `grid` `grid` VARCHAR(55);"
					);
			foreach ($table_modify_sql as $table){
				$wpdb->query($table);
			}
			update_option('ultimatum_version',2.5101);
		}
		if($ultimatumversion<2.5106){
			update_option('ultimatum_version',2.5106);
			
		}
		if($ultimatumversion<2.5201){
			$table_name_check = $prefix."ultimatum_forms";
			if($wpdb->get_var("SHOW TABLES LIKE '$table_name_check'") != $table_name_check) {
				// This is a core 2.5 so we need to update the row style 29
				$table_name_check = $prefix.ULTIMATUM_PREFIX."_classes";
				$tab = $prefix.ULTIMATUM_PREFIX."_rows";
				$query = "UPDATE `".$tab."` SET `type_id`=37 WHERE `type_id`=29";
				$wpdb->query($query);
			} else {
				// fix for extra rows in rows in 2.3 updates
				$query = "ALTER TABLE `".$prefix.ULTIMATUM_PREFIX."_rows` CHANGE `type_id` `type_id` varchar(55) NOT NULL;";
				$wpdb->query($query);
			}
			update_option('ultimatum_version',2.5201);
			if(is_admin()){
				header( 'Location: '.admin_url().'index.php?page=ultimatum-about' ) ;
			}
		}
        if($ultimatumversion<2.8){
            $query = "ALTER TABLE `".$prefix.ULTIMATUM_PREFIX."_templates` ADD `cdn` VARCHAR(55) NULL DEFAULT NULL;";
            $wpdb->query($query);
            update_option('ultimatum_version',2.8);
        }
	}
	/**
	 * 
	 */
	function ultimatum_db_install(){
		global $wpdb;
		$prefix = $wpdb->prefix;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_create_sql = array(
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_classes` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`container` varchar(55) NOT NULL,
					`user_class` varchar(255) NOT NULL,
					`hidephone` varchar(20) NOT NULL,
					`hidetablet` varchar(20) NOT NULL,
					`hidedesktop` varchar(20) NOT NULL,
					`layout_id` int(11) NOT NULL,
					PRIMARY KEY (`id`),
					UNIQUE KEY `container` (`container`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_css` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`container` varchar(255) NOT NULL,
					`layout_id` int(11) NOT NULL,
					`element` varchar(255) NOT NULL,
					`properties` text NOT NULL,
					PRIMARY KEY (`id`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_extra_rows` (
					`template_id` int(11) NOT NULL,
					`name` varchar(255) NOT NULL,
					`slug` varchar(55) NOT NULL,
					`grid` varchar(55) NOT NULL,
					`amount` int(11) NOT NULL,
					UNIQUE KEY `template-row` (`template_id`,`slug`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_layout` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`title` varchar(255) NOT NULL,
					`theme` int(11) NOT NULL DEFAULT '1',
					`type` varchar(11) NOT NULL DEFAULT '0',
					`before` text,
					`after` text,
					`default` int(1) NOT NULL DEFAULT '0',
					`rows` text,
					PRIMARY KEY (`id`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_layout_assign` (
					`template` varchar(50) NOT NULL,
					`post_type` varchar(55) NOT NULL,
					`layout_id` int(11) NOT NULL,
					UNIQUE KEY `ultindex` (`template`,`post_type`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_mobile` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`device` varchar(255) NOT NULL,
					`theme` varchar(255) NOT NULL,
					`mpush` int(1) NOT NULL DEFAULT '0',
					PRIMARY KEY (`id`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_ptypes` (
					`name` varchar(55) NOT NULL,
					`properties` text NOT NULL,
					UNIQUE KEY `name` (`name`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_rows` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`layout_id` varchar(255) NOT NULL,
					`type_id` varchar(55) NOT NULL,
					PRIMARY KEY (`id`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_sc` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`type` varchar(255) NOT NULL,
					`name` varchar(255) NOT NULL,
					`properties` text NOT NULL,
					PRIMARY KEY (`id`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_tax` (
					`tname` varchar(55) NOT NULL,
					`pname` varchar(255) NOT NULL,
					`properties` text NOT NULL,
					UNIQUE KEY `tname` (`tname`)
					) _collate_;",
				"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_templates` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`name` varchar(255) NOT NULL,
					`width` int(11) NOT NULL,
					`margin` int(11) NOT NULL,
					`mwidth` int(11) NOT NULL,
					`mmargin` int(11) NOT NULL,
					`swidth` int(11) NOT NULL,
					`smargin` int(11) NOT NULL,
					`gridwork` varchar(255) NOT NULL DEFAULT 'ultimatum',
					`swatch` varchar(255) NOT NULL DEFAULT 'default',
					`type` int(11) NOT NULL,
					`dcss` varchar(3) NOT NULL DEFAULT 'no',
					`default` int(11) NOT NULL,
					`theme` varchar(255) NOT NULL,
					PRIMARY KEY (`id`)
					) _collate_;"
		);
		$collate = '';
		if ( $wpdb->has_cap( 'collation' ) ) {
			if( ! empty($wpdb->charset ) )
				$collate .= "DEFAULT CHARACTER SET $wpdb->charset";
			if( ! empty($wpdb->collate ) )
				$collate .= " COLLATE $wpdb->collate";
		}
			
		foreach ($table_create_sql as $table){
			$table = str_replace('_collate_', $collate, $table);
			dbDelta( $table );
		}
	}
	
}
if(isset($theme) && is_array($theme)){
    // I am glad you have done it right
} else {
    $theme = array();
    // Well i am really tired off of this and now i am going to smash it to ground
    $my_theme = wp_get_theme();
    $theme['theme_name'] = $my_theme->get( 'Name' ) ;
    $theme['theme_slug'] = sanitize_title($theme['theme_name']);
    //echo $thm['theme_name'];
}

$wonder = new WonderWorks();

$wonder->init($theme);
if(!is_admin()){
	
}
function ultimatum(){
	do_action('ultimatum_pre_layout');
	get_header(); // prints the content between <head></head> part
	do_action('ultimatum_print_body'); // prints the content between <body></body> part
	get_footer(); // prints the closure 
	
	
}