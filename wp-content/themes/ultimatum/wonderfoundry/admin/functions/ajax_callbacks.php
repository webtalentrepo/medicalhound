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
 * @version 2.38
 */

/* 01. Save Row Orders and Generate CSS */
add_action('wp_ajax_ultimatum_save_layout_rows','ultimatum_save_layout_rows');
function ultimatum_save_layout_rows(){
	require_once (ULTIMATUM_ADMIN_HELPERS .DS. 'class.css.saver.php');
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$layoutid=$_POST["layoutid"];
	$rows = $_POST['rows'];
	$before = $_POST['before'];
	$after = $_POST['after'];
	$layoutname=$_POST["layoutname"];
	$type=$_POST["type"];
	$default=$_POST["isdefault"];
	$theme=$_POST["theme"];
	$tb = explode(',', $before);
	foreach ($tb as $b){
		if(strlen($b)>=1){
			$bb[]=$b;
		}
	}
	$before = @implode(',', $bb);
	$ta = explode(',', $after);
	foreach ($ta as $a){
		if(strlen($a)>=1){
			$aa[]=$a;
		}
	}
	$after = @implode(',', $aa);
	$tr = explode(',', $rows);
	foreach ($tr as $t){
		if(strlen($t)>=1){
			$r[]=$t;
		}
	}
	$rows = @implode(',', $r);
	$query = "REPLACE INTO $table (`id`,`title`,`rows`,`before`,`after`,`type`,`default`,`theme`) VALUES ($layoutid,'$layoutname','$rows','$before','$after','$type','$default','$theme')";
	//echo $query;
	$wpdb->query($query);
	if($type=='full'){
		WonderWorksCSS::saveCSS($layoutid);
	} else {
		$query = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='full' AND `theme`='".$theme."'";
		$results = $wpdb->get_results($query);
		foreach ($results as $result){
			WonderWorksCSS::saveCSS($result->id);
		}
	}
	die('-1');
}

/* 02. Save widget order in Layout Builder */
add_action('wp_ajax_ultimatum-widgets-order', 'ultimate_widget_order_callback');
function ultimate_widget_order_callback(){
	check_ajax_referer( 'save-sidebar-widgets', 'savewidgets' );
	if ( !current_user_can('edit_theme_options') )
		die('-1');
	unset( $_POST['savewidgets'], $_POST['action'] );
	$sidebars =ultimatum_get_sidebars_widgets();
	if ( is_array($_POST['sidebars']) ) {
		foreach ( $_POST['sidebars'] as $key => $val ) {
			$sb = array();
			if ( !empty($val) ) {
				$val = explode(',', $val);
				foreach ( $val as $k => $v ) {
					if ( strpos($v, 'widget-') === false )
						continue;
					$sb[$k] = substr($v, strpos($v, '_') + 1);
				}
			}
			$sidebars[$key] = $sb;
		}
		ultimatum_set_sidebars_widgets($sidebars);
		die('1');
	}
	die('-1');
}

/*  03. Add row to layout in Layout Builder */
add_action('wp_ajax_ultimatum-get-row', 'ultimatum_get_row_callback');
function ultimatum_get_row_callback() {
	$html = ultimatum_create_row($_POST['id'],$_POST['style']);
	if (! empty($html)) {
		echo $html;
	} else {
		die(0);
	}
}
/*  04. Clone a Layout in Layout Builder */
add_action('wp_ajax_ultimatum-clone-layout', 'ultimatum_clone_layout_callback');
function ultimatum_clone_layout_callback(){
	global $wpdb;
	$tobecloned = $_POST["layoutid"];
	$select = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `id`='$tobecloned'";
	$sourcelayout = $wpdb->get_row($select,ARRAY_A);
	$title = $sourcelayout["title"].'(copy)';
	$cloneql = "INSERT INTO `".ULTIMATUM_TABLE_LAYOUT."` (`title`,`type`,`theme`) VALUES ('$title','".$sourcelayout["type"]."','".$sourcelayout["theme"]."')";
	$cloneql = $wpdb->query($cloneql);
	$cloneid = $wpdb->insert_id;
	ultimatum_clone_layout_part($sourcelayout["before"],'before',$tobecloned,$cloneid);
	ultimatum_clone_layout_part($sourcelayout["rows"],'rows',$tobecloned,$cloneid);
	ultimatum_clone_layout_part($sourcelayout["after"],'after',$tobecloned,$cloneid);
	$option = get_option(THEME_SLUG.'_'.$tobecloned.'_css');
	$newopt = update_option(THEME_SLUG.'_'.$cloneid.'_css', $option);
    /*
     * Clone the options
     */
    $options = get_option(THEME_SLUG.'_'.$tobecloned.'_options');
    $newopts = update_option(THEME_SLUG.'_'.$cloneid.'_options', $options);
	$custom_css = get_option(THEME_SLUG.'_custom_css_'.$tobecloned);
	if(strlen($custom_css)) update_option(THEME_SLUG.'_custom_css_'.$cloneid,$custom_css);
	unset($_POST);
	require_once (ULTIMATUM_ADMIN_HELPERS.DS.'class.css.saver.php');
	WonderWorksCSS::saveCSS($cloneid);
	}
