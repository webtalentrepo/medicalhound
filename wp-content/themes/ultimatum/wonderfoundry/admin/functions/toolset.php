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

//$autoupdate_url = wp_nonce_url( $this->self_admin_url('update.php?action=upgrade-plugin&plugin=') . $filename, 'upgrade-plugin_' . $filename);

$user = wp_get_current_user();
$ultimatum_toolset = get_site_option('ultimatum_toolset');
if(is_array($ultimatum_toolset)){
    if(!isset($ultimatum_toolset['blocked'])){
        $ultimatum_toolset['blocked'] = 'unblocked';
    }
    if(!isset($ultimatum_toolset['disable_updates'])){
        $ultimatum_toolset['disable_updates'] = false;
    }
	// Toolset is initialized and we have a default user ;)
	if($ultimatum_toolset['blocked']!='blocked'){
		if($ultimatum_toolset['allowed_user'] == get_current_user_id()){
			if(is_multisite()){
				add_action('network_admin_menu', 'ultimatum_toolset_menu');
				add_action('network_admin_menu', 'ultimatum_toolset_submenus');
			} else {
				add_action('admin_menu', 'ultimatum_toolset_menu');
				add_action('admin_menu', 'ultimatum_toolset_submenus');
			}
		}
		add_action( 'admin_init', 'ultimatum_schedule_refresh_local_projects' );
		add_action( 'update-core.php', 'ultimatum_refresh_local_projects' );
		add_action( 'load-plugins.php', 'ultimatum_refresh_local_projects' );
		add_action( 'load-update.php', 'ultimatum_refresh_local_projects' );
		add_action( 'load-update-core.php', 'ultimatum_refresh_local_projects' );
		add_action( 'load-themes.php', 'ultimatum_refresh_local_projects' );
		add_action( 'wp_update_plugins', 'ultimatum_refresh_local_projects' );
		add_action( 'wp_update_themes', 'ultimatum_refresh_local_projects' );
		if(!$ultimatum_toolset['disable_updates']){
			add_action( 'site_transient_update_plugins', 'ultimatum_filter_plugin_count' );
			add_action( 'site_transient_update_themes', 'ultimatum_filter_theme_count' );
		} 
		// make sure before WPMUDEV to aviod conflict.. RESPECT! 
		add_filter( 'plugins_api', 'ultimatum_filter_plugin_info', 19, 3 );
		add_filter( 'themes_api', 'ultimatum_filter_plugin_info', 19, 3 ); 
		
	} else { // if user blocked toolset
		if(is_multisite()){
			add_action('network_admin_menu', 'ultimatum_toolset_hidden_menu');
		} else {
			add_action('admin_menu', 'ultimatum_toolset_hidden_menu');
		}
		
	}
} else {
	
	if(is_multisite()){
		add_action('network_admin_menu', 'ultimatum_toolset_setup_menu');
	} else {
		add_action('admin_menu', 'ultimatum_toolset_setup_menu');
	}
	
}

/*
 * Toolset Functions
 */
function ultimatum_allowed_user() {
	$user = wp_get_current_user();
	$ultimatum_toolset = get_site_option('ultimatum_toolset');
	if($ultimatum_toolset['allowed_user'] == get_current_user_id()){
		return true;
	} else {
		return false;
	}
}

function ultimatum_schedule_refresh_local_projects() {

	if ( defined('WP_INSTALLING') )
		return false;

	if ( current_user_can('update_plugins') ) {
		ultimatum_get_local_projects(); //trigger refresh when necessary
	}
}
function ultimatum_toolset_setup_menu() {
	global $menu;
	//global $ultimatum_notifier_count;
	//$notification_count = "<span class='update-plugins count-".$ultimatum_notifier_count."'><span class='plugin-count'>" . number_format_i18n($ultimatum_notifier_count) . '</span></span>';
	$page = add_menu_page('Ultimatum Tool Set', 'Ult. ToolSet', 'manage_options', 'ultimatum_toolset_setup', 'ultimatum_toolset_setup', ULTIMATUM_ADMIN_URL.'/assets/images/ultimatum-icon.png', '2.998');
}

