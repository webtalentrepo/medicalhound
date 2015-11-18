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
 
add_action('init','ult_CssGen_Scripts');
function ult_CssGen_Scripts(){
	if(is_admin())
		return;
	if(current_user_can('manage_options')){
		wp_enqueue_script('ult-css-gen',ULTIMATUM_PLUGINS_URL.'/frontend-css/js/ult-css.js','jquery','1.0',true);
		wp_enqueue_script('codemirror',ULTIMATUM_ADMIN_ASSETS.'/js/codemirror/lib/codemirror.js','jquery','1.0',false);
		wp_enqueue_script('codemirror-css',ULTIMATUM_ADMIN_ASSETS.'/js/codemirror/mode/css/css.js','jquery','1.0',false);
		wp_enqueue_style('ult-css-gen',ULTIMATUM_PLUGINS_URL.'/frontend-css/css/ult-css.css');
		wp_enqueue_style('codemirror',ULTIMATUM_ADMIN_ASSETS.'/js/codemirror/lib/codemirror.css');
	}
}
if (!is_admin() && current_user_can('manage_options')) {
	add_action('wp_footer','ultimatum_css_customizer_html');
	add_action('ultimatum_after_body_open','custom_css_containers',20);
}
function custom_css_containers(){
	global $ultimatumlayout;
	$layout_id = $ultimatumlayout->id;
	$cssfile_layout = THEME_SLUG.'_custom_css_'.$layout_id;
	$layout_id = $ultimatumlayout->theme;
	$cssfile = THEME_SLUG.'_custom_template_css_'.$layout_id;
	if(isset($_POST['custom-css-saver'])){
		$file = THEME_CACHE_DIR.'/template_custom_'.$ultimatumlayout->theme.'.css';
		$file2 = THEME_CACHE_DIR.'/layout_custom_'.$ultimatumlayout->id.'.css';
		if(file_exists($file)){unlink($file);}
		if(file_exists($file2)){unlink($file2);}
        delete_option($cssfile);
        delete_option($cssfile_layout);
		if(strlen($_POST['custom_css_theme'])!=0){
			update_option($cssfile,$_POST['custom_css_theme']);
			$fhandle = @fopen($file, 'w+');
			if ($fhandle) fwrite($fhandle, stripslashes($_POST['custom_css_theme']), strlen(stripslashes($_POST['custom_css_theme'])));
		}
		if(strlen($_POST['custom_css'])!=0){
			update_option($cssfile_layout,$_POST['custom_css']);
			$fhandle2 = @fopen($file2, 'w+');
			if ($fhandle2) fwrite($fhandle2, stripslashes($_POST['custom_css']), strlen(stripslashes($_POST['custom_css'])));
		}
	}
	$css_layout=stripslashes(get_option($cssfile_layout));
	$css=stripslashes(get_option($cssfile));
	echo '<style id="custom_css_theme_style">'.$css.'</style>';
	echo '<style id="custom_css_layout_style">'.$css_layout.'</style>';
}
function ultimatum_css_customizer_html(){
	global $ultimatumlayout;
	$layout_id = $ultimatumlayout->id;
	$cssfile_layout = THEME_SLUG.'_custom_css_'.$layout_id;
	$layout_id = $ultimatumlayout->theme;
	$cssfile = THEME_SLUG.'_custom_template_css_'.$layout_id;
	$css_layout=stripslashes(get_option($cssfile_layout));
	$css=stripslashes(get_option($cssfile));
	$html = <<<HTML
<form id="ultimatum-custom-css-form" method="post" action="">
<div class="ultimatum-css-customizer">
<div class="ultimatum-css-customizer-inner">
<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#twide" data-toggle="tab">Template Wide CSS</a></li>
  <li><a href="#lspecific" data-toggle="tab" id="lspec-click">Layout Specific CSS</a></li>
 <li><a href="#" id="css-gen-save">Save</a></li>
  <li><a href="#" id="css-gen-close">Close</a></li>
</ul>
 
<div class="tab-content">
  <div class="tab-pane active" id="twide"><textarea id="custom_css_theme" name="custom_css_theme" style="width:100%;height:100%;">{$css}</textarea></div>
  <div class="tab-pane" id="lspecific"><textarea id="custom_css" name="custom_css" style="width:100%;height:100%;">{$css_layout}</textarea></div>
 
</div>
</div>
<input type="hidden" name="custom-css-saver" value="yes" /> 
</div>
</form>
HTML;
	echo $html;
}