function ultimatum_clone_layout_part($data,$part,$source,$target){
	global $wpdb;
	global $wp_registered_widgets, $wp_registered_widget_controls;
	$ultimatum_sidebars_widgets = get_option('ultimatum_sidebars_widgets');
	$rows = explode(',',$data);
	foreach ($rows as $row){
		$rowinfo = explode('-',$row);
		if($rowinfo[0]!='row'){
			$newrows[] = $row;
		} else {
			$rowid = $rowinfo[1];

			$query = "SELECT * FROM `".ULTIMATUM_TABLE_ROWS."` WHERE id=$rowid";
			$sourcerow = $wpdb->get_row($query,ARRAY_A);
			$rtype = $sourcerow["type_id"];
			$insertrow = "INSERT INTO `".ULTIMATUM_TABLE_ROWS."` (`layout_id`,`type_id`) VALUES ('$target','$rtype')";
			$insertrow = $wpdb->query($insertrow);
			$newrowid = $wpdb->insert_id;
			$newrows[]='row-'.$newrowid;
			// DO CSS
			// 1- Wrapper
			$oldw= 'wrapper-'.$rowid;
			$qw = "SELECT * FROM `".ULTIMATUM_TABLE_CSS."` WHERE `container`='$oldw' AND `layout_id`='$source'";
			$qwc = "SELECT * FROM `".ULTIMATUM_TABLE_CLASSES."` WHERE `container`='$oldw' AND `layout_id`='$source'";
			$qwf = $wpdb->get_row($qw,ARRAY_A);
			$qwcf = $wpdb->get_row($qwc,ARRAY_A);
			if($qwf){
				$neww = 'wrapper-'.$newrowid;
				$newwi = "INSERT INTO `".ULTIMATUM_TABLE_CSS."` (`container`,`layout_id`,`element`,`properties`) VALUES ('$neww','$target','$qwf[element]','$qwf[properties]')";
				$newwi = $wpdb->query($newwi);
			}
			if($qwcf){
				$neww = 'wrapper-'.$newrowid;
				$newwi = "INSERT INTO `".ULTIMATUM_TABLE_CLASSES."` (`container`,`layout_id`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`) VALUES ('$neww','$target','$qwcf[user_class]','$qwcf[hidephone]','$qwcf[hidetablet]','$qwcf[hidedesktop]')";
				$newwi = $wpdb->query($newwi);
			}
			// 2- Container
			$oldw= 'container-'.$rowid;
			$qw = "SELECT * FROM `".ULTIMATUM_TABLE_CSS."` WHERE `container`='$oldw' AND `layout_id`='$source'";
			$qwc = "SELECT * FROM `".ULTIMATUM_TABLE_CLASSES."` WHERE `container`='$oldw' AND `layout_id`='$source'";
			$qwf = $wpdb->get_row($qw,ARRAY_A);
			$qwcf = $wpdb->get_row($qwc,ARRAY_A);
			if($qwf){
				$neww = 'container-'.$newrowid;
				$newwi = "INSERT INTO `".ULTIMATUM_TABLE_CSS."` (`container`,`layout_id`,`element`,`properties`) VALUES ('$neww','$target','$qwf[element]','$qwf[properties]')";
				$newwi = $wpdb->query($newwi);
			}
			if($qwcf){
				$neww = 'container-'.$newrowid;
				$newwi = "INSERT INTO `".ULTIMATUM_TABLE_CLASSES."` (`container`,`layout_id`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`) VALUES ('$neww','$target','$qwcf[user_class]','$qwcf[hidephone]','$qwcf[hidetablet]','$qwcf[hidedesktop]')";
				$newwi = $wpdb->query($newwi);
			}
			// 3- Columns

			global $wp_registered_widgets;
			for($j=1;$j<=6;$j++){
				$oldw= 'col-'.$rowid.'-'.$j;
				$olds= 'sidebar-'.$rowid.'-'.$j;
				$neww = 'col-'.$newrowid.'-'.$j;
				$newsb = 'sidebar-'.$newrowid.'-'.$j;
				// 4- Widgets !!! ultimatum_next_widget_id_number
				if(count($ultimatum_sidebars_widgets["$olds"])>=1){
					foreach ($ultimatum_sidebars_widgets["$olds"] as $id){
						if(isset($wp_registered_widgets["$id"])){
							$fwidget = $wp_registered_widgets["$id"];
							$id_base = $wp_registered_widget_controls[$fwidget['id']]['id_base'];
							$currentwid = str_replace($id_base.'-', '', $fwidget["id"]);
							$callback = $wp_registered_widgets["$id"]['callback'][0];
							$option= $callback->option_name;
							$warray = get_option($option);
                            // Better widget ID control
                            $nextidfromWP = ult_next_widget_id_number($id_base);
                            $nextid = ult_messed_widget_id($option,$nextidfromWP);
							$warray["$nextid"] = $warray["$currentwid"];
							update_option($option, $warray);
							$ultimatum_sidebars_widgets[$newsb][]=$id_base.'-'.$nextid;
							update_option('ultimatum_sidebars_widgets',$ultimatum_sidebars_widgets);
							unset($warray);
						}
					}


				}
				$qw = "SELECT * FROM `".ULTIMATUM_TABLE_CSS."` WHERE `container`='$oldw' AND `layout_id`='$source'";
				$qwc = "SELECT * FROM `".ULTIMATUM_TABLE_CLASSES."` WHERE `container`='$oldw' AND `layout_id`='$source'";
				$qwf = $wpdb->get_row($qw,ARRAY_A);
				$qwcf = $wpdb->get_row($qwc,ARRAY_A);
				if($qwf){
					$newwi = "INSERT INTO `".ULTIMATUM_TABLE_CSS."` (`container`,`layout_id`,`element`,`properties`) VALUES ('$neww','$target','$qwf[element]','$qwf[properties]')";
					$newwi = $wpdb->query($newwi);
				}
				if($qwcf){
					$newwi = "INSERT INTO `".ULTIMATUM_TABLE_CLASSES."` (`container`,`layout_id`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`) VALUES ('$neww','$target','$qwcf[user_class]','$qwcf[hidephone]','$qwcf[hidetablet]','$qwcf[hidedesktop]')";
					$newwi = $wpdb->query($newwi);
				}

			}
		}

	}
	// Insert rows
	$newrow = implode(',',$newrows);
	$update = "UPDATE `".ULTIMATUM_TABLE_LAYOUT."` SET `".$part."`='$newrow' WHERE id='$target'";
	$wpdb->query($update);
}
if(!function_exists('ult_next_widget_id_number')) {
    function ult_next_widget_id_number($id_base)
    {
        global $wp_registered_widgets;
        $number = 1;

        foreach ($wp_registered_widgets as $widget_id => $widget) {
            if (preg_match('/' . $id_base . '-([0-9]+)$/', $widget_id, $matches))
                $number = max($number, $matches[1]);
        }
        $number++;

        return $number;
    }
}
if(!function_exists("ult_messed_widget_id")){
    function ult_messed_widget_id($widget,$wpid){
        $messedids = get_option('ult_messed_widget_ids');
        if(isset($messedids[$widget])){
            $nextid=$messedids[$widget]+1;
            if($nextid>$wpid){
                $messedids[$widget]= $nextid;
            } else {
                $nextid = $wpid;
                $messedids[$widget]= $wpid;
            }

        } else {
            $nextid = $wpid;
            $messedids[$widget]= $wpid;
        }
        update_option('ult_messed_widget_ids',$messedids);
        return $nextid;

    }
}
/*  06. Set Default Layout */
add_action('wp_ajax_ultimatum-default-layout', 'ultimatum_default_layout_callback');
function ultimatum_default_layout_callback(){
	global $wpdb;
	$sql1 = "UPDATE `".ULTIMATUM_TABLE_LAYOUT."` SET `default` = 0 WHERE `theme`='".$_POST["template_id"]."'";
	$wpdb->query($sql1);
	$sql2 = "UPDATE `".ULTIMATUM_TABLE_LAYOUT."` SET `default` = 1 WHERE `id`='".$_POST["layout_id"]."' AND `theme`='".$_POST["template_id"]."'";
	$wpdb->query($sql2);
}
/*  07. Delete  Layout */
add_action('wp_ajax_ultimatum-delete-layout', 'ultimatum_delete_layout_callback');
/*
 * TODO Add widget delete
 */
