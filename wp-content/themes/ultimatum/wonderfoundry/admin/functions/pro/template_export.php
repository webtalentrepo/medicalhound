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

add_action('ultimatum_template_menu_extras', 'ultimatum_template_menu_export',10,2);
function ultimatum_template_menu_export($defpage,$task){
 	if(CHILD_THEME): 
 	?>
	<a class="add-new-h2 thickbox" href="./index.php?page=ultimatum-export&task=theme&TB_iframe=1&width=770&height=480"><?php _e('Export Child Theme','ultimatum');?></a>
 	<?php 
 	endif;
 	?>
<?php 
}
function Ultimatum_Exporter(){
	$task = '';
	if(isset($_GET['task'])){
		$task = $_GET['task'];
	}
	switch ($task){
		default:
		break;
		case 'template':
			ultimatum_exportTemplate($_GET['template_id'],true);
		break;
		case 'theme':
			// Create utinstall folder
			$dir = THEME_DIR.DS.'ultinstall';
			if(is_dir($dir)){
				deleteDirectory($dir);
				}
			mkdir($dir);
			if(is_dir($dir)){
				global $wpdb;
				$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
				$sql = 'SELECT * FROM `'.$table.'` WHERE `theme`=\''.THEME_SLUG.'\'';
				$templates = $wpdb->get_results($sql,ARRAY_A);
				if($templates){
					foreach ($templates as $template){
						ultimatum_exportTemplate($template['id'],false);
					}
				}
			// Create the zip and show download link ;)
			$backuplister[]= THEME_DIR;
			$fontsoption = get_option(THEME_SLUG.'_fonts');
			if(count($fontsoption)!=0){
				$fontsoption = serialize($fontsoption);
				$file = $dir.'/'.THEME_SLUG.'.fonts';
				if(file_exists($file)){
					unlink($file);
				}
				$fhandle = @fopen($file, 'w+');
				if ($fhandle) fwrite($fhandle, $fontsoption, strlen($fontsoption));
			}
			require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
			$archive = new PclZip(THEME_CACHE_DIR.'/'.THEME_NAME.'.zip');
			$v_list = $archive->add($backuplister,PCLZIP_OPT_REMOVE_PATH, get_theme_root());
			?>
			<h2>Your File...</h2>
			<p>You have successfully Created your Export file you can download it via below link</p>
			<a href="<?php echo THEME_CACHE_URL; ?>/<?php echo THEME_NAME;?>.zip">Download File</a>
			<?php
			} else {
				echo 'Could not create folder needed in child teme directory.';
			}
			
		break;
	}
	
}
// Export a Theme
function ultimatum_exportTheme(){
	
}

