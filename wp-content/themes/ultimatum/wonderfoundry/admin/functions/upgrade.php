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

/**
 * Ping https://api.ultimatumtheme.com/ asking if a new version of this theme is available.
 *
 * If not, it returns false.
 *
 * If so, the external server passes serialized data back to this function, which gets unserialized and returned for use.
 *
 * Applies `ultimatum_update_remote_post_options` filter.
 *
 * Ping occurs at a maximum of once every 24 hours.
 *
 */
function ultimatum_update_check() {

	global $wp_version;
	$ultimatumversion = get_option('ultimatum_version');
	if(is_multisite()){
		$apikey = get_site_option('ultimatum_api');
	} else {
		$apikey = get_option('ultimatum_api');
	}
	//* If updates are disabled
	if ( ! get_option( 'ultimatum-auto-update' ) || ! $apikey )
		return false;

	//* Get time of last update check
	$ultimatum_update = get_transient( 'ultimatum-update' );

	//* If it has expired, do an update check
	if ( ! $ultimatum_update ) {
		$url = ULTIMATUM_API;
		$options = array(
				'body' => array(
						'task'=>'updatecheck',
						'ultimatum_version' => $ultimatumversion,
						'wp_version' => $wp_version,
						'php_version' => phpversion(),
						'uri' => home_url(),
						'api_key' => $apikey,
						'user-agent' => "WordPress/$wp_version;"
				)
		);

		$response = wp_remote_post( $url, $options );
		$ultimatum_update = wp_remote_retrieve_body( $response );

		//* If an error occurred, return FALSE, store for 1 hour
		if ( 'error' === $ultimatum_update || is_wp_error( $ultimatum_update ) || ! is_serialized( $ultimatum_update ) ) {
			set_transient( 'ultimatum-update', array( 'new_version' => ULTIMATUM_VERSION ), 60 * 60 );
			return false;
		}

		//* Else, unserialize
		$ultimatum_update = maybe_unserialize( $ultimatum_update );

		//* And store in transient for 24 hours
		set_transient( 'ultimatum-update', $ultimatum_update, 60 * 60 * 24 );
	}

	//* If we're already using the latest version, return false
	if ( version_compare( ULTIMATUM_VERSION, $ultimatum_update['new_version'], '>=' ) )
		return false;

	return $ultimatum_update;

}



add_action( 'admin_init', 'ultimatum_upgrade', 20 );
function ultimatum_upgrade() {

	

	do_action( 'ultimatum_upgrade' );

}

add_action( 'wpmu_upgrade_site', 'ultimatum_network_upgrade_site' );
function ultimatum_network_upgrade_site( $blog_id ) {

	switch_to_blog( $blog_id );
	$upgrade_url = add_query_arg( array( 'action' => 'ultimatum-silent-upgrade' ), admin_url( 'admin-ajax.php' ) );
	restore_current_blog();

	wp_remote_get( $upgrade_url );

}

add_action( 'wp_ajax_no_priv_ultimatum-silent-upgrade', 'ultimatum_silent_upgrade' );
function ultimatum_silent_upgrade() {

	remove_action( 'ultimatum_upgrade', 'ultimatum_upgrade_redirect' );
	ultimatum_upgrade();
	exit( 0 );

}

add_action( 'ultimatum_upgrade', 'ultimatum_upgrade_redirect' );
/**
 * Redirect the user back to the theme settings page, refreshing the data and notifying the user that they have
 * successfully updated.
 *
 * @since 1.6.0
 *
 * @uses ultimatum_admin_redirect() Redirect the user to an admin page, and add query args to the URL string for alerts.
 *
 * @return null Returns early if not an admin page.
 */
function ultimatum_upgrade_redirect() {

	if ( ! is_admin() || ! current_user_can( 'edit_theme_options' ) )
		return;

	#ultimatum_admin_redirect( 'ultimatum', array( 'upgraded' => 'true' ) );
	ultimatum_admin_redirect( 'ultimatum-upgraded' );
	exit;

}