function ultimatum_toolset_menu() {
	global $menu;
	global $ultimatum_notifier_count;
	$updates = get_site_option('ultimatum_updates_available');
	$count = ( is_array($updates) ) ? count( $updates ) : 0;
	$ultimatum_notifier_counter = $ultimatum_notifier_count+$count;
	$notification_counter = "<span class='update-plugins count-".$ultimatum_notifier_counter."'><span class='plugin-count'>" . number_format_i18n($ultimatum_notifier_counter) . '</span></span>';
	$page = add_menu_page('Ultimatum Tool Set', 'Ult. ToolSet'.' '.$notification_counter.'', 'manage_options', 'ultimatum_toolset', 'ultimatum_toolset', ULTIMATUM_ADMIN_URL.'/assets/images/ultimatum-icon.png', '2.998');
}


function ultimatum_toolset_submenus() {
	global $ultimatum_notifier_count;
	global $ultimatum_updates_url;
	$notification_count = "<span class='update-plugins count-".$ultimatum_notifier_count."'><span class='plugin-count'>" . number_format_i18n($ultimatum_notifier_count) . '</span></span>';
	$updates = get_site_option('ultimatum_updates_available');
	$count = ( is_array($updates) ) ? count( $updates ) : 0;
	$notification_count2 = "<span class='update-plugins count-".$count."'><span class='plugin-count'>" . number_format_i18n($count) . '</span></span>';
	$ultimatum_main_menu = add_submenu_page('ultimatum_toolset', __('Dashboard','ultimatum'), __('Dashboard','ultimatum'), 'manage_options','ultimatum_toolset', 'ultimatum_toolset');
	$ultimatum_templates_menu = add_submenu_page('ultimatum_toolset', __('Plugins','ultimatum'), __('Plugins','ultimatum'), 'manage_options', 'ultimatum_toolset_plugins', 'ultimatum_toolset_plugins');
	$ultimatum_layouts_menu = add_submenu_page('ultimatum_toolset', __('Themes','ultimatum'), __('Themes','ultimatum'), 'manage_options', 'ultimatum_toolset_themes', 'ultimatum_toolset_themes');
	$ultimatum_updates_url = add_submenu_page('ultimatum_toolset', __('Updates','ultimatum'), __('Updates','ultimatum').' '.$notification_count2.'', 'manage_options', 'ultimatum_toolset_updates', 'ultimatum_toolset_updates');
	$ultimatum_notes_menu = add_submenu_page('ultimatum_toolset', __('System Report','ultimatum'), __('System Report','ultimatum').' '.$notification_count.'', 'manage_options', 'wonder-notes', 'wonderNotes');
}

function ultimatum_toolset_hidden_menu(){
	add_submenu_page(null,'Ultimstum Toolset','Ultimatum Toolset','manage_options','ultimatum_toolset_awake','ultimatum_toolset_awake');
}

function ultimatum_api_returned_check($api){
	global $wp_version;
	$url = ULTIMATUM_API;
	$options = array(
			'body' => array(
					'task'=>'return_api',
					'wp_version' => $wp_version,
					'php_version' => phpversion(),
					'site' => network_home_url(),
					'user-agent' => "WordPress/$wp_version;",
					'apikey' => $api
			)
	);
	$response = wp_remote_post($url, $options);
	$ultimatum_update = (wp_remote_retrieve_body($response));
	if($ultimatum_update == 'gectin'){
		$toolset_settings = array();
		$user_ID = get_current_user_id();
		$ultimatum_toolset['allowed_user'] = $user_ID;
		$ultimatum_toolset['apikey'] = $api;
		update_site_option('ultimatum_toolset',$ultimatum_toolset,false);
		$location = trailingslashit(network_admin_url()).'admin.php?page=ultimatum_toolset';
		wp_safe_redirect(esc_url_raw($location));
		exit;
	} else {
		$msg = __('The API server re-check returned failure please try again later','ultimatum');//cheating actually
		echo $msg;
	}
}

function ultimatum_get_api(){
	$ultimatum_toolset = get_site_option('ultimatum_toolset');
	$api = $ultimatum_toolset['apikey'];
	return $api;
}