// Export a Template
function ultimatum_exportTemplate($id,$download=false){
	// EXPORT Theme Details
	$creation_dir=THEME_CACHE_DIR;
	if(!$download){
		$creation_dir = THEME_DIR.DS.'ultinstall';
	}
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
	$ltable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$atable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout_assign';
	$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
	$classtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
	$ctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
	$extrarowtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
	$themesql = "SELECT * FROM $table WHERE `id`='$id'";
	$theme = $wpdb->get_row($themesql,ARRAY_A);
	$theme['ult_version']=2.5;
	//export extra rows
	$rxsql = "SELECT * FROM $extrarowtable WHERE `template_id`='$id'";
	$theme['extrarows'] = $wpdb->get_results($rxsql,ARRAY_A);
	$optionname = THEME_SLUG.'_template_'.$id.'_css';
	$theme['css']=(get_option($optionname));
	if(is_array($theme['css'])){
		foreach($theme['css'] as $option){
			if(isset($option['background-image']) && strlen($option['background-image'])>0){
				$images[]=$option['background-image'];
			}
		}
	}
	$custom_css= stripslashes(get_option(THEME_SLUG.'_custom_template_css_'.$id));
		if(strlen($custom_css)){
			$theme["custom_css"]=$custom_css;
		}
	// Export Layouts
	$lsql = "SELECT * FROM $ltable WHERE `theme`='$id' ORDER BY `type` DESC ";
	$layos = $wpdb->get_results($lsql,ARRAY_A);
	// Layout Details (name ,type)
	foreach($layos as $layo){
		$layout['name']=$layo['title'];
		$layout['type']=$layo['type'];
		$layout['default']=$layo['default'];
		$layout['oldid']=$layo['id'];
		$assingsql = "SELECT * FROM $atable WHERE `layout_id`='".$layo['id']."'";
		$assigneds = $wpdb->get_results($assingsql,ARRAY_A);
		if($assigneds){
			foreach($assigneds as $assigned){
				$layout['assigned'][]=$assigned['post_type'];
			}

		}
	
		// Layout Assignments

		// Layout CSS
		if($layo['type']=='full'){
            $optionsname = THEME_SLUG.'_'.$layo['id'].'_options';
            $layout['options']=(get_option($optionsname));
			$optionname = THEME_SLUG.'_'.$layo['id'].'_css';
			$layout['css']=(get_option($optionname));
			if(is_array($layout['css'])){
				foreach($layout['css'] as $option){
				if(isset($option['background-image']) && strlen($option['background-image'])>0){
					$images[]=$option['background-image'];
				}
			}
			}
			$custom_css= stripslashes(get_option(THEME_SLUG.'_custom_css_'.$layo['id']));
				if(strlen($custom_css)){
					$layout['custom_css']=$custom_css;		
				}

		}
		// Layout ROWS
		if($layo['type']=='full'){
		$layout['before']= row_exporter(explode(',',$layo['before']));
		$layout['after']= row_exporter(explode(',',$layo['after']));
		}
		$layout["rows"] = row_exporter(explode(',',$layo['rows']));
		
		$theme["layouts"][]=$layout;
		unset($layout);
	}
	if(count($images)!=0){
	$resimages = array_unique($images);
	foreach($resimages as $img){
		$image['name']=$img;
		$theme['images'][]=$image;
		$filename=$creation_dir.'/'.basename($img);
		$curl = curl_init($img);
		curl_setopt($curl, CURLOPT_HEADER, 0);  // ignore any headers
		ob_start();  // use output buffering so the contents don't get sent directly to the browser
		curl_exec($curl);  // get the file
		curl_close($curl);
		$content = ob_get_contents();  // save the contents of the file into $file
		ob_end_clean();  // turn output buffering back off
		$fhandle = @fopen($filename, 'w+');
		if ($fhandle) fwrite($fhandle, $content, strlen($content));
		$backuplist[]=$filename;
		unset($image);
	}}
	$content =base64_encode(serialize($theme));
	set_time_limit(0);
	$file = $creation_dir.'/'.str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $theme["name"])).'.utx';
	if(file_exists($file)){
		unlink($file);
	}
	$fhandle = @fopen($file, 'w+');
	if ($fhandle) fwrite($fhandle, $content, strlen($content));
