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

add_action('ultimatum_template_menu_extras', 'ultimatum_template_menu_mobile',10,2);
function ultimatum_template_menu_mobile($defpage,$task){
	global $wpdb;
	$prefix = $wpdb->prefix;
	if(get_option('ult_mobile_table')!='DONE'):
	
	$mobileinsert = "INSERT INTO `".$prefix.ULTIMATUM_PREFIX."_mobile` (`id`, `device`, `theme`) VALUES (1, 'iPhone', 0), (2, 'iPad', 0), (3, 'iPod', 0), (4, 'Android', 0), (5, 'AndroidTablet', 0), (6, 'BlackBerry', 0);";
	$wpdb->query($mobileinsert);
	add_option('ult_mobile_table','DONE',false);
	endif;
	if(ULTIMATUM_VERSION=="2.5.4" && get_option('ult_mobile_tableupdate')!='DONE'){
		$mobiledelete = "DELETE FROM `".$prefix.ULTIMATUM_PREFIX."_mobile` WHERE `wp_ult25_mobile`.`id` = 3";
		$wpdb->query($mobiledelete);
		$mobileinsert = "INSERT INTO `".$prefix.ULTIMATUM_PREFIX."_mobile` (`id`, `device`, `theme`) VALUES (7, 'Windows', 0), (8, 'WindowsTablet', 0);";
		$wpdb->query($mobileinsert);
		add_option('ult_mobile_tableupdate','DONE',false);
	}
	?>
	<a class="add-new-h2 thickbox"  href="<?php echo admin_url(); ?>?page=ultimatum-mobile-assign&TB_iframe=1&width=770&height=480" title="<?php _e('Mobile APP Assigner','ultimatum');?>"><?php _e('Mobile APP Assigner','ultimatum');?></a>
 	
 	<?php 
}
function ultimatum_mobile_assigner(){
global $wpdb;
if($_POST){

$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_mobile';
$sql2 = "UPDATE $table SET `theme`='$_POST[theme]' , `mpush`='$_POST[mpush]' WHERE id='$_REQUEST[device]'";
$wpdb->query($sql2);
_e('Settings Saved','ultimatum');
}
	?>
	<h3><?php _e('Mobile Web Apps per Device', 'ultimatum');?></h3>
	<table class="widefat">
	<?php 
	$mtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_mobile';
	$sql = "SELECT * FROM `$mtable` ";
	$mres = $wpdb->get_results($sql,ARRAY_A);
	$result = wp_get_themes();
	foreach( $mres as $device){
		?>
		<tr><th><?php echo $device['device']; ?></th>
		<?php 
		
			echo '<td>';
			echo '<form action"" method="post"><select name="theme">';
			echo '<option value="0">'.__('Select','ultimatum').'</option>';
			foreach( $result as $theme){
				if($theme->template=='ultimatum'):
				if($device['theme']==$theme->stylesheet){
					echo '<option value="'.$theme->stylesheet.'" selected="selected">'.$theme->name.'</option>';
				} else {
					echo '<option value="'.$theme->stylesheet.'">'.$theme->name.'</option>';
				}
				endif;
			}
			echo '</select><select name="mpush">';
			echo '<option value="0" ';
			if($device['mpush']==0){echo 'selected="selected"';}
			echo '>'.__('Do NOT force Mobile apps', 'ultimatum').'</option>';
			echo '<option value="1"';
			if($device['mpush']==1){echo 'selected="selected"';}
			echo '>'.__('FORCE Mobile apps', 'ultimatum').'</option>';
			echo '
			</select>
			<input type="hidden" name="device" value="'.$device['id'].'" />
			<input type="submit" value="Save" class="button-primary" />
			</form></td></tr>';
		
	}
	
	?>
	
	
	</table>
	<?php 
}



