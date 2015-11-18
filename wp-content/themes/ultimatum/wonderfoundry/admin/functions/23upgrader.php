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
require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
global $wpdb;
$prefix = $wpdb->prefix;
$old_prefix = 'ultimatum';
$new_prefix = 'ult25';
$step = get_option('ultimatum_23_upgrader',1);
if($step == 1){
	/*
	 * 1 - Convert OLD DB to NEW DB
	 */
	
	/* Create new tables */
	$table_create_sql = array(
			"CREATE TABLE IF NOT EXISTS `".$prefix.$new_prefix."_extra_rows` (
						`template_id` int(11) NOT NULL,
						`name` varchar(55) NOT NULL,
						`slug` varchar(55) NOT NULL,
						`grid` varchar(55) NOT NULL,
						`amount` int(11) NOT NULL,
						UNIQUE KEY `template-row` (`template_id`,`slug`)
						) _collate_;",
			"CREATE TABLE IF NOT EXISTS `".$prefix.$new_prefix."_templates` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`name` varchar(55) NOT NULL,
						`width` int(11) NOT NULL,
						`margin` int(11) NOT NULL,
						`mwidth` int(11) NOT NULL,
						`mmargin` int(11) NOT NULL,
						`swidth` int(11) NOT NULL,
						`smargin` int(11) NOT NULL,
						`gridwork` varchar(55) NOT NULL DEFAULT 'ultimatum',
						`swatch` varchar(55) NOT NULL DEFAULT 'default',
						`type` int(11) NOT NULL,
						`dcss` varchar(3) NOT NULL DEFAULT 'no',
						`default` int(11) NOT NULL,
						`theme` varchar(55) NOT NULL,
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
	update_option('ultimatum_23_upgrader', 2);
	$step = 2;
}
if($step == 2){
	/*
	 * Identical tables in both versions
	 */
	$identicaltables= array(
			'classes',
			'css',
			'layout',
			'layout_assign',
			'ptypes',
			'rows',
			'sc',
			'mobile',
			'tax',
	);
	foreach($identicaltables as $identicaltable){
		ultimatum_rename_table($identicaltable);
	}
	update_option('ultimatum_23_upgrader', 3);
	$step = 3;
}
if($step == 3) {
    $layoutsexist = array();
// do the layout table conversion
    $layouttable = $wpdb->prefix . $new_prefix . '_layout';
    $selectlayouts = "SELECT * FROM `" . $layouttable . "`";
    $layouts = $wpdb->get_results($selectlayouts);
    foreach ($layouts as $layout) {
        if ($layout->type != "part") {
            $layoutsexist[] = $layout->id;
        }
        $newbefore = array();
        $newafter = array();
        $newrows = array();
        $newbeforeinsert = $layout->before;
        $newafterinsert = $layout->after;
        $newrowinsert = $layout->rows;
        if (strlen($layout->before) >= 1) {
            $data = array();
            $data = explode(',', $layout->before);
            foreach ($data as $dat) {
                $newbefore[] = 'layout-' . $dat;
            }
            $newbeforeinsert = implode(',', $newbefore);
        }
        if (strlen($layout->after) >= 1) {
            $data = array();
            $data = explode(',', $layout->after);
            foreach ($data as $dat) {
                $newafter[] = 'layout-' . $dat;
            }
            $newafterinsert = implode(',', $newafter);
        }
        if (strlen($layout->rows) >= 1) {
            $data = array();
            $data = explode(',', $layout->rows);
            foreach ($data as $dat) {
                $newrows[] = 'row-' . $dat;
            }
            $newrowinsert = implode(',', $newrows);
        }
        $update = "UPDATE `" . $layouttable . "` SET `before`='" . $newbeforeinsert . "', `after`='" . $newafterinsert . "', `rows`='" . $newrowinsert . "' WHERE `id`='" . $layout->id . "'";
        $wpdb->query($update);
    }
    update_option('ultimatum_23_upgrader', 4);
    $step = 4;
}
if($step == 4) {
// do the templates table conversion
    $themesexist = array();
    $oldtemplatestable = $wpdb->prefix . $old_prefix . '_themes';
    $newtemplatestable = $wpdb->prefix . $new_prefix . '_templates';
    $selecttemplates = "SELECT * FROM `" . $oldtemplatestable . "`";
    $templates = $wpdb->get_results($selecttemplates);
    foreach ($templates as $template) {
        $id = $template->id;
        $name = $template->name;
        $width = $template->width;
        $margin = $template->margin;
        $mwidth = 1200;
        $mmragin = 20;
        $swidth = 744;
        $smargin = 20;
        $gridwork = "ultimatum";
        $swatch = "default";
        $type = $template->type;
        $dcss = "no";
        $default = $template->published;
        $theme = $template->template;
        $themesexist[] = $template->template;
        $inserttonewtemplates = "INSERT INTO `" . $newtemplatestable . "` VALUES ('" . $id . "', '" . $name . "', '" . $width . "', '" . $margin . "', '" . $mwidth . "', '" . $mmragin . "', '" . $swidth . "', '" . $smargin . "', '" . $gridwork . "', '" . $swatch . "', '" . $type . "', '" . $dcss . "', '" . $default . "', '" . $theme . "')";
        $wpdb->query($inserttonewtemplates);
    }
    update_option('ultimatum_23_upgrader', 5);
    $step = 5;
}
if($step == 5) {
// Go for the custom CSS
    /*
     * Ult 2.3 has only css per layout and also custom css per layout so we need to check each layout in each theme
     */
// $cssfile = THEME_CACHE_DIR.'/custom_'.$prel.$layout_id.'.css';
    $upload_dir = wp_upload_dir();
    $uploaddir = $upload_dir["basedir"];
    foreach ($themesexist as $theme) {
        $dir = $uploaddir . '/' . $theme;
        if (is_multisite()) {
            global $blog_id;
            $prel = $blog_id . '_';
        } else {

        }
        foreach ($layoutsexist as $layoex) {
            $file = $dir . '/custom_' . $prel . $layoex . '.css';
            if (file_exists($file)) {
                $option = $theme . '_custom_css_' . $layoex;
                $css = stripslashes_deep(file_get_contents($file));
                update_option($option, $css, false);
            }
        }
        // ultimatum_css_generator_fromimport($theme,false);
    }
    update_option('ultimatum_23_upgrader', 6);
    $step = 6;
}
if($step == 6) {
    /*
     * 2- Convert OLD Options to New Options
     */
    $old_options = get_option('ultimatum_general');
    /*
     * ultimatum_scripts
     * ultimatum_tags
     * ultimatum_sidebars
     */
    $opitonconverter = array(
        'scripts' => array("head_scripts", "footer_scripts", "pptheme", "google_charset", "tw_consumer_key", "tw_consumer_secret", "tw_access_token", "tw_access_secret"),
        'tags' => array("multi_logo", "multi_slogan", "multi_article", "multi_widget", "single_logo", "single_slogan", "single_article", "single_widget"),
        'sidebars' => array('sidebars'),

    );
    foreach ($opitonconverter as $option => $values) {
        $newoption = 'ultimatum_' . $option;
        $newoptionvalue = array();
        foreach ($values as $value) {
            $newoptionvalue["$value"] = $old_options["$value"];
        }
        update_option($newoption, $newoptionvalue, false);
    }
    update_option('ultimatum_23_upgrader', 7);
    $step = 7;
}
if($step == 7){
    update_option('ultimatum_version',2.5001);
}

function ultimatum_rename_table($tablename){
	global $wpdb;
	$old_prefix = 'ultimatum';
	$new_prefix = 'ult25';
	$old = $wpdb->prefix.$old_prefix.'_'.$tablename;
	$new = $wpdb->prefix.$new_prefix.'_'.$tablename;
	$sql = "RENAME TABLE `" . $old . "` TO `" . $new . "`";
	$wpdb->query($sql);
}