if($download){
$backuplist[]=$file;
if(file_exists(THEME_CACHE_DIR.'/'.$theme["name"].'.zip')){
	unlink(THEME_CACHE_DIR.'/'.$theme["name"].'.zip');
}
require_once(ABSPATH . 'wp-admin/includes/class-pclzip.php');
$archive = new PclZip(THEME_CACHE_DIR.'/'.$theme["name"].'.zip');
$v_list = $archive->add($backuplist,	PCLZIP_OPT_REMOVE_PATH, THEME_CACHE_DIR);
	?>
<h2>Your File...</h2>
<p>You have successfully Created your Export file you can download it via below link</p>
<a href="<?php echo THEME_CACHE_URL; ?>/<?php echo $theme["name"]?>.zip">Download File</a>
<?php
}
}
function row_exporter($lrows){
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_templates';
$ltable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
$atable = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout_assign';
$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
$classtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
$ctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
foreach($lrows as $lrow){
	$mow = explode('-',$lrow);
	$row['type']=$mow[0];
	$row['oldid']=$mow[1];
	if($row['type']=='row'){
		$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
		$rsql = "SELECT * FROM $rtable WHERE `id`='".$row['oldid']."'";
		$rrow = $wpdb->get_row($rsql,ARRAY_A);
		if(preg_match('/_/i',$rrow['type_id'])){
			$converter = explode('_',$rrow['type_id']);
			$rrow['type_id'] = str_replace($converter[0],"{themeid}",$rrow['type_id']);
			$row['row_type']=$rrow['type_id'];
		} else {
			$row['row_type']=$rrow['type_id'];
		}
		// Do the widgets!!
		global $wp_registered_widgets, $wp_registered_widget_controls;
		$ultimatum_sidebars_widgets =get_option('ultimatum_sidebars_widgets', array());
		for($j=1;$j<=6;$j++){
			$oldw= 'col-'.$rrow['id'].'-'.$j;
			$olds= 'sidebar-'.$rrow['id'].'-'.$j;
			// 4- Widgets !!! next_widget_id_number
			if(count($ultimatum_sidebars_widgets[$olds])>=1){
				foreach ($ultimatum_sidebars_widgets[$olds] as $id){
					if(isset($wp_registered_widgets[$id])){
						$fwidget = $wp_registered_widgets[$id];
						$id_base = $wp_registered_widget_controls[$fwidget['id']]['id_base'];
						$currentwid = str_replace($id_base.'-', '', $fwidget[id]);
						$callback = $wp_registered_widgets[$id]['callback'][0];
						$option= $callback->option_name;
						$warray = get_option($option);
						$warray[$currentwid]['widget_name']=$option;
						$warray[$currentwid]['id_base']=$id_base;
						$row['widgets'][$j][]=$warray[$currentwid];;
						unset($warray);

					}
				}


			}
		}
			

		//End the widgets

		// Layout ROW CSS (wrapper, container ,column)
		// do the wrapper
		$wrapsql = "SELECT * FROM $ctable WHERE `container`='wrapper-".$rrow['id']."'";
		$xwrappers = $wpdb->get_results($wrapsql,ARRAY_A);
		$wrapsql = "SELECT * FROM $classtable WHERE `container`='wrapper-".$rrow['id']."'";
		$wrapper_class = $wpdb->get_row($wrapsql,ARRAY_A);
		$row['wrapper']['custom_classes']=serialize($wrapper_class);
		foreach($xwrappers as $xwrapper){
			$row['wrapper'][$xwrapper['element']]=unserialize($xwrapper['properties']);
			$tmp = unserialize($xwrapper['properties']);
			if(isset($tmp['background-image']) && strlen($tmp['background-image'])>0){
				$images[]=$tmp['background-image'];
			}
			unset($tmp);
		}
		//container
		$containersql = "SELECT * FROM $ctable WHERE `container`='container-".$rrow['id']."'";
		$xcontainers = $wpdb->get_results($containersql,ARRAY_A);
		$wrapsql = "SELECT * FROM $classtable WHERE `container`='container-".$rrow['id']."'";
		$wrapper_class = $wpdb->get_row($wrapsql,ARRAY_A);
		$row['container']['custom_classes']=serialize($wrapper_class);
		foreach($xcontainers as $xcontainer){
			$row['container'][$xcontainer['element']]=unserialize($xcontainer['properties']);
			$tmp = unserialize($xcontainer['properties']);
			if(isset($tmp['background-image']) && strlen($tmp['background-image'])>0){
				$images[]=$tmp['background-image'];
			}
			unset($tmp);
		}
		// Columns
		for($j=1;$j<=5;$j++){
			$colsql = "SELECT * FROM $ctable WHERE `container`='col-".$rrow['id']."-".$j."'";
			$colfetchs = $wpdb->get_results($colsql,ARRAY_A);
			$wrapsql = "SELECT * FROM $classtable WHERE `container`='col-".$rrow['id']."-".$j."'";
			$wrapper_class = $wpdb->get_row($wrapsql,ARRAY_A);
			$row['col'][$j]['custom_classes']=serialize($wrapper_class);
			foreach($colfetchs as $colfetch){
				$row['col'][$j][$colfetch['element']]=unserialize($colfetch['properties']);
				$tmp = unserialize($colfetch['properties']);
				if(isset($tmp['background-image']) && strlen($tmp['background-image'])>0){
					$images[]=$tmp['background-image'];
				}
				unset($tmp);
			}

		}
	}
	$row_export[]=$row;
	unset($row);
	}
	return $row_export;
}
//Theme exporter finish //


function deleteDirectory($dir) {
	if (!file_exists($dir)) return true;
	if (!is_dir($dir) || is_link($dir)) return unlink($dir);
	foreach (scandir($dir) as $item) {
		if ($item == '.' || $item == '..') continue;
		if (!deleteDirectory($dir . "/" . $item)) {
			chmod($dir . "/" . $item, 0777);
			if (!deleteDirectory($dir . "/" . $item)) return false;
		};
	}
	return rmdir($dir);
}