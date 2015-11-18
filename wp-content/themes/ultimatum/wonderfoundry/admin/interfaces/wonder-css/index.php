<?php

add_action('admin_enqueue_scripts','layouteditor_scripts');
add_action('admin_enqueue_scripts','layouteditor_styles');

function layouteditor_styles(){
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'wp-color-picker' );
}

function layouteditor_scripts(){
	global $wp_version;
	wp_enqueue_media();
	wp_enqueue_script('media-upload');
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'ultimatum-bootstrap',ULTIMATUM_ADMIN_ASSETS.'/js/admin.bootstrap.min.js' );
}
	

function cssDefaults(){

	global $theme_options;
	require_once ULTIMATUM_ADMIN_HELPERS.DS.'class.options.php';
	echo '<div class="wrap ultwrap">';
	global $wpdb;
	if(isset($_GET["layout_id"])){
		$fetch = getLayoutInfo($_GET["layout_id"]);
		
		$editing_now= $fetch->title;
		$defpage = "admin.php?page=wonder-css&layout_id=".$_GET["layout_id"];
	} elseif(isset($_GET["template_id"])){
		$fetch=getTemplateInfo($_GET["template_id"]);
		$editing_now= $fetch->name;
		$defpage = "admin.php?page=wonder-css&template_id=".$_GET["template_id"];
	}
	if(!$fetch){
		echo '<h2>No Templates / Layouts Selected</h2>';
		return;
	} else {
		// CSS Editors OFF function
		if($fetch->dcss=='yes'):
		?>
		<script type='text/javascript' src='<?php echo ULTIMATUM_ADMIN_ASSETS;?>/js/codemirror/lib/codemirror.js'></script>
		<script type='text/javascript' src='<?php echo ULTIMATUM_ADMIN_ASSETS;?>/js/codemirror/mode/css/css.js'></script>
		<link rel="stylesheet" media="screen" type="text/css" href="<?php echo ULTIMATUM_ADMIN_ASSETS;?>/js/codemirror/lib/codemirror.css" />
		<div class="ultadmnavi" style="position:absolute;top:0;width:100%;margin-right:25px;">
	 		<div class="navbar" id="ult-nav">
	 			<div class="navbar-inner">
	 				<a class="brand" href="<?php echo $defpage; ?>">&lt;CSS&gt;<?php echo $editing_now; ?></a>
	 				<ul class="nav">
	 					<li>
	 					<a href="javascript: history.go(-1)">Back</a>
	 					</li>
	 				</ul>
	 				<ul class="nav pull-right">
				 		<li class=""><button class="btn-info btn" id="setting-submit"><i class="fa fa-save"></i> Save Changes</button></li>
				 	</ul>
	 			</div>
	 		</div>
	 	</div>
	 	<?php
		if(isset($_REQUEST['layout_id'])){
			$layout_id = $_REQUEST['layout_id'];
			$cssfile = THEME_SLUG.'_custom_css_'.$layout_id;
		} elseif($_REQUEST['template_id']){
			$layout_id = $_REQUEST['template_id'];
			$cssfile = THEME_SLUG.'_custom_template_css_'.$layout_id;
		}
		
		if($_POST){
			update_option($cssfile,$_POST['custom_css']);
		}
		$css=get_option($cssfile);
		?>
		<form method="post" action="" id="css-editor-form">

		<textarea id="custom_css" name="custom_css">
		<?php echo $css; ?>
		</textarea>
		<input type="submit" class="btn btn-info" value="save"/>
		</form>
			<script type="text/javascript">
			    var editor = CodeMirror.fromTextArea(document.getElementById("custom_css"), {
			      mode: "text/css",
			  	  styleActiveLine: true,
				  lineNumbers: true,
				  lineWrapping: true}
				  );
			</script>
		<?php 
		else:
		if(isset($_GET['task'])):
		$task = $_GET['task'];
		$tbg = include_once ULTIMATUM_ADMIN_OPTIONS.DS.'css'.DS.$_GET['task'].'.php';
		else:
		$task = false;
		$tbg = include_once ULTIMATUM_ADMIN_OPTIONS.DS.'css-options.php';
		endif;
		
		?>
	<style>
	.wp-picker-holder{position:absolute;z-index:999}
	
	</style>
	<div class="ultadmnavi" style="position:absolute;top:0;width:100%;margin-right:25px;">
 		<div class="navbar" id="ult-nav">
 			<div class="navbar-inner">
 				<a class="brand" href="<?php echo $defpage; ?>">{CSS} <?php echo $editing_now; ?></a>
 				<ul class="nav">
 					<li <?php if(!$task) echo ' class="active"' ;?>>
 						<a href="<?php echo $defpage; ?>"><?php _e('Basics','ultimatum');?></a>
 					</li>
 					<li class="dropdown <?php if($task=="post" || $task=="comment"|| $task=="widget") {echo ' active' ;}?>" >
 						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Core WP','ultimatum');?><b class="caret"></b></a>
 						<ul class="dropdown-menu" role="menu" >
 							<li <?php if($task=="post") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=post'; ?>"><?php _e('Posts','ultimatum');?></a></li>
 							<li <?php if($task=="comment") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=comment'; ?>"><?php _e('Comments','ultimatum');?></a></li>
 							<li <?php if($task=="widget") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=widget'; ?>"><?php _e('Widgets','ultimatum');?></a></li>
 						</ul>
 					</li>
 					<li class="dropdown <?php if($task=="hm" ||$task=="mdm" ||$task=="ultimatum-menu" || $task=="hmm"|| $task=="hdm"|| $task=="vm"|| $task=="vmm"|| $task=="vdm") {echo ' active' ;}?>" >
 						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Menus','ultimatum');?><b class="caret"></b></a>
 						<ul class="dropdown-menu" role="menu" >
 							<li <?php if($task=="hm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=hm'; ?>"><?php _e('Horizontal','ultimatum');?></a></li>
 							<li <?php if($task=="hmm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=hmm'; ?>"><?php _e('Horizontal Mega','ultimatum');?></a></li>
 							<li <?php if($task=="hdm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=hdm'; ?>"><?php _e('Horizontal Dropdown','ultimatum');?></a></li>
 							<li <?php if($task=="vm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=vm'; ?>"><?php _e('Vertical','ultimatum');?></a></li>
 							<li <?php if($task=="vmm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=vmm'; ?>"><?php _e('Vertical Mega','ultimatum');?></a></li>
 							<li <?php if($task=="vdm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=vdm'; ?>"><?php _e('Vertical Dropdown','ultimatum');?></a></li>
 							<li <?php if($task=="ultimatum-menu") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=ultimatum-menu'; ?>"><?php _e('Ultimatum Menu','ultimatum');?></a></li>
                            <li <?php if($task=="mdm") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=mdm'; ?>"><?php _e('Mobile Menus','ultimatum');?></a></li>
 						</ul>
 					</li>
 					<li class="dropdown <?php if($task=="tabs" || $task=="togglers"|| $task=="accord"|| $task=="bcum"|| $task=="slides") {echo ' active' ;}?>" >
 						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Extras','ultimatum');?><b class="caret"></b></a>
 						<ul class="dropdown-menu" role="menu" >
 							<!-- <li <?php if($task=="bcum") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=bcum'; ?>"><?php _e('Breadcrumbs and Pagination','ultimatum');?></a></li> -->
 							<li <?php if($task=="tabs") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=tabs'; ?>"><?php _e('Tabs','ultimatum');?></a></li>
 							<li <?php if($task=="togglers") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=togglers'; ?>"><?php _e('Togglers','ultimatum');?></a></li>
 							<li <?php if($task=="accord") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=accord'; ?>"><?php _e('Accordions','ultimatum');?></a></li>
 							<li <?php if($task=="slides") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=slides'; ?>"><?php _e('Slideshows','ultimatum');?></a></li>
 						</ul>
 					</li>
 					<?php if(isset($_GET["layout_id"])){?>
 					<li class="dropdown">
 						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Custom CSS','ultimatum');?><b class="caret"></b></a>
 						<ul class="dropdown-menu" role="menu" >
 						<li><a href="./index.php?page=ultimatum-custom-css&template_id=<?php echo $fetch->theme;?>&TB_iframe=1&width=770&height=480" class="thickbox" title="<?php _e('Type your Custom CSS', 'ultimatum');?>"><?php _e('Template wide Custom CSS', 'ultimatum');?></a></li>
 						<li><a class="thickbox"  href="./index.php?page=ultimatum-custom-css&?layout_id=<?php echo $_GET["layout_id"];?>&TB_iframe=1&width=770&height=480" title="<?php _e('Type your Custom CSS', 'ultimatum');?>">
 						<?php _e('Layout Specific Custom CSS', 'ultimatum');?></a></li>
 						</ul>
 					</li>
 					<li>
 						<a href="<?php echo "admin.php?page=wonder-layout&task=edit&layoutid=".$_GET["layout_id"].'&theme='.$fetch->theme; ?>"><?php _e('Back To Layout Editor','ultimatum');?></a>
 					</li>
 					<?php } else { ?>
 					<li><a href="./index.php?page=ultimatum-custom-css&template_id=<?php echo $_GET["template_id"];?>&TB_iframe=1&width=770&height=480" class="thickbox" title="<?php _e('Type your Custom CSS', 'ultimatum');?>"><?php _e('Template wide Custom CSS', 'ultimatum');?></a></li>

 					<li>
 					<a href="javascript: history.go(-1)">Back</a>
 					</li>
 					<?php } ?>
 				</ul>
 				<ul class="nav pull-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Advanced','ultimatum');?><b class="caret"></b></a>
                        <ul class="dropdown-menu" role="menu" >
                            <li ><a  tabindex="-1" id="reset-form">Reset Section</a></li>
                        </ul>
                    </li>

					<li class=""><button class="button button-primary" id="setting-submit"><?php _e('Save Changes','ultimatum');?></button></li>
                </ul>
 			</div>
 		</div>
 	</div>
 	<?php if(!$task) { ?>
 	<?php
 	/* if(isset($_GET["layout_id"])){
 	<table class="widefat">
	<thead><tr><th><?php _e('Copy CSS From another Layout', 'ultimatum');?></th></tr></thead>
	<tbody>
	<tr valign="top"><td>
	<form method="post" action="admin.php?page=wonder-layout">
	<?php  _e('Copy CSS From', 'ultimatum');?> :
	<select name="source">

		$defql = "SELECT * FROM $table WHERE `type`='full' AND `id`<>'$_GET[layout]'";
		$lss = $wpdb->get_results($defql,ARRAY_A);
		if($lss){
			foreach($lss as $ls){
				echo '<option value="'.$ls[id].'">'.$ls[title].'</option>';
			}
		}

	</select>
	<input type="hidden" name="cloneid" value="<?php echo $_GET[layout];?>" />
	<input type="hidden" name="action" value="copycss" />
	<input type="submit" value="Clone CSS" class="button-primary" />
	</form></td></tr>
	</tbody>
	</table>
	<br />
	<?php } */ ?>
	<?php
	}
				$onur = new optionGenerator($tbg["name"], $tbg["options"]);?>
	<?php
	endif;
	}
	
	echo '</div>'; 
}
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}