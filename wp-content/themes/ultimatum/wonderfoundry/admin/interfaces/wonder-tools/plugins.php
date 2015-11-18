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
add_action('admin_enqueue_scripts','layouteditor_scripts');
add_action('admin_enqueue_scripts','layouteditor_styles');

function layouteditor_styles(){
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style('isotope-css',ULTIMATUM_ADMIN_ASSETS. '/css/isotope.css');
	wp_enqueue_style('animate-css',ULTIMATUM_ADMIN_ASSETS. '/css/animate.css');
}

function layouteditor_scripts(){
	global $wp_version;
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('isotope',ULTIMATUM_ADMIN_ASSETS. '/js/jquery.isotope.min.js' );

}
function ultimatum_toolset_plugins() {
		global $wpdb, $current_site;

		if ( !current_user_can( 'install_plugins' ) ) {
			echo "<p>Nice Try...</p>";  //If accessed properly, this message doesn't appear.
			return;
		}

		$page_type = 'plugin';
		$page_title = __('Plugins', 'ultimatum');
		$data = ultimatum_get_updates();
		$local_projects = ultimatum_get_local_projects();
		

		//rearrange incompatible products to the bottom of the list
		if ( isset($data['toolset']) ) {
			$incompatible = $other = array();
			foreach ($data['toolset'] as $project) {
				if ( $project['requires'] == 'visualcomposer' )
					$incompatible[] = $project;
				else
					$other[] = $project;
			}
			$data['projects'] = array_merge($other, $incompatible);
		}
		//($data);
		//echo '<pre>';print_r($data);echo '</pre>';
		require_once( dirname(__FILE__) . '/views/listings.php' );
	}