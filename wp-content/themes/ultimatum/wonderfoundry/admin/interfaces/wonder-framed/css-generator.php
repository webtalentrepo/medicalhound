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
add_action('admin_enqueue_scripts','layouteditor_scripts');
add_action('admin_enqueue_scripts','layouteditor_styles');
function layouteditor_styles(){
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'wp-color-picker' );
//	wp_enqueue_style('ultimatum-sc-editor',ULTIMATUM_ADMIN_ASSETS.'/css/ultimatum-sc-editor.css');
}

function layouteditor_scripts(){
	global $wp_version;
	wp_enqueue_media();
	wp_enqueue_script('media-upload');
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script( 'wp-color-picker' );


}

add_action( 'load-dashboard_page_ultimatum-css-gen', 'ultimatum_css_gen_thickbox' );

function ultimatum_css_gen_thickbox()
{
	iframe_header();
	ultimatum_css_generator();
	iframe_footer();
	exit;
}
function ultimatum_css_gen(){
	
}
function ultimatum_css_generator(){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
	$table2 = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
	if($_POST){
		$vars=$_POST["cssvar"][$_GET["container"]];
		foreach($vars as $element=>$property){
			$delete = "DELETE FROM $table WHERE container='$_GET[container]' AND layout_id='$_POST[layoutid]' AND element='$element'";
			$wpdb->query($delete);
			$properties = mysql_escape_string(serialize($property));
			$query = "INSERT INTO $table (`container`, `layout_id`, `element`, `properties`) VALUES ('$_GET[container]','$_POST[layoutid]', '$element','$properties')";
			$wpdb->query($query);
			
		}
		$query2 = "REPLACE INTO $table2 (`container`, `layout_id`, `user_class`, `hidephone`, `hidetablet`,`hidedesktop`) VALUES ('$_GET[container]','$_POST[layoutid]', '$_POST[user_class]', '$_POST[hidephone]', '$_POST[hidetablet]', '$_POST[hidedesktop]')";
		$wpdb->query($query2);
		?>
		  <script type="text/javascript">
		  	self.parent.SaveLayoutCSS();
		 </script>
		  <?php 
	} 
	?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('table.widefat th.top') .click(
		function() {
			jQuery(this) .parents('table.widefat') .children('tbody').slideToggle();
		});
		jQuery('.widefat tbody').hide();
		jQuery('.tb-closer') .click(
		function() {
			self.parent.tb_remove();
		});
		jQuery('.save-form').each(function(){
			var form = jQuery(this).attr('data-form');
			jQuery(this).click(function(){
				jQuery('#'+form).submit();
			});
		});
	});
	</script>
	
	<form action="" method="post" id="css-editor-form" enctype="multipart/form-data">
	<div class="fixed-top">
	<div class="tb-closer"><i class="fa fa-off"></i> Close</div>
	<div class="save-form" data-form="css-editor-form"><i class="fa fa-save"></i> <?php _e('Save', 'ultimatum');?></div>
	<input type="hidden" name="layoutid" value="<?php echo $_GET["layoutid"];?>" />
	</div>
	
	<?php 
	global $wpdb;
	$layoinfo = getLayoutInfo($_GET["layoutid"]);
	$value = false;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
	$query = "SELECT * FROM $table WHERE `layout_id`='$_GET[layoutid]' AND `container`='$_GET[container]'";
	$result = $wpdb->get_results($query,ARRAY_A);
	if($result):
	foreach($result as $fetch){
		$valuez=unserialize($fetch["properties"]);
		if(count($valuez)!=0):
		foreach($valuez as $key=>$malue){
		$value[$fetch["container"]][$fetch["element"]][$key]=$malue;
		}
		endif;
	}
	endif;
	$table2 = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
	$query2 = "SELECT * FROM $table2 WHERE `container`='$_GET[container]'";
	$fetch2 = $wpdb->get_row($query2,ARRAY_A);
	$hide_desktop='';
	$hide_phone='';
	$hide_tablet='';
	if($fetch2):
		$user_class=$fetch2['user_class'];
	
		if($fetch2['hidephone']=="hidden-phone") $hide_phone=' checked="checked"';
		if($fetch2['hidetablet']=="hidden-tablet") $hide_tablet=' checked="checked"';
		if($fetch2['hidedesktop']=="hidden-desktop") $hide_desktop=' checked="checked"';
	endif;
	if($layoinfo->dcss!='yes'){
	?>
	<table width="100%"  class="widefat" cellspacing="0">
		<thead>
			<tr valign="top">
				<th scope="row" colspan="3" class="top"><?php _e('Background Color and Image', 'ultimatum');?></th>
			</tr>
		</thead>
		<tbody>
		<tr valign="top">
			<td>
				<?php _e('Background Color', 'ultimatum');?>
			</td>
			<td colspan="2">
				<p class="description">
					<?php _e('Select your desired backround color for the body delete the text box content for transparent.', 'ultimatum');?>
				</p>
				<input id="bg_color" class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][background-color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["general"]['background-color'];?>" data-alpha="true" data-reset-alpha="true"/>
				
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<?php _e('Background Image', 'ultimatum');?>
			</th>
			<td>
				<p class="description"><?php _e('Paste the full URL (include <code>http://</code>) of image here or you can insert the image through the button. To remove image just delete the text in field.', 'ultimatum');?></p>
				<?php 
					$uploader = '';
					$val = $value[$_GET["container"]]["general"]['background-image'];
				    $uploader .= '<input size="75" name="cssvar'.'['.$_GET["container"].'][general][background-image]" id="bgImage_upload" type="text" size="6"  value="'. $val .'" />';
					$uploader .= '<div class="upload_button_div"><input type="button" class="button option-upload-button" data-id="bgImage_upload" value="Upload Image" />';
					$uploader .='</div>' . "\n";
					echo $uploader;
					
				?>
			</td>
			<td style="border: medium none;" id="image_here">
				<?php 
					if(!empty($val)){
						echo '<div id="bgImage_upload_preview" style="background:#'.$value[$_GET["container"]]["general"]['background-color'].';width:150px;height:150px"><div style="background-image:url('.$val.');width:150px;height:150px"></div></div>';
					}
				?>
			</td>
		</tr>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Image Location', 'ultimatum');?></th>
			<td colspan="2">
				<p class="description"></p>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][background-position]">
					<option value="left top" <?php if($value[$_GET["container"]]["general"]['background-position']=='left top'){ echo ' selected="selected"';}?>><?php _e('top left', 'ultimatum');?></option>
					<option value="right top" <?php if($value[$_GET["container"]]["general"]['background-position']=='right top'){ echo ' selected="selected"';}?>><?php _e('top right', 'ultimatum');?></option>
					<option value="center top" <?php if($value[$_GET["container"]]["general"]['background-position']=='center top'){ echo ' selected="selected"';}?>><?php _e('top center', 'ultimatum');?></option>
				 	<option value="left bottom" <?php if($value[$_GET["container"]]["general"]['background-position']=='left bottom'){ echo ' selected="selected"';}?>><?php _e('bottom left', 'ultimatum');?></option>
					<option value="right bottom" <?php if($value[$_GET["container"]]["general"]['background-position']=='right bottom'){ echo ' selected="selected"';}?>><?php _e('bottom right', 'ultimatum');?></option>
					<option value="center bottom" <?php if($value[$_GET["container"]]["general"]['background-position']=='center bottom'){ echo ' selected="selected"';}?>><?php _e('bottom center', 'ultimatum');?></option>
				</select>
				<br />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row"><?php _e('Image Repeat', 'ultimatum');?></th>
			<td colspan="2">
				<p class="description"></p>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][background-repeat]">
					<option value="repeat" <?php if($value[$_GET["container"]]["general"]['background-repeat']=='repeat'){ echo ' selected="selected"';}?>><?php _e('repeat', 'ultimatum');?></option>
					<option value="repeat-x" <?php if($value[$_GET["container"]]["general"]['background-repeat']=='repeat-x'){ echo ' selected="selected"';}?>><?php _e('repeat horizontal', 'ultimatum');?></option>
					<option value="repeat-y" <?php if($value[$_GET["container"]]["general"]['background-repeat']=='repeat-y'){ echo ' selected="selected"';}?>><?php _e('repeat vertical', 'ultimatum');?></option>
					<option value="no-repeat" <?php if($value[$_GET["container"]]["general"]['background-repeat']=='no-repeat'){ echo ' selected="selected"';}?>><?php _e('No repeat', 'ultimatum');?></option>
				</select>
				<br />
			</td>
		</tr>
	</tbody>
	</table>
	<table width="100%"  class="widefat" cellspacing="0">
		<thead>
			<tr valign="top">
				<th scope="row" colspan="4" class="top">
					<?php _e('Borders', 'ultimatum');?>
				</th>
			</tr>
		</thead>
		<tbody>
		<tr><td></td><th><?php _e('Border Size', 'ultimatum');?></th><th><?php _e('Border Color', 'ultimatum');?></th><th><?php _e('Border Style', 'ultimatum');?></th></tr>
		<tr>
			<th><?php _e('Border Top', 'ultimatum');?></th>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-top-width]">
				<option value=""><?php _e('select', 'ultimatum');?></option>
				<?php 
					for($i=0;$i<=5;$i++){
						echo '<option value="'.$i.'px"';
						if($value[$_GET["container"]]["general"]['border-top-width'] &&  $value[$_GET["container"]]["general"]['border-top-width']==$i){ echo ' selected="selected"';}
						echo '>'.$i.'px</option>';
					}
				?>
				</select>
			</td>
			<td>
					<input class="ult-color-field"  name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-top-color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["general"]['border-top-color'];?>"/>
			</td>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-top-style]">
					<option value="none" <?php if($value[$_GET["container"]]["general"]['border-top-style'] &&  $value[$_GET["container"]]["general"]['border-top-style']=='none'){ echo ' selected="selected"';}?>>none</option>
					<option value="solid" <?php if($value[$_GET["container"]]["general"]['border-top-style'] &&  $value[$_GET["container"]]["general"]['border-top-style']=='solid'){ echo ' selected="selected"';}?>>Solid</option>
					<option value="dotted" <?php if($value[$_GET["container"]]["general"]['border-top-style'] &&  $value[$_GET["container"]]["general"]['border-top-style']=='dotted'){ echo ' selected="selected"';}?>>Dotted</option>
					<option value="dashed" <?php if($value[$_GET["container"]]["general"]['border-top-style'] &&  $value[$_GET["container"]]["general"]['border-top-style']=='dashed'){ echo ' selected="selected"';}?>>Dashed</option>
				</select>
			</td>
		</tr>
			<tr>
			<th><?php _e('Border Bottom', 'ultimatum');?></th>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-bottom-width]">
				<option value=""><?php _e('select', 'ultimatum');?></option>
				<?php 
					for($i=0;$i<=5;$i++){
						echo '<option value="'.$i.'px"';
						if($value[$_GET["container"]]["general"]['border-bottom-width'] &&  $value[$_GET["container"]]["general"]['border-bottom-width']==$i){ echo ' selected="selected"';}
						echo '>'.$i.'px</option>';
					}
				?>
				</select>
			</td>
			<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-bottom-color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["general"]['border-bottom-color'];?>"/>
			</td>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-bottom-style]">
					<option value="none" <?php if($value[$_GET["container"]]["general"]['border-bottom-style'] &&  $value[$_GET["container"]]["general"]['border-bottom-style']=='none'){ echo ' selected="selected"';}?>>none</option>
					<option value="solid" <?php if($value[$_GET["container"]]["general"]['border-bottom-style'] &&  $value[$_GET["container"]]["general"]['border-bottom-style']=='solid'){ echo ' selected="selected"';}?>>Solid</option>
					<option value="dotted" <?php if($value[$_GET["container"]]["general"]['border-bottom-style'] &&  $value[$_GET["container"]]["general"]['border-bottom-style']=='dotted'){ echo ' selected="selected"';}?>>Dotted</option>
					<option value="dashed" <?php if($value[$_GET["container"]]["general"]['border-bottom-style'] &&  $value[$_GET["container"]]["general"]['border-bottom-style']=='dashed'){ echo ' selected="selected"';}?>>Dashed</option>
				</select>
			</td>
		</tr>
		<?php if(!preg_match('/wrapper-/i',$_GET["container"])) {?>
		<tr>
			<th><?php _e('Border Left', 'ultimatum');?></th>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-left-width]">
				<option value=""><?php _e('select', 'ultimatum');?></option>
				<?php 
					for($i=0;$i<=5;$i++){
						echo '<option value="'.$i.'px"';
						if($value[$_GET["container"]]["general"]['border-left-width'] &&  $value[$_GET["container"]]["general"]['border-left-width']==$i){ echo ' selected="selected"';}
						echo '>'.$i.'px</option>';
					}
				?>
				</select>
			</td>
			<td>
					<input class="ult-color-field"  name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-left-color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["general"]['border-left-color'];?>"/>
			</td>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-left-style]">
					<option value="none" <?php if($value[$_GET["container"]]["general"]['border-left-style'] &&  $value[$_GET["container"]]["general"]['border-left-style']=='none'){ echo ' selected="selected"';}?>>none</option>
					<option value="solid" <?php if($value[$_GET["container"]]["general"]['border-left-style'] &&  $value[$_GET["container"]]["general"]['border-left-style']=='solid'){ echo ' selected="selected"';}?>>Solid</option>
					<option value="dotted" <?php if($value[$_GET["container"]]["general"]['border-left-style'] &&  $value[$_GET["container"]]["general"]['border-left-style']=='dotted'){ echo ' selected="selected"';}?>>Dotted</option>
					<option value="dashed" <?php if($value[$_GET["container"]]["general"]['border-left-style'] &&  $value[$_GET["container"]]["general"]['border-left-style']=='dashed'){ echo ' selected="selected"';}?>>Dashed</option>
				</select>
			</td>
		</tr>
		<tr>
			<th><?php _e('Border right', 'ultimatum');?></th>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-right-width]">
				<option value=""><?php _e('select', 'ultimatum');?></option>
				<?php 
					for($i=0;$i<=5;$i++){
						echo '<option value="'.$i.'px"';
						if($value[$_GET["container"]]["general"]['border-right-width'] &&  $value[$_GET["container"]]["general"]['border-right-width']==$i){ echo ' selected="selected"';}
						echo '>'.$i.'px</option>';
					}
				?>
				</select>
			</td>
			<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-right-color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["general"]['border-right-color'];?>"/>
			</td>
			<td>
				<select name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][border-right-style]">
					<option value="none" <?php if($value[$_GET["container"]]["general"]['border-right-style'] &&  $value[$_GET["container"]]["general"]['border-right-style']=='none'){ echo ' selected="selected"';}?>>none</option>
					<option value="solid" <?php if($value[$_GET["container"]]["general"]['border-right-style'] &&  $value[$_GET["container"]]["general"]['border-right-style']=='solid'){ echo ' selected="selected"';}?>>Solid</option>
					<option value="dotted" <?php if($value[$_GET["container"]]["general"]['border-right-style'] &&  $value[$_GET["container"]]["general"]['border-right-style']=='dotted'){ echo ' selected="selected"';}?>>Dotted</option>
					<option value="dashed" <?php if($value[$_GET["container"]]["general"]['border-right-style'] &&  $value[$_GET["container"]]["general"]['border-right-style']=='dashed'){ echo ' selected="selected"';}?>>Dashed</option>
				</select>
			</td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<!-- BG TABLE DONE -->
	<table width="100%"  class="widefat" cellspacing="0">
		<thead>
			<tr valign="top">
				<th scope="row" colspan="9" class="top">
					<?php _e('Height / Margin / Padding', 'ultimatum');?>
				</th>
			</tr>
		</thead>
		<tbody>
		<tr>
			<th><?php _e('Height', 'ultimatum');?></th>
			<td colspan="8">
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][min-height]" value="<?php echo $value[$_GET["container"]]["general"]['min-height'];?>" type="text" size="2">px
			</td>
		</tr>
		<tr>
			<th>
				<?php _e('Margin', 'ultimatum');?>
			</th>
			<td>
				<?php _e('margin top', 'ultimatum');?><br />
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][margin-top]" value="<?php echo $value[$_GET["container"]]["general"]['margin-top'];?>" type="text" size="2">px
			</td>
			<td colspan="5">
				<?php _e('margin bottom', 'ultimatum');?>
				<br />
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][margin-bottom]" value="<?php echo $value[$_GET["container"]]["general"]['margin-bottom'];?>" type="text" size="2">px
			</td>
		</tr>
		<tr>
			<th>
				<?php _e('padding', 'ultimatum');?>
			</th>
			<td>
				<?php _e('padding top', 'ultimatum');?>
				<br/>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][padding-top]" value="<?php echo $value[$_GET["container"]]["general"]['padding-top'];?>" type="text" size="2">px
			</td>
			<td>
				<?php _e('padding bottom', 'ultimatum');?>
				<br />
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][padding-bottom]" value="<?php echo $value[$_GET["container"]]["general"]['padding-bottom'];?>" type="text" size="2">px
			</td>
			<?php if(preg_match('/col-/i',$_GET["container"])) {?>
			<td>
				<?php _e('padding left', 'ultimatum');?>
				<br />
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][padding-left]" value="<?php echo $value[$_GET["container"]]["general"]['padding-left'];?>" type="text" size="2">px
			</td>
			<td>
				<?php _e('padding right', 'ultimatum');?>
				<br />
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][padding-right]" value="<?php echo $value[$_GET["container"]]["general"]['padding-right'];?>" type="text" size="2">px
			</td>
			<?php }?>
		</tr>
		<tr>
			<th>
				<?php _e('Margin Between Widgets', 'ultimatum');?>
			</th>
			<td colspan="5">
				<?php _e('margin bottom', 'ultimatum');?>
				<br />
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[.inner-container][margin-bottom]" value="<?php echo $value[$_GET["container"]]['.inner-container']['margin-bottom'];?>" type="text" size="2">px
			</td>
		</tr>
	</tbody>
	</table>
	<table class="widefat">
		<thead>
			<tr>
				<th class="top" colspan="4"><?php _e('Font Styling', 'ultimatum');?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><?php _e('Color', 'ultimatum');?></td>
				<td><?php _e('Font Size', 'ultimatum');?></td>
				<td><?php _e('Line Height', 'ultimatum');?></td>
			</tr>
			<tr>
				<th width="100">
					<?php _e('General Font', 'ultimatum');?>
				</th>
				<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["general"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["general"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[general][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["general"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					H1
				</th>
				<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h1][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["h1"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h1][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["h1"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h1][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["h1"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					H2
				</th>
				<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h2][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["h2"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h2][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["h2"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h2][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["h2"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					H3
				</th>
				<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h3][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["h3"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h3][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["h3"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h3][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["h3"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					H4
				</th>
				<td>
					<input class="ult-color-field"  name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h4][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["h4"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h4][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["h4"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h4][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["h4"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					H5
				</th>
				<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h5][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["h5"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h5][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["h5"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h5][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["h5"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					H6
				</th>
				<td>
					<input class="ult-color-field"  name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h6][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["h6"]['color'];?>"/>
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h6][font-size]" type="text" value="<?php echo $value[$_GET["container"]]["h6"]['font-size'];?>" size="3" />px
				</td>
				<td>
				<input name="cssvar<?php echo '['.$_GET["container"].']'; ?>[h6][line-height]" type="text" value="<?php echo $value[$_GET["container"]]["h6"]['line-height'];?>" size="3" />px
				</td>
			</tr>
			<tr>
				<th>
					a
				</th>
				<td>
					<input class="ult-color-field" name="cssvar<?php echo '['.$_GET["container"].']'; ?>[a][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["a"]['color'];?>"/>
				</td>
			</tr>
			<tr>
				<th>
					a:hover
				</th>
				<td>
					<input class="ult-color-field"  name="cssvar<?php echo '['.$_GET["container"].']'; ?>[ahover][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]["ahover"]['color'];?>"/>
				</td>
			</tr>
			<tr>
				<th>
					<?php _e('button text', 'ultimatum');?>
				</th>
				<td>
					<input class="ult-color-field"  name="cssvar<?php echo '['.$_GET["container"].']'; ?>[.button][color]" type="text" size="6"  value="<?php echo $value[$_GET["container"]]['.button']['color'];?>"/>
				</td>
			</tr>
		</tbody>
	</table>
	<?php 
	}
	?>
	<table class="widefat">
		<thead>
			<tr>
				<th class="top" colspan="2"><?php _e('Additional Classes', 'ultimatum');?></th>
			</tr>
		</thead>
		<tbody>
		<tr><td><?php _e('Custom CSS Classes', 'ultimatum')?></td><td><i><?php _e('Add any classes you want for extra styling in your custom CSS with spaces in between. eg. class1 class2 ', 'ultimatum');?></i><br /></br><input type="text" name="user_class" value="<?php echo $user_class;?>" /></td></tr>
		<tr><td><?php _e('Hide Form Desktop', 'ultimatum')?></td><td><i><?php _e('If the layout is responsive this option will make sure the element selected will not show for desktops', 'ultimatum');?></i><input type="checkbox" name="hidedesktop" value="hidden-desktop" <?php echo $hide_desktop;?> /></td></tr>
		<tr><td><?php _e('Hide From Tablets', 'ultimatum')?></td><td><i><?php _e('If the layout is responsive this option will make sure the element selected will not show for tablets', 'ultimatum');?></i><input type="checkbox" name="hidetablet" value="hidden-tablet" <?php echo $hide_tablet;?> /></td></tr>
		<tr><td><?php _e('Hide from Phones', 'ultimatum')?></td><td><i><?php _e('If the layout is responsive this option will make sure the element selected will not show for phones', 'ultimatum');?></i><input type="checkbox" name="hidephone" value="hidden-phone" <?php echo $hide_phone;?> /></td></tr>
		</tbody>
	</table>
	
	
	</form>
		
	<?php 
}