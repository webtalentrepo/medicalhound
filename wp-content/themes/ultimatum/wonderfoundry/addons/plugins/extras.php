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

/*
 * Include the core 
 */
WonderWorksHelper::requireFromFolder(ULTIMATUM_PLUGINS.DS.'ultimatum_core');
/*
 * Include WYSIWYG Widget Requirements
 */
$ult_wysiwyg_widget = ULTIMATUM_PLUGINS .DS. 'ult-wysiwyg-widget'.DS.'ult-wysiwyg-widget.php';
require_once $ult_wysiwyg_widget;

/*
 * Include Front End CSS Editor
 */
$ultimatum_css_editor = ULTIMATUM_PLUGINS .DS. 'frontend-css'.DS.'ult-css.php';
require_once $ultimatum_css_editor;
/*
 * Include Widget Extender
 */
$ultimatum_widget_extender = ULTIMATUM_PLUGINS .DS. 'widget-extender'.DS.'widget-extender.php';
require_once $ultimatum_widget_extender;

if(is_admin()){
    $ultimatum_menu = ULTIMATUM_PLUGINS .DS. 'ult-mega-menu'.DS.'admin.php';
    require_once $ultimatum_menu;
}
if(get_ultimatum_option('extras', 'ultimatum_shortcodes')){
	WonderWorksHelper::requireFromFolder(UTIMATUM_SHORTCODES,"shortcodes");
	// insert Tiny Mce button
	$tinymce_button = ULTIMATUM_PLUGINS.DS.'tinymce'.DS.'tinymce.php';
	include $tinymce_button;
}
/*
 *  Enable Posts Type Order
 */
if(get_ultimatum_option('extras', 'ultimatum_pto')){
    add_action('admin_notices', 'ult_pto_notice');
}

if(get_ultimatum_option('extras', 'ultimatum_slideshows')){
	$sliders= ULTIMATUM_PLUGINS.DS.'ult-sliders'.DS.'usliders.php';
	include $sliders;
}
/*
 * Enable Multiple Featured Images
 */
if(get_ultimatum_option('extras', 'ultimatum_postgals')) { 
 	require_once (ULTIMATUM_ADMIN_HELPERS.'/metabox.generator.php');
	require_once (ULTIMATUM_ADMIN_HELPERS.'/metaboxes/gallery.php');
}

/*
 * PTO Notice
 */
function ult_pto_notice() {
    $function = is_multisite() ? 'network_admin_url' : 'admin_url';
    $installurl = wp_nonce_url($function("update.php?action=install-plugin&plugin=post-types-order"), "install-plugin_post-types-order");
    echo '<div class="updated"><p>';
    printf(__('Post Ordering is not included in Ultimatum anymore you can install it clicking <a href="%2$s">here</a> | <a href="%1$s">Hide Notice</a>', 'ultimatum'), '?ult_pto_nag_ignore=0',$installurl);
    echo "</p></div>";
}

add_action('admin_init', 'ult_pto_nag_ignore');

function ult_pto_nag_ignore() {
    if ( isset($_GET['ult_pto_nag_ignore'])){
        $option = get_option( 'ultimatum_extras' );
        $option['ultimatum_pto'] =false;
        update_option('ultimatum_extras',$option);
    }
}
/*
 * Include Front End iFrames
 */
$ultimatum_front_end_iframe = ULTIMATUM_PLUGINS .DS. 'ult-iframe'.DS.'ult-iframe.php';
require_once $ultimatum_front_end_iframe;

