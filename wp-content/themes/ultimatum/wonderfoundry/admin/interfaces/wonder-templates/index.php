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
$task=false;
if(isset($_GET['task'])) $task = $_GET['task'];
if(!$task){
	add_action('admin_notices', 'ultimatum_default_template_nag');
}

function ultimatum_templates_help() {
	$file = ULTIMATUM_ADMIN_HELP.'/templates.php';
	include($file);
	foreach ( $help['tabs'] as $id => $data )
	{
		get_current_screen()->add_help_tab( array(
		'id'       => $id
		,'title'    =>  $data['title']
		,'content'  =>  $data['content']

		) );
	}
	get_current_screen()->set_help_sidebar($help["sidebar"]);

}

add_action('contextual_help', 'ultimatum_templates_help', 10);
add_action('admin_enqueue_scripts','udefaultscreen_scripts');
add_action('admin_enqueue_scripts','udefaultscreen_styles');
function udefaultscreen_styles(){
	wp_enqueue_style('thickbox');
	wp_enqueue_script('jquery-ui-slider');
}
function udefaultscreen_scripts(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('ultimatum-templates',ULTIMATUM_ADMIN_ASSETS.'/js/interface-templates.js');
}
	
require_once (ULTIMATUM_ADMIN_HELPERS .DS. 'class.css.saver.php');	
require_once (ULTIMATUM_ADMIN.DS.'interfaces'.DS.'wonder-templates'.DS.'edit-template.php');
require_once (ULTIMATUM_ADMIN.DS.'interfaces'.DS.'wonder-templates'.DS.'import-template.php');
//require_once (ULTIMATUM_ADMIN.DS.'interfaces'.DS.'wonder-templates'.DS.'delete-template.php');
function ultimatum_themes(){
	
	echo '<div class="wrap">';

	$task=false;
	if(isset($_GET['task'])) $task = $_GET['task'];
	switch ($task){ //
		default:
		    if($_POST){
		        global $wpdb;
		        if(isset($_POST['id'])){
		            if($_POST['gridwork']!="tbs3"){
		                $query = "REPLACE INTO `".ULTIMATUM_TABLE_TEMPLATES."` VALUES ('".$_POST['id']."','".$_POST['name']."','".$_POST['width']."','".$_POST['margin']."','".$_POST['mwidth']."','".$_POST['mmargin']."','".$_POST['swidth']."','".$_POST['smargin']."','".$_POST['gridwork']."','".$_POST['swatch']."','".$_POST['type']."','".$_POST['dcss']."','".$_POST['default']."','".$_POST['theme']."','".$_POST['cdn']."')";
		            } else {
		               $query = "REPLACE INTO `".ULTIMATUM_TABLE_TEMPLATES."` VALUES ('".$_POST['id']."','".$_POST['name']."','".$_POST['width']."','".$_POST['margin']."','".$_POST['mwidth']."','".$_POST['mmargin']."','".$_POST['swidth']."','".$_POST['smargin']."','".$_POST['gridwork']."','".$_POST['swatch3']."','".$_POST['type']."','".$_POST['dcss']."','".$_POST['default']."','".$_POST['theme']."','".$_POST['cdn']."')";
		            }
		        } else {
		            if($_POST['gridwork']!="tbs3"){
		                $query = "INSERT INTO `".ULTIMATUM_TABLE_TEMPLATES."` (`name`,`width`,`margin`,`mwidth`,`mmargin`,`swidth`,`smargin`,`gridwork`,`swatch`,`type`,`dcss`,`default`,`theme`) VALUES ('".$_POST['name']."','".$_POST['width']."','".$_POST['margin']."','".$_POST['mwidth']."','".$_POST['mmargin']."','".$_POST['swidth']."','".$_POST['smargin']."','".$_POST['gridwork']."','".$_POST['swatch']."','".$_POST['type']."','".$_POST['dcss']."','".$_POST['default']."','".$_POST['theme']."','".$_POST['cdn']."')";
		            } else {
		                $query = "INSERT INTO `".ULTIMATUM_TABLE_TEMPLATES."` (`name`,`width`,`margin`,`mwidth`,`mmargin`,`swidth`,`smargin`,`gridwork`,`swatch`,`type`,`dcss`,`default`,`theme`) VALUES ('".$_POST['name']."','".$_POST['width']."','".$_POST['margin']."','".$_POST['mwidth']."','".$_POST['mmargin']."','".$_POST['swidth']."','".$_POST['smargin']."','".$_POST['gridwork']."','".$_POST['swatch3']."','".$_POST['type']."','".$_POST['dcss']."','".$_POST['default']."','".$_POST['theme']."','".$_POST['cdn']."')";
		            }
		        }
		    
		        $wpdb->query($query);
		        $template_id =  $wpdb->insert_id;
		        WonderWorksCSS::saveCSS($template_id,'template');
		        ?>
		        <script type="text/javascript">
		        parent.location.href='./admin.php?page=wonder-templates';
		        </script>
		        <?php 
		    }
			themesMainScreen();
		break;
		case 'createChild':
			createChild();
		break;
		case 'deletetemplate':
			deleteTheme();
		break;
		case 'export':
			Ultimatum_Exporter();
		break;
		case 'import':
			importThemeForm();
		break;
		case 'row-edit':
			RowEditor();
			break;
		case 'row-styles':
			RowStyles();
		break;
		case 'edit':
			$template=null;
			if(isset($_REQUEST["template_id"])) $template = getTemplateInfo($_REQUEST["template_id"]);
			ultimatum_editTemplate($template);
		break;
		case 'default':
			makeDefault();
		break;
		case 'mobileass':
			mobileAssign();
		break;
	}
	echo '</div>'; 
	}
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}
function ultimatum_default_template_nag(){
$msg=false;
$defaults = getDefaultTempLateandLayout();
//print_r($defaults);
if(!isset($defaults->tname)){
$msg = __('WARNING YOU DONT SEEM TO HAVE A DEFAULT TEMPLATE OR YOU MISS A DEFAULT LAYOUT','ultimatum'); 
} elseif(!isset($defaults->title)){
$msg = __('WARNING YOU DONT SEEM TO HAVE A DEFAULT LAYOUT','ultimatum');
}
			
if($msg){ echo "<div class='error'><p>$msg</p></div>"; }
}
function themesMainScreen(){
    $task=false;
    if(isset($_GET['task'])) $task = $_GET['task'];
	$templates = getAllTemplates();
	$defpage = './admin.php?page=wonder-templates';
	?>
	<h2>
		<?php _e('Templates','ultimatum'); ?>
		<a href="<?php echo $defpage.'&task=edit'; ?>" class="add-new-h2"><?php _e('Add New', 'ultimatum');?></a>
		<a href="<?php echo $defpage.'&task=import'; ?>" class="add-new-h2"><?php _e('Import a Template','ultimatum');?></a>
		<?php 
				if(!CHILD_THEME && (is_multisite() && is_super_admin()) || (!is_multisite())){
			 	?>
			 	<a class="add-new-h2" href="<?php echo $defpage.'&task=createChild'; ?>"><?php _e('Create Child Theme', 'ultimatum');?></a>
			 	<?php } ?>
		<?php do_action('ultimatum_template_menu_extras',$defpage,$task); ?>
		
	</h2>
	<table class="widefat ult-tables">
    <thead>
        <tr>
            <th scope="col" class="manage-column column-name" style=""><?php _e('Template', 'ultimatum'); ?></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
 		<tbody>
		<?php 
		$count = 1;
		$class = '';
		foreach($templates as $template){
			$class = ( $count % 2 == 0 ) ? '' : ' class="alternate"';
			if($template->default==1){ $class =' class="active"';}
			echo '<tr'.$class.'>';	
				echo '<th>';
					echo '<a href="./admin.php?page=wonder-layout&theme='.$template->id.'">'.$template->name.'</a>';
					if($template->type == 1){
						echo ' <small>responsive</small>';
					}
					if($template->type == 2){
						echo ' <small>mobile</small>';
					}
						
					
				echo '<div class="row-actions templateactions">';
				echo '<a href="./admin.php?page=wonder-templates&task=edit&template_id='.$template->id.'" class=""><i class="fa fa-edit"></i> '.__('Edit','ultimatum').'</a>  |  ';
						if($template->default!=1){
							echo '<a href="#" class="defaulttemplate" data-id="'.$template->id.'"><i class="fa fa-cogs"></i> '.__('Set Default','ultimatum').'</a>  |  ';
						}
						if(function_exists('Ultimatum_Exporter')){
							echo '<a href="./index.php?page=ultimatum-export&task=template&template_id='.$template->id.'&TB_iframe=1&width=770&height=480" class="thickbox"><i class="fa fa-cloud-download"></i> '.__('Export','ultimatum').'</a>  |  ';
						}
						echo '<a href="#" class="deletetemplate" data-id="'.$template->id.'" ><i class="fa fa-trash"></i> Delete</a>  |  ';
						
						echo '<a href="./admin.php?page=wonder-templates&task=row-styles&template_id='.$template->id.'" class=""><i class="fa fa-th-large"></i> '.__('Extra Row Styles','ultimatum').'</a>  |  ';
						echo '<a class="thickbox" href="./index.php?page=ultimatum-css-regen&theme='.$template->id.'&TB_iframe=1&width=640&height=380" title="'.__('Regenerate CSS','ultimatum').'">'.__('Regenerate CSS','ultimatum').'</a>';
					echo '</div>';
				echo'</th>';echo '<td>';
				echo '<a href="./admin.php?page=wonder-css&template_id='.$template->id.'" class=""><i class="fa fa-cogs"></i> '.__('CSS','ultimatum').'</a>';
				echo'</td>';echo '<td>';
				echo '<a href="./admin.php?page=wonder-layout&theme='.$template->id.'" class=""><i class="fa fa-desktop"></i> '.__('Layouts','ultimatum').'</a>';
				echo'</td>';
			echo '</tr>';
			$count++;
		}
		?>
		</tbody>
    
	</table>
<?php  
}
function RowStyles(){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
	$sql = "SELECT * from $table WHERE `template_id`='".$_GET['template_id']."'";
	$extrarows = $wpdb->get_results($sql);
	?>
	<p>
	<a href="./admin.php?page=wonder-templates&task=row-edit&template_id=<?php echo $_GET['template_id'];?>" class="btn btn-info" style="text-decoration: none">Create New Row Style</a>
	</p>
	<table class="table table-bordered">
		<thead>
			<tr>
				<th><?php _e('Extra Row Styles Created','ultimatum');?></th>
				<th><?php _e('Column Count','ultimatum');?></th>
				<th><?php _e('Grid','ultimatum');?></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
		<?php 
			foreach ($extrarows as $extrarow){
			?>
			<tr>
			<td>
			<?php echo $extrarow->name; ?>
			</td>
			<td>
			<?php echo count(explode(',',$extrarow->grid)); ?>
			</td>
			<td>
			<?php echo $extrarow->grid; ?>
			</td>
			<td><a class="btn btn-small" href="./admin.php?page=wonder-templates&task=row-edit&template_id=<?php echo $_GET['template_id'];?>&slug=<?php echo $extrarow->slug;?>"><i class="fa fa-edit"></i>Edit</a>
			</tr>
			<?php 
			}
		?>
		</tbody>
	</table>
<?php 	
}
function RowEditor(){
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
$slug = '';
$col_count = '';
$row_positions = '';
$row_positions_insert = '';
$amount=0;
$col_selector=true;
if(isset($_GET['template_id']) && isset($_GET['slug'])):
$sql = "SELECT * from $table WHERE `template_id`='".$_GET['template_id']."' AND `slug`= '".$_GET['slug']."'";
$extrarow = $wpdb->get_row($sql);
if(count($extrarow)!=0):
$name = $extrarow->name;
$slug = $extrarow->slug;
$col_count = count(explode(',',$extrarow->grid));
$row_positions = str_replace(',','',$extrarow->grid);
$row_positions_insert =  $extrarow->grid;
$amount =  $extrarow->amount;
$col_selector=false;
endif;
endif;// get if end
if($_POST['row_name']){
	if(strlen($_POST['slug'])>>0){
		$slug = $_POST['slug'];
	} else {
		$slug = strtolower(str_replace(' ','-',preg_replace("/[^A-Za-z0-9 ]/", '', $_POST['row_name'])));
	}
	$sql = "REPLACE INTO `".$table."` VALUES ('".$_POST['template_id']."','".$_POST['row_name']."','".$slug."','".$_POST['row_positions_insert']."','".$_POST['amount']."')";
	$wpdb->query($sql);
	?>
	<script type="text/javascript">
	parent.location.href='./admin.php?page=wonder-templates&task=row-styles&template_id=<?php echo $_GET['template_id'];?>';
	</script>
	<?php 
}
?>

<link rel='stylesheet' href='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/smoothness/jquery-ui.css' />
<form method="post" action="">
Row Name : <input name="row_name" type="text" value="<?php echo $name;?>" />
<?php if($col_selector) { ?>
<div class="position-count">
Column Count : 
<a class="type-selector" data-value="2">2</a>
<a class="type-selector" data-value="3">3</a>
<a class="type-selector" data-value="4">4</a>
<a class="type-selector" data-value="5">5</a>
<a class="type-selector" data-value="6">6</a>
</div>
<?php } ?>
<div class="mini-container">
<div id="g-p-0" class="mini-grid-00">a</div>
<div id="g-p-1" class="mini-grid-00">b</div>
<div id="g-p-2" class="mini-grid-00">c</div>
<div id="g-p-3" class="mini-grid-00">d</div>
<div id="g-p-4" class="mini-grid-00">e</div>
<div id="g-p-5" class="mini-grid-00">f</div>
</div>
<p></p>
<div id="something"></div>
<p></p>
<input type="hidden" name="template_id"  value="<?php echo $_GET['template_id'];?>" />
<input type="hidden" name="slug"  value="<?php echo $slug;?>" />
<input type="hidden" id="amount" name="amount" value="<?php echo $amount;?>" />
<input type="hidden" name="col_count" id="col_count" value="<?php echo $col_count;?>" />
<input type="hidden" name="row_positions" id="row_positions" value="<?php echo $row_positions;?>" />
<input type="hidden" name="row_positions_insert" id="row_positions_insert" value="<?php echo $row_positions_insert;?>" />
<input class="button button-primary" type="submit" value="<?php _e('Save','ultimatum');?>" />
</form>
<script>
var rowDivisions ={'1': ['f'],'2': ['2o', '39', '48', '57', '66', '75', '84', '93', 'o2'],'3': ['228', '237', '246', '255', '264', '273', '282', '327', '336', '345', '354', '363', '372', '426', '435', '444', '453', '462', '525', '534', '543', '552', '624', '633', '642', '723', '732', '822'],'4': ['2226', '2235', '2244', '2253', '2262', '2325', '2334', '2343', '2352', '2424', '2433', '2442', '2523', '2532', '2622', '3225', '3234', '3243', '3252', '3324', '3333', '3342', '3423', '3432', '3522', '4224', '4233', '4242', '4323', '4332', '4422', '5223', '5232', '5322', '6222'],'5': ['22224', '22233', '22242', '22323', '22332', '22422', '23223', '23232', '23322', '24222', '32223', '32232', '32322', '33222', '42222'],'6': ['222222']};
function rConverter(){
	var classes = new Array();
	var inputted = jQuery('#row_positions').val();
	var onur = inputted.length;
	jQuery('.mini-container div').attr('class','mini-grid-00');
	for ( var i = 0; i < onur; i++ ) {
		classes[i] = inputted.charAt(i);
		if(classes[i]=="f"){
			classes[i]=12;
		}
		if(classes[i]=="o"){
			classes[i]=10;
		}
		var clazz = 'mini-grid-'+classes[i];
		var width = Math.floor(((classes[i]/12)*100))+'%';
		jQuery('#g-p-'+i).attr("class",clazz);
		jQuery('#g-p-'+i).html(width);
	}
	var result = classes.join();
	jQuery('#row_positions_insert').val(result);
}
<?php if (!$col_selector) { ?>
jQuery( document ).ready(function() {
var type = jQuery('#col_count').val()
var layos = rowDivisions[type];
var count = jQuery(layos).length;
rConverter();
var slide = jQuery("#something").slider({
	range: "max",
	min :0,
	max: (count-1),
	value:<?php echo $amount;?>,
	slide: function( event, ui ) {
		jQuery( "#amount" ).val( ui.value );
		jQuery( "#row_positions" ).val(layos[ui.value] );
		rConverter();

	}
});

});
<?php } else { ?>
jQuery(".type-selector").click(function () {
	var type = jQuery(this).attr('data-value');
	jQuery('#col_count').val(type);
	var layos = rowDivisions[type];
	jQuery('#row_positions').val(layos[0]);
	var count = jQuery(layos).length;
	jQuery( "#amount" ).val(0);
	rConverter();
	var slide = jQuery("#something").slider({
		range: "max",
		min :0,
		max: (count-1),
		value:0,
		slide: function( event, ui ) {
			jQuery( "#amount" ).val( ui.value );
			jQuery( "#row_positions" ).val(layos[ui.value] );
			rConverter(type,layos[ui.value]);

		}
	});

});
<?php } ?>	 
	 
	</script>
	<?php 
}