function ultimatum_filter_plugin_info($res, $action, $args) {
	global $wp_version;
	$cur_wp_version = preg_replace('/-.*$/', '', $wp_version);
	$ultimatum_toolset = get_site_option('ultimatum_toolset');
	if ( ($action == 'plugin_information' || $action == 'theme_information') && strpos($args->slug, 'ultimatum_install') !== false ) {
		$string = explode('-', $args->slug);
		$id = intval($string[1]);
		$api_key = $ultimatum_toolset['apikey'];
		$data = ultimatum_get_updates();

		//if in details iframe on update core page short-curcuit it
		if ( did_action( 'install_plugins_pre_plugin-information' ) && is_array( $data ) && isset($data['projects'][$id]) ) {
			//echo $data['projects'][$id]['changelog'];
			echo '<iframe width="100%" height="100%" border="0" style="border:none;" src="' . ULTIMATUM_API . '?action=details&id=' . $id . '"></iframe>';
			exit;
		}

		if ( $api_key && is_array( $data ) && isset($data['toolset'][$id])) {
			$res = new stdClass;
			$res->name = $data['toolset'][$id]['name'];
			$res->slug = sanitize_title($data['toolset'][$id]['name']);
			$res->version = $data['toolset'][$id]['version'];
			$res->rating = 100;
			$res->homepage = $data['toolset'][$id]['url'];
			$res->download_link = ULTIMATUM_API . "?task=plugin&key=$api_key&pid=$id";
			$res->tested = $cur_wp_version;

			return $res;
		}
	}

	return $res;
}

