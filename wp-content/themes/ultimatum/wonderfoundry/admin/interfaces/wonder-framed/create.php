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

add_action( 'load-dashboard_page_layout-create', 'ultimatum_layout_creator_thickbox' );

function ultimatum_layout_creator_thickbox()
{
	iframe_header();
	global $wpdb;
		if($_POST){
			$query = "INSERT INTO `".ULTIMATUM_TABLE_LAYOUT."` (`title`, `type`,`theme`) VALUES ('$_POST[title]', '$_POST[type]','$_REQUEST[theme]')";
			$wpdb->query($query);
			$layoutid = $wpdb->insert_id;
			?>
			<script type="text/javascript">
				self.parent.CreateLayout(<?php echo $layoutid;?>,<?php echo $_REQUEST["theme"]; ?>,'<?php echo admin_url();?>');
			</script>
			<?php 
		}
		?>
		<div class="fixed-top">
<div class="tb-closer"><i class="fa fa-off"></i> Close</div>
<div class="save-form" data-form="create-layout"><i class="fa fa-save"></i> <?php _e('Save', 'ultimatum');?></div>
</div>
<form method="post" action="" id="create-layout">
				<table class="widefat" style="width:100%;height:100%">
					<thead>
						<tr>
							<th colspan="2"><?php _e('Create a new Layout', 'ultimatum'); ?></th>
						</tr>
					</thead>
					<tfoot>
					</tfoot>
					<tbody>
						<tr>
							<td nowrap="nowrap"><label><?php _e('Layout Name', 'ultimatum');?> :</label></td>
							<td><input type="text" name="title" value="<?php _e('Layout Name', 'ultimatum');?>" /></td>
						</tr>
						<tr>
							<td nowrap="nowrap">
								<label><?php _e('Layout Type', 'ultimatum');?> :</label>
							</td>
							<td>
							<p><i><strong><?php _e('Full Layouts', 'ultimatum');?></strong> <?php _e('are the main layouts that you can assign to post types and posts or pages.', 'ultimatum');?></i></p>
							<p><i><strong><?php _e('Partial Layouts', 'ultimatum');?></strong> <?php _e('are the layouts that you might want to use more then once. You can include them before or after the main section of a full layout.', 'ultimatum');?></i></p>
								<select name="type">
									<option value="full"><?php _e('Full', 'ultimatum');?></option>
									<option value="part"><?php _e('Part', 'ultimatum');?></option>
								</select>
							</td>
						</tr>
						
					</tbody>
				</table>
				</form>
				<script type="text/javascript">
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
    			</script>
<?php
	iframe_footer();
	exit; //Die to prevent the page continueing loading and adding the admin menu's etc.
}
function ultimatum_layout_creator(){};
