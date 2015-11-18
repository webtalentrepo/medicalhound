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
function layouteditor_scripts(){
	global $wp_version;
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-widget');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-sortable');
	wp_enqueue_script('jquery-ui-draggable');
	wp_enqueue_script('jquery-ui-droppable');
	wp_enqueue_script('jquery-ui-selectable');
	wp_enqueue_style( 'ultimatum-row-selector',ULTIMATUM_ADMIN_ASSETS.'/css/ultimatum.row.selector.css' );
}
add_action( 'load-dashboard_page_ultimatum-row-layouts', 'ultimatum_row_layouts_thickbox' );

function ultimatum_row_layouts_thickbox()
{
	iframe_header();
	ultimatum_row_selector();
	iframe_footer();
	exit;
}
function ultimatum_row_selector(){
	?>
	<script>
jQuery(document).ready(function() {
	jQuery(function() {
		jQuery( "#selectable" ).selectable({
			stop: function(e,ui) {
				var result = jQuery( "#select-result" ).empty();
					jQuery(".ui-selected:first", this).each(function() {
					jQuery(this).siblings().removeClass("ui-selected");
					var index = jQuery(this).attr("data-id");
					result.val(index);
				});
			}
		});
		jQuery( "#selectable" ).selectable( "option", "filter", 'li' );
	});
	jQuery( "#selectable" ).disableSelection();
	
});
function InsertRowtoLayout(){
	var id= "<?php echo $_GET["layout_id"]; ?>";
	var style = jQuery( "#select-result" ).val();
	var win = window.dialogArguments || opener || parent || top;
	win.LayoutGetRow(id,style);
	win.tb_remove();
}
	</script>
	<ol id="selectable">
<li data-id="1" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="100%">100%</td>
	</tr>
</table>

</li>
<li data-id="2" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
</table>

</li>
<li data-id="3" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
	</tr>
</table>

</li>
<li data-id="4" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="50%">50%</td>
		<td width="50%">50%</td>
	</tr>
</table>

</li>
<li data-id="5" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="50%">50%</td>
	</tr>
</table>

</li>
<li data-id="6" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="50%">50%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
</table>

</li>
<li data-id="7" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="50%">50%</td>
		<td width="25%">25%</td>
	</tr>
</table>

</li>
<li data-id="8" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="75%">75%</td>
	</tr>
</table>

</li>
<li data-id="9" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="75%">75%</td>
		<td width="25%">25%</td>
	</tr>
</table>

</li>
<li data-id="10" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="33%">33%</td>
		<td width="66%">66%</td>
	</tr>
</table>

</li>
<li data-id="11" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="66%">66%</td>
		<td width="33%">33%</td>
	</tr>
</table>

</li>
<li data-id="12" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
	<tr>
		<td width="75%" colspan="3">75%</td>
	</tr>
</table>

</li>
<li data-id="13" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="75%" colspan="3">75%</td>
	</tr>
</table>
</li>
<li data-id="14" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
	<tr>
		<td width="50%" colspan="2">50%</td>
	</tr>
</table>

</li>
<li data-id="15" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="50%" colspan="2">50%</td>
	</tr>
</table>

</li>
<li data-id="16" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="50%" colspan="2">50%</td>
	</tr>
</table>

</li>
<li data-id="17" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="50%">50%</td>
		<td width="25%">25%</td>
	</tr>
	<tr>
		<td width="75%" colspan="2">75%</td>
	</tr>
</table>
</li>
<li data-id="18" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%">25%</td>
		<td width="50%">50%</td>
	</tr>
	<tr>
		<td width="75%" colspan="2">75%</td>
	</tr>
</table>
</li>
<li data-id="19" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="50%">50%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="75%" colspan="2">75%</td>
	</tr>
</table>
</li>
<li data-id="20" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="50%">50%</td>
		<td width="25%">25%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="75%" colspan="2">75%</td>
	</tr>
</table>
</li>
<li data-id="21" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="50%" rowspan="2">50%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
	<tr>
		<td width="75%" colspan="2">50%</td>
	</tr>
</table>
</li>
<li data-id="22" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="50%" rowspan="2">50%</td>
	</tr>
	<tr>
		<td width="75%" colspan="2">50%</td>
	</tr>
</table>
</li>
<li data-id="23" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="33%" rowspan="2">33%</td>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
	</tr>
	<tr>
		<td width="66%" colspan="2">66%</td>
	</tr>
</table>
</li>
<li data-id="24" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
		<td width="33%" rowspan="2">33%</td>
	</tr>
	<tr>
		<td width="66%" colspan="2">66%</td>
	</tr>
</table>
</li>

<li data-id="25" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="50%" rowspan="2">50%</td>
		<td width="75%" colspan="2">50%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		
	</tr>
</table>
</li>
<li data-id="26" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="75%" colspan="2">50%</td>
		<td width="50%" rowspan="2">50%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		
	</tr>
</table>
</li>
<li data-id="27" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="33%" rowspan="2">33%</td>
		<td width="66%" colspan="2">66%</td>
	</tr>
	<tr>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
		
	</tr>
</table>
</li>
<li data-id="28" class="ui-widget-content">
<table class="preview">
	<tr>
		
		<td width="66%" colspan="2">66%</td>
		<td width="33%" rowspan="2">33%</td>
	</tr>
	<tr>
		<td width="33%">33%</td>
		<td width="33%">33%</td>
	</tr>
</table>
<!-- 29 -->
<li data-id="29" class="ui-widget-content">
<table class="preview">
	<tr>
		
		<td width="75%" colspan="3">75%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
</table>
</li>
<!-- 30 -->
<li data-id="30" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%" rowspan="2">25%</td>
		<td width="50%" colspan="2">50%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
</table>
</li>
<!-- 31 -->
<li data-id="31" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="50%" colspan="2">50%</td>
		<td width="25%" rowspan="2">25%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>	
	</tr>
</table>
</li>
<!-- 32 -->
<li data-id="32" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="50%" colspan="2">50%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="25%">25%</td>
	</tr>
</table>
</li>
<!-- 33 -->
<li data-id="33" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
		<td width="75%" colspan="2">75%</td>
	</tr>
	<tr>
		<td width="50%">50%</td>
		<td width="25%">25%</td>
	</tr>
</table>
</li>
<!-- 34 -->
<li data-id="34" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="25%" rowspan="2">25%</td>
	    <td width="75%" colspan="2">75%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="50%">50%</td>

	</tr>
</table>
</li>
<!-- 35 -->
<li data-id="35" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="75%" colspan="2">75%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="25%">25%</td>
		<td width="50%">50%</td>
	</tr>
</table>
</li>
<!-- 36 -->
<li data-id="36" class="ui-widget-content">
<table class="preview">
	<tr>
		<td width="75%" colspan="2">75%</td>
		<td width="25%" rowspan="2">25%</td>
	</tr>
	<tr>
		<td width="50%">50%</td>
		<td width="25%">25%</td>
	</tr>
</table>
<li data-id="37" class="ui-widget-content">
<table class="preview">
	<table class="preview">
	<tr>
		<td width="100%">100% FULL WIDTH(FOR SLIDERS)</td>
	</tr>
</table>
</table>
</li>
<?php 
// extra rows
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
$sql = "SELECT * from $table WHERE `template_id`='".$_GET['template_id']."'";
$extrarows = $wpdb->get_results($sql);
if(count($extrarows)!=0){
	foreach ($extrarows as $extrarow){
	?>
	<li data-id="<?php echo $extrarow->template_id.'_'.$extrarow->slug; ?>" class="ui-widget-content">
	<table class="preview">
		<tr>
			<td width="100%"><?php echo $extrarow->name; ?></td>
		</tr>
	</table>
	</li>
	<?php 
	}
}

?>
</ol>
<center>
<div style="clear:both"></div>
<form>
<input id="select-result" name="row_style" type="hidden" />
<input name="layout_id" value="<?php echo $_GET["layout_id"]; ?>" type="hidden" />
<input style="width:500px;text-align:center;font-size:13px;font-weight:bold" type='button' class='button' onclick='InsertRowtoLayout()' value='Insert' />
</form>
</center>

	<?php 
}

function ultimatum_row_selector_screen(){
	
}
?>
