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
 
add_action( 'load-dashboard_page_ultimatum-css-regen', 'ultimatum_css_regen_thickbox' );

function ultimatum_css_regen_thickbox()
{
	iframe_header();
	ultimatum_css_regenerator();
	iframe_footer();
	exit;
}
function ultimatum_css_regenerator(){
	
global $wpdb;
$query = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='full' AND `theme`='".$_REQUEST['theme']."'";
$results = $wpdb->get_results($query);
require_once (ULTIMATUM_ADMIN_HELPERS .DS. 'class.css.saver.php');
WonderWorksCSS::saveCSS($_REQUEST['theme'],'template');
echo '<li>Template css file(s) generated.</li>';
foreach ($results as $result){
	WonderWorksCSS::saveCSS($result->id);
	echo "<li>".$result->title.' css file(s) regenerated.</li>';
}
}
function ultimatum_css_regen(){
	
}