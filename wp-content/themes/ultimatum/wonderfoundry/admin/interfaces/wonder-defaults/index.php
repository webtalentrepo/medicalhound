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
function wonderworks_default(){
  	theGeneralSettings();
}
function ultimatum_library_help() {
	$file = ULTIMATUM_ADMIN_HELP.'/settings.php';
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

add_action('contextual_help', 'ultimatum_library_help', 10);
function theGeneralSettings(){
	global $theme_options;
	$defpage = 'admin.php?page='.THEME_SLUG;
	include_once ULTIMATUM_ADMIN_HELPERS.'/class.options.php';
	echo '<div class="wrap ultwrap">';
	$tbg = array();
	if(isset($_GET['task'])):
		$task = $_GET['task']; 
		if(file_exists(ULTIMATUM_ADMIN_OPTIONS.'/'.$_GET['task'].'-options.php')){
 			$tbg = include_once ULTIMATUM_ADMIN_OPTIONS.'/'.$_GET['task'].'-options.php';
		}
 		$tbg = apply_filters('ultimatum_settings_filter', $tbg);
 	else:
 		$task = false;
 		$tbg = include_once ULTIMATUM_ADMIN_OPTIONS.'/theme-defaults.php';
 	endif;
	$onur = new optionGenerator($tbg["name"], $tbg["options"]);?>
	
	<div class="ultadmnavi" style="position:absolute;top:0;width:100%;margin-right:25px;">
 	<div class="navbar" id="ult-nav">
 	<div class="navbar-inner">
 	<a class="brand" href="<?php echo $defpage; ?>"><?php _e('Theme Settings','ultimatum');?></a>
 	<ul class="nav">
 	<li <?php if(!$task) echo ' class="active"' ;?>><a href="<?php echo $defpage; ?>"><?php _e('General Settings','ultimatum');?></a></li>
 	<li><a href="<?php echo $defpage.'&task=sidebar'; ?>"><?php _e('Sidebar Settings','ultimatum');?></a></li>
 	<?php if(get_ultimatum_option('extras', 'ultimatum_seo')){?>
 	<li ><a href="<?php echo $defpage.'&task=seo'; ?>"><?php _e('SEO Settings','ultimatum');?></a></li>
 	<?php } ?>
 	<li class="dropdown <?php if($task=="extra" || $task=="woo"|| $task=="dev"|| $task=="mobapp"|| $task=="script"|| $task=="tag") {echo ' active' ;}?>" >
 	<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Advanced Settings','ultimatum');?><b class="caret"></b></a>
 	<ul class="dropdown-menu" role="menu" >
  	<li <?php if($task=="extra") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=extra'; ?>"><?php _e('Extras Settings','ultimatum');?></a></li>
 	<li <?php if($task=="script") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=script'; ?>"><?php _e('Script & API Settings','ultimatum');?></a></li>
 	<li <?php if($task=="tag") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=tag'; ?>"><?php _e('Tag Settings','ultimatum');?></a></li>
 	<?php if(get_ultimatum_option('extras', 'ultimatum_postgals')) { ?>
 	<li <?php if($task=="pgallery") echo ' class="active"' ;?>><a tabindex="-1" href="<?php echo $defpage.'&task=pgallery'; ?>"><?php _e('Post Galleries','ultimatum');?></a></li>
 	<?php } ?>
 	<?php 
 	if(function_exists('devsettings')){
 		devsettings($defpage,$task);
 		
 	}
 	?>
 	</ul>
 	</li>
 	<?php 
 	// Add The Connect Menu
 	$connect = array();
 	$connect = apply_filters('ultimatum_connect_menu', $connect);
 	if(count($connect)!=0){
		foreach($connect as $name => $connecttask){
			$connecttasks[] = $connecttask;
			$connectitems .='<li><a tabindex="-1" href="'.$defpage.'&task='.$connecttask.'">'.$name.'</a></li>';	
		}
		?>
		<li class="dropdown <?php if(in_array($task, $connecttasks)) {echo ' active' ;}?>" >
 		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Connect','ultimatum');?><b class="caret"></b></a>
 		<ul class="dropdown-menu" role="menu" >
 		<?php echo $connectitems; ?>
 		</ul>
 		</li>
		<?php
 	}
 	?>
 	</ul>
 	<ul class="nav pull-right">
 	<li class=""><button class="btn-info btn" id="setting-submit"><i class="fa fa-save"></i> Save Changes</button></li>
 	</ul>
 	
 	
 	</div>
 	</div>
 	</div>
	<?php
	echo '</div>'; 
}