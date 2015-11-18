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
 

function importTemplate($file,$folder,$echo=true,$defimport=false){

    $raw_content = file_get_contents($file);
    $content = base64_decode($raw_content);
    $theme = unserialize($content);
    if(isset($_POST['template_name']) && strlen($_POST['template_name'])!=0){
        $theme["name"] = $_POST['template_name'];
        } else {
        $theme["name"] = $theme['name'];
    }
    // Do Images
    if(isset($theme['images']) && is_array($theme['images'])) {
        $images = $theme['images'];
        foreach ($images as $image) {
            $imagespath = THEME_CACHE_DIR . '/' . $folder;
            $imagesurlpath = THEME_CACHE_URI . '/' . basename($folder);

            $imagefilename = basename($image['name']);
            $imagefile = $imagespath . '/' . $imagefilename;

            if (is_file($imagefile)) {
                $newimage = $imagesurlpath . '/' . $imagefilename;
                $theme = replaceTree($image['name'], $newimage, $theme);
            }

        } // Images Done
    }
    if(isset($theme['ult_version'])){
    	ultimatum_css_generator_fromimport(ult_importer($theme,$defimport),$echo);
    } else {
    	ultimatum_css_generator_fromimport(ult_legacy_importer($theme));
    }
    //unlink($file);
   if($echo)  echo 'Import Successfull';
}
function ult_importer($theme,$defimport=false){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
	$ltable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$atable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout_assign';
	$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
	$ctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
	$classtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';	
	$extrarowstable = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
	// INSERT THE THEME
	if(!$defimport){	
		$themesql = "INSERT INTO $table 
		(`name`, `width`, `margin`, `mwidth`, `mmargin`, `swidth`, `smargin`, `gridwork`, `swatch`, `type`, `dcss`, `theme`,`default`) VALUES
		('".$theme['name']."', '".$theme['width']."', '".$theme['margin']."', '".$theme['mwidth']."', '".$theme['mmargin']."', '".$theme['swidth']."', '".$theme['smargin']."', '".$theme['gridwork']."', '".$theme['swatch']."', '".$theme['type']."', '".$theme['dcss']."', '".THEME_SLUG."','0')";
	} else {
		$themesql = "INSERT INTO $table
		(`name`, `width`, `margin`, `mwidth`, `mmargin`, `swidth`, `smargin`, `gridwork`, `swatch`, `type`, `dcss`, `theme`,`default`) VALUES
		('".$theme['name']."', '".$theme['width']."', '".$theme['margin']."', '".$theme['mwidth']."', '".$theme['mmargin']."', '".$theme['swidth']."', '".$theme['smargin']."', '".$theme['gridwork']."', '".$theme['swatch']."', '".$theme['type']."', '".$theme['dcss']."', '".THEME_SLUG."','".$theme['default']."')";
	}

	$wpdb->query($themesql);
	$themeid = $wpdb->insert_id;
	// INSERT EXTRA ROWS
	if(isset($theme['extrarows']) && is_array($theme['extrarows'])){
		foreach ($theme['extrarows'] as $extrarow){
			$extrarow['template_id']=$themeid;
			$extrarowsql = 'INSERT INTO `'.$extrarowstable."` VALUES ('".$extrarow['template_id']."','".$extrarow['name']."','".$extrarow['slug']."','".$extrarow['grid']."','".$extrarow['amount']."')";
			$wpdb->query($extrarowsql);
		}
	}
	// repcale themid in array
	$theme = replaceTree('{themeid}',$themeid,$theme);
	if(is_array($theme['css']) && count($theme['css'])!=0){
		$themeoptionname = THEME_SLUG.'_template_'.$themeid.'_css';
		update_option($themeoptionname,$theme['css']);
	}
	if(isset($theme['custom_css']) && strlen($theme['custom_css'])>0){
		update_option(THEME_SLUG.'_custom_template_css_'.$themeid,$theme['custom_css']);
	}
	//Start Layouts
	$partconv = array();
	foreach($theme['layouts'] as $layout){
		//insert Layout
		$layoutsql = "INSERT INTO $ltable  (`title`,`type`,`theme`,`default`) VALUES ('".$layout['name']."','".$layout['type']."','".$themeid."','".$layout['default']."')";
		$wpdb->query($layoutsql);
		$layoutid = $wpdb->insert_id;
		// Save partials array
		if($layout['type']=='part'){
			$old_lay_id= $layout['oldid'];
			$partconv[$old_lay_id]='layout-'.$layoutid;
			ult_do_layout_part_import($layoutid,$layout,'rows');
		}  else {
			ult_do_layout_part_import($layoutid,$layout,'before',$partconv);
			ult_do_layout_part_import($layoutid,$layout,'rows',$partconv);
			ult_do_layout_part_import($layoutid,$layout,'after',$partconv);
			$optionname = THEME_SLUG.'_'.$layoutid.'_css';
			update_option($optionname,$layout['css']);
			// Create Custom CSS file
			if(isset($layout['custom_css']) && strlen($layout['custom_css'])>0){
				update_option(THEME_SLUG.'_custom_css_'.$layoutid,$layout['custom_css']);
			}
		}
		
	}
	// Layouts finished
	return $themeid;
}
function ult_do_layout_part_import($layoutid,$layout,$part,$partconv=null){
	global $wpdb;
	$layoutrows = array();
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
	$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
	$ctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
	$classtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
	$ltable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$rows = $layout[$part];
	foreach ($rows as $row){
		if($row['type']!="row"){ // it's a layout
			$layoutrows[] = $partconv[$row['oldid']];
		} else {
		// Insert the row and get id
		$rowsql = "INSERT INTO $rtable (`layout_id`, `type_id`) VALUES ('$layoutid','".$row['row_type']."')";
		$wpdb->query($rowsql);
		$rowid = $wpdb->insert_id;
		$layoutrows[]='row-'.$rowid;
		// Insert row wrapper CSS
		$wrapper = 'wrapper-'.$rowid;
		foreach($row['wrapper'] as $element=>$property){
			if($element!='custom_classes'){
				$properties = serialize($property);
				$wrappersql = "INSERT INTO $ctable VALUES ('','$wrapper','$layoutid','$element','$properties')";
				$wpdb->query($wrappersql);
			} else {
				$properties = unserialize($property);
				if(count($properties)!=0):
				$classql = "REPLACE INTO $classtable (`container`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`,`layout_id`) VALUES ('$wrapper','".$properties["user_class"]."','".$properties["hidephone"]."','".$properties["hidetablet"]."','".$properties["hidedesktop"]."','$layoutid')";
				$wpdb->query($classql);
				endif;
			}
		}
		// Insert row container CSS
		$container = 'container-'.$rowid;
		foreach($row['container'] as $element=>$property){
			if($element!='custom_classes'){
				$properties = serialize($property);
				$containersql = "INSERT INTO $ctable VALUES ('','$container','$layoutid','$element','$properties')";
				$wpdb->query($containersql);
			} else {
				$properties = unserialize($property);
				if(count($properties)!=0):
				$classql = "REPLACE INTO $classtable (`container`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`,`layout_id`) VALUES ('$container','".$properties["user_class"]."','".$properties["hidephone"]."','".$properties["hidetablet"]."','".$properties["hidedesktop"]."','$layoutid')";
				$wpdb->query($classql);
				endif;
			}
		}
		// Insert row Column CSS
		foreach ($row['col'] as $colid=>$colcss){
			$column = 'col-'.$rowid.'-'.$colid;
			foreach ($colcss as $element=>$property){
				if($element!='custom_classes'){
					$properties = serialize($property);
					$colsql = "INSERT INTO $ctable VALUES ('','$column','$layoutid','$element','$properties')";
					$wpdb->query($colsql);
				} else {
					$properties = unserialize($property);
					if(is_array($properties)):
					$classql = "REPLACE INTO $classtable (`container`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`,`layout_id`) VALUES ('$column','".$properties["user_class"]."','".$properties["hidephone"]."','".$properties["hidetablet"]."','".$properties["hidedesktop"]."','$layoutid')";
					$wpdb->query($classql);
					endif;
				}
			}
		}
		//Import the widgets
		if(is_array($row['widgets'])){
			foreach($row["widgets"] as $sidebar=>$widgets){
				foreach($widgets as $widget){
					$option = $widget['widget_name'];
					$id_base=$widget['id_base'];
                    // Better widget ID control
                    $nextidfromWP = ult_next_widget_id_number($widget['id_base']);
                    $nextid = ult_messed_widget_id($option,$nextidfromWP);

					$warray = get_option($option);
					unset($widget['widget_name']);
					unset($widget['id_base']);
					$warray[$nextid] = $widget;
					update_option($option, $warray);
					$ultimatum_sidebars_widgets = get_option('ultimatum_sidebars_widgets');
					$ultimatum_sidebars_widgets['sidebar-'.$rowid.'-'.$sidebar][]=$id_base.'-'.$nextid;
					update_option('ultimatum_sidebars_widgets',$ultimatum_sidebars_widgets);
					unset($warray);
	
				}
			}
		}
		// Widget import Done :)
		}		
	}
	if(count($layoutrows)!=0){
		$rowss = implode(',', $layoutrows);
		unset($layoutrows);
		$layoutupdatesql = "UPDATE $ltable SET `".$part."`='$rowss' WHERE `id`='$layoutid'";
		$wpdb->query($layoutupdatesql);
	}

}


