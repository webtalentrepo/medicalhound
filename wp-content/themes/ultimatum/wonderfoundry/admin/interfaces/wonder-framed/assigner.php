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

add_action( 'load-dashboard_page_layout-assigner', 'ultimatum_layout_assigner_thickbox' );

function ultimatum_layout_assigner_thickbox()
{
	iframe_header();
	global $wpdb;
		if($_POST){
			$query = "REPLACE INTO `".ULTIMATUM_TABLE_LAYOUT_ASSIGN."` VALUES ('".THEME_SLUG."','$_POST[posttype]','$_POST[layout]')";
			$wpdb->query($query);
			?>
			<script type="text/javascript">
			self.parent.SetLayoutAssignments();
			</script>
			<?php 
		}
		
		$query = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='full' AND `theme`='$_REQUEST[theme]' ORDER BY `default` DESC, `title` ASC";
		$full = $wpdb->get_results($query,ARRAY_A);
	?>
	<div class="fixed-top">
<div class="tb-closer"><i class="fa fa-off"></i> Close</div>
<div class="save-form" data-form="assigner-form"><i class="fa fa-save"></i> <?php _e('Save', 'ultimatum');?></div>
</div>
<form method="post" action="" id="assigner-form">
<table class="widefat">
<thead>
<tr>
<th colspan="2"><?php _e('Assign Layout to Post/Page Types', 'ultimatum');?></th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td>
								<label><?php _e('Layout', 'ultimatum');?>:</label>
							</td>
							<td>
								<p><i><?php _e('If no layouts for the requested page/post this layout will be shown for it', 'ultimatum');?>.</i></p>
								<select name="layout">
								
									<?php 
									if($full){foreach($full as $layout){
											echo '<option value="'.$layout["id"].'">'.$layout["title"].'</option>';
											
										}}
									?>
								
								</select>
							</td>
						</tr>
						<tr>
							<td nowrap="nowrap">
								<label><?php _e('Post/Page Type', 'ultimatum');?>:</label>
							</td>
							<td>
								<select name="posttype">
									<optgroup label="Core">
										<option value="search"><?php _e('Search', 'ultimatum');?></option>
										<option value="404">404</option>
										<option value="author"><?php _e('author', 'ultimatum');?></option>
										<option value="home"><?php _e('Home', 'ultimatum');?></option>
										<option value="page"><?php _e('Page', 'ultimatum');?></option>
									</optgroup>
									<?php 
									ultimatum_select_post_and_taxonomy();
									?>
									
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
function ultimatum_select_post_and_taxonomy(){
	$ultimatum_post_and_tax = array();
	$args=array('public'   => true,'publicly_queryable' => true);
	// add post types
	$post_types=get_post_types($args,'names');
	foreach ($post_types as $post_type ) {
		if($post_type!='attachment'){
			$ultimatum_post_and_tax["$post_type"]['items'][$post_type] = $post_type;
			$ultimatum_post_and_tax["$post_type"]['items'][$post_type.'-single']= $post_type.'-single';
			$taxonomy_objects = get_object_taxonomies( $post_type, 'objects' );
			
			foreach ($taxonomy_objects as $taxonomy => $taxprops){
				//print_r($taxprops);
				if($taxprops->public==1){ // if taxonomy is public
					if($post_type == 'post' && $taxonomy=='category'){ // post categories are special
						$entries = get_categories('title_li=&orderby=name&hide_empty=1');
						if(count($entries)>=1){
							foreach ($entries as $key => $entry) {
								$ultimatum_post_and_tax["$post_type"]['items']['cat-'.$entry->term_id]	= 'post-category-'.$entry->name;
							}
						}						
						//$ultimatum_post_and_tax["$post_type"]['items'][]
					} else {
						$entries = get_terms( $taxonomy, 'orderby=name&hide_empty=1' );
						if(count($entries)>=1){
							foreach ($entries as $key => $entry) {
								$optiont= $post_type.'-'.$taxonomy.'-'.$entry->slug;
								$ultimatum_post_and_tax["$post_type"]['items']["$optiont"]	= $taxprops->label.'-'.$entry->name;
							}
						}
					}
				}
			}
		}
	}
	$ultimatum_post_and_tax = apply_filters('ultimatum_post_tax_selector', $ultimatum_post_and_tax);
	foreach($ultimatum_post_and_tax as $posttype => $items){
		//echo '<pre>';print_r($items['items']);echo'</pre>';
		echo '<optgroup label="'.$posttype.'">';
		foreach($items['items'] as $key=>$value){
			echo '<option value="'.$key.'">'.$value.'</option>';
		}
		echo '</optgroup>';
	}
}

function ultimatum_layout_assigner(){
	
}
