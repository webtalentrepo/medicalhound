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
 * @version 2.38
 */
 

/**
 * Function used to get the default template and  layout info in extent from an assignment
 * @param string $posttype
 * @return object including all info about layout and its containing template
 */
function getDefaultTempLateandLayout(){
	global $wpdb;
	$query = "SELECT a.*,b.swatch,b.margin,b.width,b.swidth,b.smargin,b.mwidth,b.mmargin,b.type AS ttype,b.gridwork,b.name AS tname,b.cdn  FROM `".ULTIMATUM_TABLE_LAYOUT."` AS a LEFT JOIN `".ULTIMATUM_TABLE_TEMPLATES."` AS b ON (a.theme=b.id) WHERE a.default= 1 AND b.default=1 AND b.theme='".THEME_SLUG."'";
	$result = $wpdb->get_row($query);
	return $result;
}
/**
 * Function used to get the layout info in extent.
 * @param integer $id
 * @return object including all info about layout and its containing template
 */
function getLayoutInfo($id){
	global $wpdb;
	$query = "SELECT a.*,b.swatch,b.margin,b.width,b.swidth,b.smargin,b.mwidth,b.mmargin,b.type AS ttype,b.gridwork,b.dcss,b.cdn FROM `".ULTIMATUM_TABLE_LAYOUT."` AS a LEFT JOIN `".ULTIMATUM_TABLE_TEMPLATES."` AS b ON (a.theme=b.id) WHERE a.id= '".$id."'";
	$result = $wpdb->get_row($query);
	return $result;
}

/**
 * Function used to get the layout info in extent from an assignment
 * @param string $posttype
 * @return object including all info about layout and its containing template
 */
function getLayoutInfoFromAssignment($posttype){
	global $wpdb;
	$query = "SELECT a.*,b.swatch,b.margin,b.width,b.swidth,b.smargin,b.mwidth,b.mmargin,b.type AS ttype,b.gridwork,b.cdn,b.dcss FROM `".ULTIMATUM_TABLE_LAYOUT."` AS a LEFT JOIN `".ULTIMATUM_TABLE_TEMPLATES."` AS b ON (a.theme=b.id) LEFT JOIN `".ULTIMATUM_TABLE_LAYOUT_ASSIGN."` AS c ON (a.id=c.layout_id)  WHERE c.post_type='".$posttype."' AND b.theme='".THEME_SLUG."'";
	$result = $wpdb->get_row($query);
	return $result;
}

/**
 * Function used to get the template info
 * @param integer $id
 * @return object including all info about template
 */
function getTemplateInfo($id){
	global $wpdb;
	$query = "SELECT * FROM `".ULTIMATUM_TABLE_TEMPLATES."` WHERE id='".$id."'";
	$result = $wpdb->get_row($query);
	return $result;
}

/**
 * Function used to get the templates of the current theme
 * @return object including all info about templates
 */
function getAllTemplates(){
	global $wpdb;
	$query = "SELECT * FROM `".ULTIMATUM_TABLE_TEMPLATES."` WHERE `theme`='".THEME_SLUG."' ORDER BY `default` DESC";
	$result = $wpdb->get_results($query);
	return $result;
}