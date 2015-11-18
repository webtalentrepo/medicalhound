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
require_once (ULTIMATUM_ADMIN_FUNCTIONS . '/template_import.php');
function importThemeForm(){
	if($_FILES){
		WP_Filesystem();
		move_uploaded_file($_FILES["template"]["tmp_name"], THEME_CACHE_DIR."/" . $_FILES["template"]["name"]);
		$nfile = THEME_CACHE_DIR."/" . $_FILES["template"]["name"];
		$folder = THEME_CACHE_DIR.'/'.str_replace('.zip', '', $_FILES["template"]["name"]);
		$unzipit = unzip_file($nfile, $folder);
		$files = WonderWorksHelper::getUTX($folder);
		if($files){
			foreach($files as $file){
				importTemplate($folder.DS.$file,$folder);
			}
		}	
	} else { 
?>
<h2><?php _e('Import a Template','ultimatum');?></h2>
<p></p>
<form action="" method="post"  enctype="multipart/form-data">
		<table class="widefat ult-tables">
			<tbody>
				<tr>
					<th><?php _e('File','ultimatum');?> :</th>
					<td><input type="file" name="template" /></td>
				</tr>
 				<tr class="alternate">
 					<th colspan="2"><?php _e('Options','ultimatum');?></th></tr>
 				<tr>
					<th><?php _e('Template Name','ultimatum');?> :</th>
					<td><input type="text" name="template_name" /><br />
					<?php _e('If you wish to have the imported template with a different name than its original type the name you desire','ultimatum');?></td>
				</tr>
				<tr>
					<th><?php _e('Import Assignments','ultimatum');?> :</th>
					<td>
						<select name="assigners">
						<option value="donot"><?php _e('Do not import layout assignments','ultimatum');?></option>
						<option value="assign"><?php _e('Import layout assignments','ultimatum');?></option>
						</select>
					<br />
					<?php _e('The imported template may have assignmets to post types categories etc. If you want those assignments to be imported set this option so.','ultimatum');?></td>
				</tr>
			</tbody>
		</table>
		<p><input type="submit" value="<?php _e('Import','ultimatum');?>" class="button button-primary"/></p>
</form>

<?php
	}
}