function createChild(){
	global $wpdb;
	$theme_root =  get_theme_root();
 	if(!$_POST):
 	// Check if we can write the folders
  	$theme_root =  get_theme_root();
 	if(is_writable($theme_root)):
	 	?>
	 	<form action="" method="post"  enctype="multipart/form-data">
	 	<table class="table table-bordered">
			<thead>
			<tr class="info">
			<td colspan="3"><h3><?php _e('Create a Child Theme','ultimatum');?></h3></td>
			</thead>
			<tfoot>
			<tr>
				<th colspan="3">
					<button class="btn btn-info"><i class="fa fa-save"></i> <?php _e('Save','ultimatum');?></button>
				</th>
			</tr>
			</tfoot>
			<tbody>
			<tr>
				<td width="200"><?php _e('Child Theme Name','ultimatum'); ?>: </td>
				<td width="200"><input type="text" name="name" value="" /></td>
				<td><?php _e('Name for your Child Theme it can be anything you want. Eg. My Cool Theme','ultimatum');?></td>
			</tr>

			<tr>
					<th><?php _e('Child Theme Image','ultimatum');?> :</th>
					<td><input type="file" name="childimage" /></td>
					<td><?php _e('The ScreenShot image which will be shon in Themes Screen. Must be a png file!!','ultimatum');?></td>
				</tr>
			<tr>
				<td><?php _e('Select Templates you want to move to the new child theme','ultimatum');?></td>
				<td>
				<?php 
					$query = "SELECT * FROM `".ULTIMATUM_TABLE_TEMPLATES."` WHERE `theme`='ultimatum'";
					$templates = $wpdb->get_results($query);
					if(isset($templates) && count($templates)!=0){
						foreach ($templates as $temp){
							echo '<input type="checkbox" name="templates[]" value="'.$temp->id.'" /> '.$temp->name.'<br />';
						}
					}		
				?>
				</td>
				<td><?php _e('If non selected an empty child theme with no layouts will be created','ultimatum');?></td>
			</tr>
			
			
			</tbody>
		</table>
	 	</form>
	 	<?php 
	 	
	else:
		_e('Sorry your themes folder is not writable you cannot use this function until you set permissions.','ultimatum');
 	endif;
	
 	else:
 	// create the folder
 	$themedir = $theme_root.DS.sanitize_title($_POST['name']);
	mkdir($themedir);
	WP_Filesystem();
    //    print_r($_FILES['childimage']);
	if(!empty($_FILES["childimage"]['name'])){
      //  echo 'onur2';
        move_uploaded_file($_FILES["childimage"]["tmp_name"], $themedir."/screenshot.png");
    } else {
        $current_file   = ULTIMATUM_DIR.'/screenshot-child.png';
        $target_file    = $themedir.'/screenshot.png';
        //echo 'onur';
        copy($current_file,$target_file);
    }
 	// create the style.css
$stylecss = <<<CSS
/*
Theme Name:     {$_POST['name']}
Description:    Child theme for Ultimatum
Author:         Ultimatum Theme
Template:       ultimatum
Version:        0.1.0
*/
CSS;
$cfile = $themedir.DS.'style.css';
$fhandler = @fopen($cfile, 'w+');
if($fhandler){ fwrite($fhandler, $stylecss, strlen($stylecss));} 	
 	// create the functions.php
$functionsphp = <<<PHP
<?php
/*
 * Simple Child Theme generated by Ultimatum Framework
*/

PHP;

$ffile = $themedir.DS.'functions.php';
$fhandler = @fopen($ffile, 'w+');
if($fhandler){ fwrite($fhandler, $functionsphp, strlen($functionsphp));}	
 	if(isset($_POST['templates'])):
 	foreach($_POST['templates'] as $tmplt){
		$quer = "UPDATE `".ULTIMATUM_TABLE_TEMPLATES."` SET `theme`='".sanitize_title($_POST['name'])."' WHERE `id`='$tmplt'";
		$wpdb->query($quer);
        $oldtheme_css_option = get_option('ultimatum_template_'.$tmplt.'_css',false);
        if($oldtheme_css_option){
            update_option(sanitize_title($_POST['name']).'_template_'.$tmplt.'_css',$oldtheme_css_option);
        }
        // Custom CSS
        $tmp_custom_css = get_option('ultimatum_custom_template_css_'.$tmplt,false);
        if($tmp_custom_css){
            update_option(sanitize_title($_POST['name']).'_custom_template_css_'.$tmplt,$tmp_custom_css);
        }

		$qury = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='full' AND `theme`='".$tmplt."'";
		$results = $wpdb->get_results($qury);
		require_once (ULTIMATUM_ADMIN_HELPERS .DS. 'class.css.saver.php');
		WonderWorksCSS::saveCSS($tmplt,'template');
		foreach ($results as $result){
            $oldtheme_css_option = get_option('ultimatum_'.$result->id.'_css',false);
            if($oldtheme_css_option){
                update_option(sanitize_title($_POST['name']).'_'.$result->id.'_css',$oldtheme_css_option);
            }
            // Custom CSS
            $tmp_custom_css = get_option('ultimatum_custom_css_'.$result->id,false);
            if($tmp_custom_css){
                update_option(sanitize_title($_POST['name']).'_custom_css_'.$result->id,$tmp_custom_css);
            }
			WonderWorksCSS::saveCSS($result->id);


		}
	}
 	endif;
 	// all done tell user the good news and show a link to themes page to get the theme activated.
 	_e('Your Child theme is created you can now go to <a href="./themes.php">Themes</a> screen and activate it','ultimatum');
 	endif;
}



	