function ultimatum_refresh_local_projects($cache_reset = false) {

	$local_projects = ultimatum_get_projects();
	if ( !$cache_reset ) {
		$saved_local_projects = ultimatum_get_local_projects();

		//check for changes
		$saved_local_projects_md5 = md5(serialize($saved_local_projects));
		$local_projects_md5 = md5(serialize($local_projects));
		if ( $saved_local_projects_md5 != $local_projects_md5 ) {
			//refresh data as installed plugins have changed
			$data = ultimatum_refresh_updates($local_projects);
		}

		//recalculate upgrades with current/updated data
		ultimatum_calculate_upgrades($local_projects);
	}

	//save to be able to check for changes later
	set_site_transient('ultimatum_local_projects', $local_projects, 60*5);

	return $local_projects;
}
function ultimatum_refresh_updates($local_projects = false) {
	global $wpdb, $current_site, $wp_version;

	if ( defined( 'WP_INSTALLING' ) )
		return false;

	//reset flag if it's set
	update_site_option('ultimatum_refresh_updates_flag', 0);

	if ( !is_array($local_projects) )
		$local_projects = ultimatum_get_projects();

	set_site_transient('ultimatum_local_projects', $local_projects, 60*5);

	$ultimatum_toolset = get_site_option('ultimatum_toolset');
	$api_key = $ultimatum_toolset['apikey'];

	$url = ULTIMATUM_API;
		$options = array(
				'body' => array(
						'task'=>'check_updates',
						'wp_version' => $wp_version,
						'php_version' => phpversion(),
						'site' => network_home_url(),
						'user-agent' => "WordPress/$wp_version;",
						'apikey' => $ultimatum_toolset['apikey']
				)
		);
	$response = wp_remote_post($url, $options);
	if ( wp_remote_retrieve_response_code($response) == 200 ) {
		$data = $response['body'];
		if ( $data != 'error' ) {
			$data = unserialize($data);
			if ( is_array($data) ) {
				set_site_transient('ultimatum_updates_data', $data, 60*60*12);
				update_site_option('utoolset_last_run', time());
				ultimatum_calculate_upgrades($local_projects);
				return $data;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		//for network errors, set last run to 6 hours in past so it doesn't retry every single pageload (in case of server connection issues)
		set_site_transient('ultimatum_updates_data', array(), 60*60*6);
		return false;
	}
}

function ultimatum_calculate_upgrades($local_projects) {
	$data = ultimatum_get_updates();
	$remote_projects = isset($data['toolset']) ? $data['toolset'] : array();
	$updates = array();

	//check for updates
	if ( is_array($remote_projects) ) {
		foreach ( $remote_projects as $id => $remote_project ) {
			if ( isset($local_projects[$id]) && is_array($local_projects[$id]) ) {
				//match
				$local_version = $local_projects[$id]['version'];
				$remote_version = $remote_project['version'];

				if ( version_compare($remote_version, $local_version, '>') ) {
					//add to array
					$updates[$id] = $local_projects[$id];
					$updates[$id]['url'] = $remote_project['url'];
					$updates[$id]['instructions_url'] = $remote_project['instructions_url'];
					$updates[$id]['support_url'] = $remote_project['support_url'];
					$updates[$id]['name'] = $remote_project['name'];
					$updates[$id]['image'] = $remote_project['image'];
					$updates[$id]['version'] = $local_version;
					$updates[$id]['new_version'] = $remote_version;
					$updates[$id]['changelog'] = $remote_project['changelog'];
					$updates[$id]['autoupdate'] = 0;
				}
			}
		}

		//record results
		update_site_option('ultimatum_updates_available', $updates);
	} else {
		return false;
	}

	return $updates;
}
function ultimatum_get_updates() {
	if ( get_site_option('ultimatum_refresh_updates_flag') || false === ( $updates = get_site_transient( 'ultimatum_updates_data' ) ) ) {
		return ultimatum_refresh_updates();
	}
	return $updates;
}

function ultimatum_get_local_projects() {
	if ( false === ( $projects = get_site_transient( 'ultimatum_local_projects' ) ) ) {
		return ultimatum_refresh_local_projects(true); //set to true to avoid infinite loop
	}

	return $projects;
}

function ultimatum_get_projects() {
	$projects = array();

	//----------------------------------------------------------------------------------//
	//plugins directory
	//----------------------------------------------------------------------------------//
	$plugins_root = WP_PLUGIN_DIR;
	if( empty($plugins_root) ) {
		$plugins_root = ABSPATH . 'wp-content/plugins';
	}

	$plugins_dir = @opendir($plugins_root);
	$plugin_files = array();
	if ( $plugins_dir ) {
		while (($file = readdir( $plugins_dir ) ) !== false ) {
			if ( substr($file, 0, 1) == '.' )
				continue;
			if ( is_dir( $plugins_root.'/'.$file ) ) {
				$plugins_subdir = @ opendir( $plugins_root.'/'.$file );
				if ( $plugins_subdir ) {
					while (($subfile = readdir( $plugins_subdir ) ) !== false ) {
						if ( substr($subfile, 0, 1) == '.' )
							continue;
						if ( substr($subfile, -4) == '.php' )
							$plugin_files[] = "$file/$subfile";
					}
				}
			} else {
				if ( substr($file, -4) == '.php' )
					$plugin_files[] = $file;
			}
		}
	}
	@closedir( $plugins_dir );
	@closedir( $plugins_subdir );

	if ( $plugins_dir && !empty($plugin_files) ) {
		foreach ( $plugin_files as $plugin_file ) {
			if ( is_readable( "$plugins_root/$plugin_file" ) ) {

				unset($data);
				$data = ultimatum_get_id_plugin( "$plugins_root/$plugin_file" );

				if ( isset($data['id']) && !empty($data['id']) ) {
					$projects[$data['id']]['type'] = 'plugin';
					$projects[$data['id']]['version'] = $data['version'];
					$projects[$data['id']]['filename'] = $plugin_file;
				}
			}
		}
	}

	//----------------------------------------------------------------------------------//
	// mu-plugins directory
	//----------------------------------------------------------------------------------//
	$mu_plugins_root = WPMU_PLUGIN_DIR;
	if( empty($mu_plugins_root) ) {
		$mu_plugins_root = ABSPATH . 'wp-content/mu-plugins';
	}

	if ( is_dir($mu_plugins_root) && $mu_plugins_dir = @opendir($mu_plugins_root) ) {
		while (($file = readdir( $mu_plugins_dir ) ) !== false ) {
			if ( substr($file, -4) == '.php' ) {
				if ( is_readable( "$mu_plugins_root/$file" ) ) {

					unset($data);
					$data = ultimatum_get_id_plugin( "$mu_plugins_root/$file" );

					if ( isset($data['id']) && !empty($data['id']) ) {
						$projects[$data['id']]['type'] = 'mu-plugin';
						$projects[$data['id']]['version'] = $data['version'];
						$projects[$data['id']]['filename'] = $file;
					}
				}
			}
		}
		@closedir( $mu_plugins_dir );
	}

	//----------------------------------------------------------------------------------//
	// wp-content directory
	//----------------------------------------------------------------------------------//
	$content_plugins_root = WP_CONTENT_DIR;
	if( empty($content_plugins_root) ) {
		$content_plugins_root = ABSPATH . 'wp-content';
	}

	$content_plugins_dir = @opendir($content_plugins_root);
	$content_plugin_files = array();
	if ( $content_plugins_dir ) {
		while (($file = readdir( $content_plugins_dir ) ) !== false ) {
			if ( substr($file, 0, 1) == '.' )
				continue;
			if ( !is_dir( $content_plugins_root.'/'.$file ) ) {
				if ( substr($file, -4) == '.php' )
					$content_plugin_files[] = $file;
			}
		}
	}
	@closedir( $content_plugins_dir );

	if ( $content_plugins_dir && !empty($content_plugin_files) ) {
		foreach ( $content_plugin_files as $content_plugin_file ) {
			if ( is_readable( "$content_plugins_root/$content_plugin_file" ) ) {
				unset($data);
				$data = ultimatum_get_id_plugin( "$content_plugins_root/$content_plugin_file" );

				if ( isset($data['id']) && !empty($data['id']) ) {
					$projects[$data['id']]['type'] = 'drop-in';
					$projects[$data['id']]['version'] = $data['version'];
					$projects[$data['id']]['filename'] = $content_plugin_file;
				}
			}
		}
	}

	//----------------------------------------------------------------------------------//
	//themes directory
	//----------------------------------------------------------------------------------//
	$themes_root = WP_CONTENT_DIR . '/themes';
	if ( empty($themes_root) ) {
		$themes_root = ABSPATH . 'wp-content/themes';
	}
	
	$themes_dir = @opendir($themes_root);
	$themes_files = array();
	$local_themes = array();
	if ( $themes_dir ) {
		while (($file = readdir( $themes_dir ) ) !== false ) {
			if ( substr($file, 0, 1) == '.' )
				continue;
			if ( is_dir( $themes_root.'/'.$file ) ) {
				$themes_subdir = @ opendir( $themes_root.'/'.$file );
				if ( $themes_subdir ) {
					while (($subfile = readdir( $themes_subdir ) ) !== false ) {
						if ( substr($subfile, 0, 1) == '.' )
							continue;
						if ( substr($subfile, -4) == '.css' )
							$themes_files[] = "$file/$subfile";
					}
				}
			} else {
				if ( substr($file, -4) == '.css' )
					$themes_files[] = $file;
			}
		}
	}
	@closedir( $themes_dir );
	@closedir( $themes_subdir );
	
	if ( $themes_dir && !empty($themes_files) ) {
		foreach ( $themes_files as $themes_file ) {
			if ( is_readable( "$themes_root/$themes_file" ) ) {
				unset($data);
				$data = ultimatum_get_id_plugin( "$themes_root/$themes_file" );
				if ( isset($data['id']) && !empty($data['id']) ) {
					$projects[$data['id']]['type'] = 'theme';
					$projects[$data['id']]['filename'] = substr( $themes_file, 0, strpos( $themes_file, '/' ) );
					$projects[$data['id']]['version'] = $data['version'];
				}
			}
		}
	}
	//----------------------------------------------------------------------------------//

	return $projects;
}

function ultimatum_get_id_plugin($plugin_file) {
	return get_file_data( $plugin_file, array('name' => 'Plugin Name', 'id' => 'ULT ID', 'version' => 'Version') );
}
function ultimatum_can_auto_download_project($type) {
	$root = $writable = false;
	$is_direct_access_fs = ('direct' == get_filesystem_method()) // Are we dealing with direct access FS?
	? true
	: false
	;
	if ('plugin' == $type) {
		$root = WP_PLUGIN_DIR;
		if( empty($root) ) {
			$root = ABSPATH . 'wp-content/plugins';
		}
	} else {
		$root = WP_CONTENT_DIR . '/themes';
		if( empty($root) ) {
			$root = ABSPATH . 'wp-content/themes';
		}
	}
	if ($is_direct_access_fs) $writable = $root ? is_writable($root) : false;

	// If we don't have write permissions, do we have FTP settings?
	$writable = $writable ? $writable : defined('FTP_USER')
	&& defined('FTP_PASS')
	&& defined('FTP_HOST')
	;

	// Lastly, if no other option worked, do we have SSH settings?
	$writable = $writable ? $writable : defined('FTP_USER')
	&& defined('FTP_PUBKEY')
	&& defined('FTP_PRIKEY')
	;

	return $writable;
}

function ultimatum_auto_install_url($project_id) {
	$data = ultimatum_get_updates();
	$local_projects = ultimatum_get_local_projects();
	$api_key = ultimatum_get_api();
	$installed_foreigner = ($data['toolset'][$project_id]['type'] == 'plugin' && file_exists(WP_PLUGIN_DIR.'/'.$data['toolset'][$project_id]['standalone'])) ? true : false;
	if ( !isset($local_projects[$project_id])
	&& $api_key && !$installed_foreigner
	) {
		if ($data['toolset'][$project_id]['type'] == 'plugin')
			return wp_nonce_url(self_admin_url("update.php?action=install-plugin&plugin=ultimatum_install-$project_id"), "install-plugin_ultimatum_install-$project_id");
		else if ($data['toolset'][$project_id]['type'] == 'theme')
			return wp_nonce_url(self_admin_url("update.php?action=install-theme&theme=ultimatum_install-$project_id"), "install-theme_ultimatum_install-$project_id");
	}
	return false;
}
function ultimatum_foreigner_project($project_id) {
	$data = ultimatum_get_updates();
	$local_projects = ultimatum_get_local_projects();
	$installed_foreigner = ($data['toolset'][$project_id]['type'] == 'plugin' && file_exists(WP_PLUGIN_DIR.'/'.$data['toolset'][$project_id]['standalone'])) ? true : false;
	if ( !isset($local_projects[$project_id]) && $installed_foreigner) {
		return true;
	}
	return false;
}
function ultimatum_filter_plugin_count( $value ) {

	//remove any conflicting slug local Ultimatum plugins from WP update notifications
	$local_projects = ultimatum_get_local_projects();
	foreach ( $local_projects as $id => $plugin ) {
		if (isset($value->response[$plugin['filename']]))
			unset($value->response[$plugin['filename']]);
	}

	$updates = get_site_option('ultimatum_updates_available');
	if ( is_array($updates) && count($updates) ) {
		$api_key = ultimatum_get_api();
		$enable_autoupdates = get_site_option('ultimatum_updates_available');
		foreach ( $updates as $id => $plugin ) {
			if ( $plugin['type'] == 'plugin'){

				//build plugin class
				$object = new stdClass;
				$object->url = $plugin['url'];
				$object->slug = "ultimatum_install-$id";
				$object->upgrade_notice = $plugin['changelog'];
				$object->new_version = $plugin['new_version'];
				$object->package = ULTIMATUM_API . "?task=plugin&key=$api_key&pid=$id";
				//enable autoupdates of this plugin if allowed by user
//				 $object->autoupdate = true;

				//add to class
				$value->response[$plugin['filename']] = $object;
			}
		}
	}

	return $value;
}

function ultimatum_filter_theme_count( $value ) {
	$updates = get_site_option('ultimatum_updates_available');
	if ( is_array($updates) && count($updates) ) {
		$api_key = ultimatum_get_api();
		foreach ( $updates as $id => $theme ) {
			if ( $theme['type'] == 'theme') {
				//build theme listing
				$value->response[$theme['filename']]['url'] = ULTIMATUM_API . '?action=details&id=' . $id;
				$value->response[$theme['filename']]['new_version'] = $theme['new_version'];
				$value->response[$theme['filename']]['package'] = ULTIMATUM_API . "?task=plugin&key=$api_key&pid=$id";
			}
		}
	}
	return $value;
}

function ultimatum_menu_access_rights(){
	$option = get_site_option('ultimatum_toolset');
	if(is_multisite()){
		global $blog_id;
		if(isset($option['disable_sites']) && is_array($option['disable_sites']) && count($option['disable_sites'])!=0 && in_array($blog_id, $option['disable_sites']) && !is_super_admin()){
			return false;
		} else {
			return true;
		}
	} else {
		$user_ID = get_current_user_id();
		if(isset($option['disable_menus']) && $option['disable_menus']=='true' && $option['allowed_user']!=$user_ID ){
			return false;
		} else {
			return true;
		}
	}
}