add_action( 'admin_notices', 'ultimatum_upgraded_notice' );
/**
 * Displays the notice that the theme settings were successfully updated to the latest version.
 *
 * Currently only used for pre-release update notices.
 *
 * @since 1.2.0
 *
 * @uses ultimatum_get_option()   Get theme setting value.
 * @uses ultimatum_is_menu_page() Check that we're targeting a specific Ultimatum admin page.
 *
 * @return null Returns early if not on the Theme Settings page.
 */
function ultimatum_upgraded_notice() {

	if ( ! ultimatum_is_menu_page( 'ultimatum' ) )
		return;

	if ( isset( $_REQUEST['upgraded'] ) && 'true' === $_REQUEST['upgraded'] )
		echo '<div id="message" class="updated highlight" id="message"><p><strong>' . sprintf( __( 'Congratulations! You are now rocking Ultimatum %s', 'ultimatum' ), ultimatum_get_option( 'theme_version' ) ) . '</strong></p></div>';

}

add_filter( 'update_theme_complete_actions', 'ultimatum_update_action_links', 10, 2 );
function ultimatum_update_action_links( array $actions, $theme ) {

	if ( 'ultimatum' !== $theme )
		return $actions;

	return sprintf( '<a href="%s">%s</a>', menu_page_url( 'ultimatum', 0 ), __( 'Click here to complete the upgrade', 'ultimatum' ) );

}

add_action( 'admin_notices', 'ultimatum_update_nag' );
function ultimatum_update_nag() {

	$ultimatum_update = ultimatum_update_check();

	if ( ! is_super_admin() || ! $ultimatum_update )
		return false;

	echo '<div id="update-nag">';
	printf(
		__( 'Ultimatum %s is available. <a href="%s" %s>Check out what\'s new</a> or <a href="%s" %s>update now.</a>', 'ultimatum' ),
		esc_html( $ultimatum_update['new_version'] ),
		esc_url( $ultimatum_update['changelog_url'] ),
		'class="thickbox thickbox-preview"',
		wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=ultimatum', 'upgrade-theme_ultimatum' ),
		'class="ultimatum-js-confirm-upgrade"'
	);
	echo '</div>';

}


add_filter( 'site_transient_update_themes', 'ultimatum_update_push' );
add_filter( 'transient_update_themes', 'ultimatum_update_push' );

function ultimatum_update_push( $value ) {

	$ultimatum_update = ultimatum_update_check();

	if ( $ultimatum_update )
		$value->response['ultimatum'] = $ultimatum_update;

	return $value;

}

add_action( 'load-update-core.php', 'ultimatum_clear_update_transient' );
add_action( 'load-themes.php', 'ultimatum_clear_update_transient' );

function ultimatum_clear_update_transient() {

	delete_transient( 'ultimatum-update' );
	remove_action( 'admin_notices', 'ultimatum_update_nag' );

}

function ultimatum_install(){
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$prefix = $wpdb->prefix;
	$table_create_sql = array(
			"CREATE TABLE IF NOT EXISTS `".$prefix.ULTIMATUM_PREFIX."_classes` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`container` varchar(255) NOT NULL,
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
					`post_type` varchar(255) NOT NULL,
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
					`name` varchar(255) NOT NULL,
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
					`tname` varchar(255) NOT NULL,
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
	$ultextras = unserialize('a:11:{s:15:"ultimatum_forms";b:0;s:20:"ultimatum_slideshows";b:0;s:20:"ultimatum_shortcodes";b:0;s:24:"ultimatum_visualcomposer";b:0;s:21:"ultimatum_layerslider";b:0;s:20:"ultimatum_revolution";b:0;s:17:"ultimatum_showbiz";b:0;s:18:"ultimatum_postgals";b:0;s:13:"ultimatum_pto";b:0;s:16:"element_position";b:0;s:11:"woocommerce";b:0;}');
	add_option('ultimatum_extras',$ultextras,false);
	$ult_general_options = unserialize('a:5:{s:9:"text_logo";b:1;s:4:"logo";s:0:"";s:17:"display_site_desc";b:1;s:7:"favicon";s:0:"";s:7:"noimage";s:0:"";}');
	add_option('ultimatum_general',$ultextras,false);
	add_option('ult_installed','DONE',false);
	add_option('ultimatum_version',2.5106,false);
}