function ultimatum_delete_layout_callback(){
	global $wpdb;
	$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_CSS."` WHERE `layout_id`='$_POST[layout_id]'";
	$wpdb->query($sql1);
	$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_ROWS."` WHERE `layout_id`='$_POST[layout_id]'";
	$wpdb->query($sql1);
	$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_CLASSES."` WHERE `layout_id`='$_POST[layout_id]'";
	$wpdb->query($sql1);
	$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_LAYOUT_ASSIGN."` WHERE `layout_id`='$_POST[layout_id]'";
	$wpdb->query($sql1);
	$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `id`='$_POST[layout_id]'";
	$wpdb->query($sql1);
	$files[] = THEME_CACHE_DIR.'/layout_custom_'.$_POST[layout_id].'.css';
	$files[] = THEME_CACHE_DIR.'/layout_'.$_POST[layout_id].'.css';
	$files[] = THEME_CACHE_DIR.'/cufon_'.$_POST[layout_id].'.php';
	$files[] = THEME_CACHE_DIR.'/google_'.$_POST[layout_id].'.php';
	$files[] = THEME_CACHE_DIR.'/fontface_'.$_POST[layout_id].'.css';
	foreach ($files as $file){
		if(file_exists($file)){
			unlink($file);
		}
	}
}
/*  06. Set Default Template */
add_action('wp_ajax_ultimatum-default-template', 'ultimatum_default_template_callback');
function ultimatum_default_template_callback(){
	global $wpdb;
	$sql1 = "UPDATE `".ULTIMATUM_TABLE_TEMPLATES."` SET `default` = 0 WHERE `theme`='".THEME_SLUG."'";
	$wpdb->query($sql1);
	$sql2 = "UPDATE `".ULTIMATUM_TABLE_TEMPLATES."` SET `default` = 1 WHERE `id`='".$_POST["template_id"]."'";
	$wpdb->query($sql2);
}
/*  07. Delete  Template */
/*
 * TODO Add widget delete
*/
add_action('wp_ajax_ultimatum-delete-template', 'ultimatum_delete_template_callback');
function ultimatum_delete_template_callback(){
	global $wpdb;
		$findlsql = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `theme`='$_POST[template_id]'";
		$result = $wpdb->get_results($findlsql,ARRAY_A);
		foreach ($result as $layout){
			$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_CLASSES."` WHERE `layout_id`='$layout[id]'";
			$wpdb->query($sql1);
			$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_CSS."` WHERE `layout_id`='$layout[id]'";
			$wpdb->query($sql1);
			$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_ROWS."` WHERE `layout_id`='$layout[id]'";
			$wpdb->query($sql1);
			$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_LAYOUT_ASSIGN."` WHERE `layout_id`='$layout[id]'";
			$wpdb->query($sql1);
			$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `id`='$layout[id]'";
			$wpdb->query($sql1);
			$files[] = THEME_CACHE_DIR.'/layout_'.$layout[id].'.css';
			$files[] = THEME_CACHE_DIR.'/layout_custom_'.$layout[id].'.css';
			$files[] = THEME_CACHE_DIR.'/layout_'.$layout[id].'.css';
			$files[] = THEME_CACHE_DIR.'/cufon_'.$layout[id].'.php';
			$files[] = THEME_CACHE_DIR.'/google_'.$layout[id].'.php';
			$files[] = THEME_CACHE_DIR.'/fontface_'.$layout[id].'.css';
			foreach ($files as $file){
				if(file_exists($file)){
					unlink($file);
				}
			}
		}
		$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_TEMPLATES."` WHERE `id`='$_POST[template_id]'";
		$wpdb->query($sql1);
		echo 'true';
		die();
}

/*
 * 08. 
 */



