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
 * @version 2.38
 */
 
function ultimatum_editTemplate($template=null){?>
<?php 
if(!$template) {
    $template = new stdClass();
    $template->id = '';
    $template->name = '';
    $template->gridwork = 'tbs3';
    $template->swatch = 'default';
    $template->mwidth = 1200;
    $template->mmargin = 30;
    $template->width = 960;
    $template->margin = 20;
    $template->swidth = 744;
    $template->smargin = 20;
    $template->type = 0;
    $template->default = 0;
    $template->dcss = "no";
    $template->cdn = "no";
}

?>
<h2>Template Details
	<a href="./admin.php?page=wonder-templates" class="add-new-h2"><?php _e('Back', 'ultimatum');?></a>
</h2>
<form id="create-template" action="./admin.php?page=wonder-templates" method="post" class="validate">
	<table class="form-table">
	<tbody>
	<tr>
		<th scope="row"><label for="name"><?php _e('Template Name ','ultimatum'); ?></label></th>
		<td><input type="text" id="name" name="name" value="<?php echo $template->name;?>" /></td>
	</tr>
	<tr>
		<th scope="row"><label><?php _e('Grid FrameWork to use ','ultimatum'); ?></label></th>
		<td>
			<select name="gridwork" id="gridwork">
				<option value="ultimatum" <?php selected($template->gridwork,'ultimatum'); ?>>Ultimatum (to Retire Soon)</option>
				<option value="tbs" <?php selected($template->gridwork,'tbs'); ?>>Twitter Bootstrap2 (to Retire Soon)</option>
				<option value="tbs3" <?php selected($template->gridwork,'tbs3'); ?>>Twitter Bootstrap (Recommended)</option>
			</select>
		</td>
	</tr>
	<tr class="tbs griddetails <?php if($template->gridwork=='tbs') { echo 'stored';}?>">
		<th scope="row">
			<?php _e('Twitter BootStrap Beginning Template (Bootswatches)', 'ultimatum');?>
		</th>
		<td>
			<select name="swatch">
				<option value="default" <?php selected($template->swatch,'default'); ?>>Default BootStrap</option>
				<option value="Amelia" <?php selected($template->swatch,'Amelia'); ?>>Amelia</option>
				<option value="Cerulean" <?php selected($template->swatch,'Cerulean'); ?>>Cerulean</option>
				<option value="Cosmo" <?php selected($template->swatch,'Cosmo'); ?>>Cosmo</option>
				<option value="Cyborg" <?php selected($template->swatch,'Cyborg'); ?>>Cyborg</option>
				<option value="Flatly" <?php selected($template->swatch,'Flatly'); ?>>Flatly</option>
				<option value="Journal" <?php selected($template->swatch,'Journal'); ?>>Journal</option>
				<option value="Readable" <?php selected($template->swatch,'Readable'); ?>>Readable</option>
				<option value="Simplex" <?php selected($template->swatch,'Simplex'); ?>>Simplex</option>
				<option value="Slate" <?php selected($template->swatch,'Slate'); ?>>Slate</option>
				<option value="Spacelab" <?php selected($template->swatch,'Spacelab'); ?>>Spacelab</option>
				<option value="Spruce" <?php selected($template->swatch,'Spruce'); ?>>Spruce</option>
				<option value="Superhero" <?php selected($template->swatch,'Superhero'); ?>>Superhero</option>
				<option value="United" <?php selected($template->swatch,'United'); ?>>United</option>
				<?php do_action('ultimatum/bootstrap/select/option',$template);?>
			</select>
		</td>
	</tr>
	<tr class="tbs3 griddetails <?php if($template->gridwork=='tbs3') { echo 'stored';}?>">
		<th scope="row">
			<?php _e('Twitter BootStrap3 Beginning Template (Bootswatches)', 'ultimatum');?>
		</th>
		<td>
			<select name="swatch3">
				<option value="default" <?php selected($template->swatch,'default'); ?>>Default BootStrap</option>
				<option value="Amelia" <?php selected($template->swatch,'Amelia'); ?>>Amelia</option>
				<option value="Cerulean" <?php selected($template->swatch,'Cerulean'); ?>>Cerulean</option>
				<option value="Cosmo" <?php selected($template->swatch,'Cosmo'); ?>>Cosmo</option>
				<option value="Cyborg" <?php selected($template->swatch,'Cyborg'); ?>>Cyborg</option>
				<option value="Darkly" <?php selected($template->swatch,'Darkly'); ?>>Darkly</option>
				<option value="Flatly" <?php selected($template->swatch,'Flatly'); ?>>Flatly</option>
				<option value="Journal" <?php selected($template->swatch,'Journal'); ?>>Journal</option>
				<option value="Lumen" <?php selected($template->swatch,'Lumen'); ?>>Lumen</option>
				<option value="Paper" <?php selected($template->swatch,'Paper'); ?>>Paper</option>
				<option value="Readable" <?php selected($template->swatch,'Readable'); ?>>Readable</option>
				<option value="Sandstone" <?php selected($template->swatch,'Sandstone'); ?>>Sandstone</option>
				<option value="Simplex" <?php selected($template->swatch,'Simplex'); ?>>Simplex</option>
				<option value="Slate" <?php selected($template->swatch,'Slate'); ?>>Slate</option>
				<option value="Spacelab" <?php selected($template->swatch,'Spacelab'); ?>>Spacelab</option>
				<option value="Superhero" <?php selected($template->swatch,'Superhero'); ?>>Superhero</option>
				<option value="United" <?php selected($template->swatch,'United'); ?>>United</option>
				<option value="Yeti" <?php selected($template->swatch,'Yeti'); ?>>Yeti</option>
				<?php do_action('ultimatum/bootstrap3/select/option',$template);?>
			</select>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Template Type','ultimatum');?> </th>
		<td>
		<div><input class="template_type" type="radio" name="type" value="0" <?php checked($template->type,0); ?>/>&nbsp;<?php _e('Regular','ultimatum'); ?></div>
		<div><input class="template_type_r" type="radio" name="type" value="1" <?php checked($template->type,1); ?>/>&nbsp;<?php _e('Responsive','ultimatum'); ?></div>
		
		</td>
	</tr>
	<tr class="regular <?php if($template->gridwork!='tbs3') { echo 'stored';}?>">
		<th scope="row"><?php _e('Template Width','ultimatum');?> </th>
		<td><input type="text" name="width" value="<?php echo $template->width;?>" />px</td>
	</tr>
	<tr class="regular <?php if($template->gridwork!='tbs3') { echo 'stored';}?>">
		<th scope="row"><?php _e('Margins Between Columns','ultimatum');?> </th>
		<td><input type="text" name="margin" value="<?php echo $template->margin;?>" />px</td>
	</tr>
	<tr class="responsive <?php if($template->type==1) { echo 'stored';}?>">
		<th scope="row"><?php _e('Template Width <br /><span class="description">(1200px and up)</span>','ultimatum');?> </th>
		<td><input type="text" name="mwidth" value="<?php echo $template->mwidth;?>" />px</td>
	</tr>
	<tr class="responsive <?php if($template->type==1) { echo 'stored';}?>">
		<th scope="row"><?php _e('Margins Between Columns <br /><span class="description">(1200px and up)</span>','ultimatum');?> </th>
		<td><input type="text" name="mmargin" value="<?php echo $template->mmargin;?>" />px</td>
	</tr>
	<tr class="responsive <?php if($template->type==1) { echo 'stored';}?>">
		<th scope="row"><?php _e('Template Width <br /><span class="description">(Portrait tablets 768px and above)</span>','ultimatum');?> </th>
		<td><input type="text" name="swidth" value="<?php echo $template->swidth;?>" />px</td>
	</tr>
	<tr class="responsive <?php if($template->type==1) { echo 'stored';}?>">
		<th scope="row"><?php _e('Margins Between Columns <br /><span class="description">(Portrait tablets 768px and above)</span>','ultimatum');?> </th>
		<td><input type="text" name="smargin" value="<?php echo $template->smargin;?>" />px</td>
	</tr>
    <tr>
        <th scope="row"><?php _e('Use CDN ','ultimatum');?> </th>
        <td>
            <select name="cdn" id="cdn">
                <option value="no" <?php selected($template->cdn,'no'); ?>>NO</option>
                <option value="yes" <?php selected($template->cdn,'yes'); ?>>YES</option>

            </select>
            <p>Works for several Bootstrap templates and ignores responsive / grid settings.</p>
        </td>
    </tr>
	<tr>
		<th scope="row"><?php _e('Use CSS Generator ','ultimatum');?> </th>
		<td>
			<select name="dcss" id="dcss">
				<option value="no" <?php selected($template->dcss,'no'); ?>>YES</option>
				<option value="yes" <?php selected($template->dcss,'yes'); ?>>NO</option>
				
			</select>
		</td>
	</tr>
	
	</tbody>
	</table>
	<?php if($template->default==1){ ?>
		<input type="hidden" name="default" value="1" />
		<?php } else {  ?>
		<input type="hidden" name="default" value="0" />
		<?php  } ?>
		<input type="hidden" name="task" value="edit" />
		<input type="hidden" name="id" value="<?php echo $template->id;?>" />
		<input type="hidden" name="theme" value="<?php echo THEME_SLUG;?>" />
	<p class="submit">
	<input class="button button-primary" type="submit" value="<?php _e('Save Template','ultimatum');?>"></input>
	</p>
</form>
<script type="text/javascript">
<!--
jQuery(document).ready(function() {
	jQuery('.griddetails').hide();
	jQuery('.responsive').hide();
	jQuery('.stored').show();
	jQuery("#gridwork").click(function(){
			jQuery('.griddetails').hide();
			var shown = jQuery(this).val();
			jQuery('.'+shown).show();
		});
	jQuery(".template_type_r").click(function(){
				jQuery('.responsive').show();
		});
	jQuery(".template_type").click(function(){
		jQuery('.responsive').hide();
		});
});
//-->
</script>

<?php



}