function ult_legacy_importer($theme){

	global $wpdb;

	// Create the Theme
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
	$ltable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$atable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout_assign';
	$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
	$ctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
	$classtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
	$themesql = "INSERT INTO $table 
	(`name`, `width`,`margin`,`mwidth`,`mmargin`,`swidth`,`smargin`,`type`,`theme`,gridwork,swatch) VALUES 
	('$theme[name]','$theme[width]','$theme[margin]','1200','20','747','10','$theme[type]','".THEME_SLUG."','ultimatum','default')";
	$wpdb->query($themesql);
	$themeid = $wpdb->insert_id;
	foreach($theme['layouts'] as $layout){
		if($layout['type']=='part'){
			$layoutsql = "INSERT INTO $ltable  (`title`,`type`,`theme`,`default`) VALUES ('$layout[name]','$layout[type]','$themeid','$layout[default]')";
			$wpdb->query($layoutsql);
			$layoutid = $wpdb->insert_id;
			$old_lay_id=$layout['oldid'];
			$partconv[$old_lay_id]='layout-'.$layoutid;
		} else {
			if($layout["default"]==1){
				//set this as theme css ;)
				$themeoptionname = THEME_SLUG.'_template_'.$themeid.'_css';
				update_option($themeoptionname,$layout['css']);
				// Create Custom CSS file
				if(strlen($layout['custom_css'])>0){
					update_option(THEME_SLUG.'_custom_template_css_'.$themeid,$layout['custom_css']);
				}
			}
			$new_parts_before=array();
			$lbefore='';
			if($layout['before']){
				$old_parts_before=explode(',',$layout['before']);
				foreach($old_parts_before as $p_b){
					$new_parts_before[]=$partconv[$p_b];
				}
				$lbefore = implode(',', $new_parts_before);
			}
			$new_parts_after=array();
			$lafter='';
			if($layout['after']){
				$old_parts_after=explode(',',$layout['after']);
				foreach($old_parts_after as $p_b){
					$new_parts_after[]=$partconv[$p_b];
				}
				$lafter = implode(',', $new_parts_after);
			}
			$layoutsql = "INSERT INTO $ltable  (`title`,`type`,`theme`,`default`,`before`,`after`) VALUES ('$layout[name]','$layout[type]','$themeid','$layout[default]','$lbefore','$lafter')";
			$wpdb->query($layoutsql);
			$layoutid = $wpdb->insert_id;
			if($_POST['assigners']=='assign'){
				if(count($layout['assigned'])!=0){
					foreach ($layout['assigned'] as $assignemnt){
						$query = "REPLACE INTO $atable VALUES ('".THEME_SLUG."','$assignemnt','$layoutid')";
						$wpdb->query($query);
					}
				}
			}
		}
		// Insert Layout CSS in WP Options and Generate file
		if($layout['type']=='full'){
			$optionname = THEME_SLUG.'_'.$layoutid.'_css';
			update_option($optionname,$layout['css']);
		// Create Custom CSS file
			if(strlen($layout['custom_css'])>0){
				update_option(THEME_SLUG.'_custom_css_'.$layoutid,$layout['custom_css']);
			}
		}
		// Do the ROWS
		$rows = $layout['rows'];
		foreach ($rows as $row){
			// Insert the row and get id
			$rowsql = "INSERT INTO $rtable (`layout_id`, `type_id`) VALUES ('$layoutid','$row[type]')";
			$wpdb->query($rowsql);
			$rowid = $wpdb->insert_id;
			$layoutrows[]='row-'.$rowid;
			// Insert row wrapper CSS
			$wrapper = 'wrapper-'.$rowid;
		foreach($row['wrapper'] as $element=>$property){
				if($element!='custom_classes'){
					$properties = serialize($property);
					$wrappersql = "INSERT INTO $ctable VALUES ('','$wrapper','$layoutid','$element','$properties')";
					$wpdb->query($wrappersql);
				} else {
					$properties = unserialize($property);
					if(count($properties)!=0):
					$classql = "REPLACE INTO $classtable (`container`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`,`layout_id`) VALUES ('$wrapper','".$properties["user_class"]."','".$properties["hidephone"]."','".$properties["hidetablet"]."','".$properties["hidedesktop"]."','$layoutid')";
					$wpdb->query($classql);
					endif;
				}
			}
			// Insert row container CSS
			$container = 'container-'.$rowid;
			foreach($row['container'] as $element=>$property){
				if($element!='custom_classes'){
					$properties = serialize($property);
					$containersql = "INSERT INTO $ctable VALUES ('','$container','$layoutid','$element','$properties')";
					$wpdb->query($containersql);
				} else {
					$properties = unserialize($property);
					if(count($properties)!=0):
					$classql = "REPLACE INTO $classtable (`container`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`,`layout_id`) VALUES ('$container','".$properties["user_class"]."','".$properties["hidephone"]."','".$properties["hidetablet"]."','".$properties["hidedesktop"]."','$layoutid')";
					$wpdb->query($classql);
					endif;
				}
			}
			// Insert row Column CSS
			foreach ($row['col'] as $colid=>$colcss){
				$column = 'col-'.$rowid.'-'.$colid;
				foreach ($colcss as $element=>$property){
					if($element!='custom_classes'){
						$properties = serialize($property);
						$colsql = "INSERT INTO $ctable VALUES ('','$column','$layoutid','$element','$properties')";
						$wpdb->query($colsql);
					} else {
						$properties = unserialize($property);
						if(is_array($properties)):
						$classql = "REPLACE INTO $classtable (`container`,`user_class`,`hidephone`,`hidetablet`,`hidedesktop`,`layout_id`) VALUES ('$column','".$properties["user_class"]."','".$properties["hidephone"]."','".$properties["hidetablet"]."','".$properties["hidedesktop"]."','$layoutid')";
						$wpdb->query($classql);
						endif;
					}
				}
			}
			//Import the widgets
			if(is_array($row['widgets'])){
			foreach($row["widgets"] as $sidebar=>$widgets){
				foreach($widgets as $widget) {
                    $option = $widget['widget_name'];
                    $id_base = $widget['id_base'];
                    // Better widget ID control
                    $nextidfromWP = ult_next_widget_id_number($widget['id_base']);
                    $nextid = ult_messed_widget_id($option, $nextidfromWP);
                    $warray = get_option($option);
                    unset($widget['widget_name']);
                    unset($widget['id_base']);
                    $warray[$nextid] = $widget;
                    update_option($option, $warray);
                    $ultimatum_sidebars_widgets = get_option('ultimatum_sidebars_widgets');
                    $ultimatum_sidebars_widgets['sidebar-' . $rowid . '-' . $sidebar][] = $id_base . '-' . $nextid;
                    update_option('ultimatum_sidebars_widgets', $ultimatum_sidebars_widgets);
                    unset($warray);
                }
			}
			}
			// Widget import Done :)
					
		}

			$rowss = implode(',', $layoutrows);
			unset($layoutrows);
		$layoutupdatesql = "UPDATE $ltable SET `rows`='$rowss' WHERE `id`='$layoutid'";
		$wpdb->query($layoutupdatesql);
	}// layouts foreach finish
	return $themeid;
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
function ultimatum_css_generator_fromimport($id,$echo=true){
	global $wpdb;

    $query = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='full' AND `theme`='$id'";
	$results = $wpdb->get_results($query);
	require_once (ULTIMATUM_ADMIN_HELPERS .DS. 'class.css.saver.php');
	WonderWorksCSS::saveCSS($id,'template');
	if($echo) echo '<li>Template css file(s) generated.</li>';
	foreach ($results as $result){
		WonderWorksCSS::saveCSS($result->id);
		if($echo) echo "<li>".$result->title.' css file(s) generated.</li>';
	}
}