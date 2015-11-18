<?php
function ultimatum_layouts_help() {
	$file = ULTIMATUM_ADMIN_HELP.'/layouts.php';
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

add_action('contextual_help', 'ultimatum_layouts_help', 10);
if(!isset($_REQUEST['theme']) && !isset($_REQUEST['layout_id']) && !isset($_REQUEST["source"])){
	_e('Bad Request No theme Info Supplied', 'ultimatum');
} else {
	function layouteditor_styles(){
        global $wp_scripts;
		global $wp_version;
		wp_enqueue_style('thickbox');
        $ui = $wp_scripts->query('jquery-ui-core');

        // tell WordPress to load the Smoothness theme from Google CDN
        $url = "//ajax.googleapis.com/ajax/libs/jqueryui/{$ui->ver}/themes/smoothness/jquery-ui.min.css";
        wp_enqueue_style('jquery-ui-smoothness', $url, false, null);
		//wp_enqueue_style( 'jqueryui-css','//ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/smoothness/jquery-ui.min.css' );
	}
	add_action('admin_enqueue_scripts','layouteditor_styles');
	function layouteditor_scripts(){
		global $wp_version;
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-widget');
		wp_enqueue_script('jquery-ui-mouse');
		wp_enqueue_script('jquery-ui-sortable');
		wp_enqueue_script('jquery-ui-draggable');
		wp_enqueue_script('jquery-ui-droppable');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('hoverIntent');
		wp_enqueue_script('common');
		wp_enqueue_script('jquery-color');
		wp_enqueue_script('thickbox');
		wp_enqueue_script( 'ultimatum-bootstrap',ULTIMATUM_ADMIN_ASSETS.'/js/admin.bootstrap.min.js' );
		wp_enqueue_script( 'ultimatum-layogen',ULTIMATUM_ADMIN_ASSETS.'/js/interface-layout-generator.js' );
		if ( version_compare( $wp_version, '4.2.3', '>=' ) ) {
			wp_enqueue_script('ultimatum-widgets', ULTIMATUM_ADMIN_ASSETS . '/js/ultimatum-widgets.js');
		} else {
			wp_enqueue_script('ultimatum-widgets', ULTIMATUM_ADMIN_ASSETS . '/js/ultimatum-widgets-old.js');
		}
	}
	add_action('admin_enqueue_scripts','layouteditor_scripts');
    
	function ultimatum_layouts(){
		if(isset($_REQUEST['task'])){
			$task = $_REQUEST['task'];
		} else {
			$task=false;
		}
		
		
		switch ($task){
			default:
				echo '<div class="wrap">';
				ultimatum_list_layouts();
			break;
			case 'edit':
				echo '<div class="wrap ultwrap">';
				ultimatum_layout_generator();
			break;
		}
		echo '</div>';
	}
}
function ultimatum_list_layouts(){
	require_once('ultimatum-widgets.php');
	global $wp_registered_widgets, $wp_registered_widget_controls;
	$sidebars_widgets = wp_get_sidebars_widgets();
	global $wpdb;
	if(isset($_GET['delassigner'])){
		$sql1 = "DELETE FROM `".ULTIMATUM_TABLE_LAYOUT_ASSIGN."` WHERE `post_type`='".$_GET['delassigner']."' AND `layout_id`='".$_GET['delposter']."'";
		$wpdb->query($sql1);
		$url = "admin.php?page=wonder-layout&theme=".$_GET['theme'];
		echo '<script type="text/javascript">parent.location.href="'.$url.'"</script>';
	}
	if($_POST){
		switch ($_POST['action']){
			case 'copycss':
				$tobecloned = $_POST["source"];
				$cloneid = $_POST["cloneid"];
				$option = get_option(THEME_SLUG.'_'.$tobecloned.'_css');
				$newopt = update_option(THEME_SLUG.'_'.$cloneid.'_css', $option);
				$custom_css = get_option(THEME_SLUG.'_custom_css_'.$tobecloned);
				if(strlen($custom_css)) update_option(THEME_SLUG.'_custom_css_'.$cloneid,$custom_css);
				unset($_POST);
				require_once (ULTIMATUM_ADMIN_HELPERS.DS.'class.css.saver.php');
				WonderWorksCSS::saveCSS($cloneid);
				$url= 'admin.php?page=wonder-css&layout='.$cloneid;
				echo '<script type="text/javascript">parent.location.href="'.$url.'"</script>';
			break;
			default:
				echo '<h3>Illegal operation</h3>';
			break;
		}
	}
	$theme=$_REQUEST['theme'];
	$themeinfo = getTemplateInfo($theme);
	
	?>
	<h2><?php _e('LAYOUTS','ultimatum')?> - <small><em>(<?php echo $themeinfo->name;?>)</em></small>
	 <a class="add-new-h2 thickbox" href="<?php echo './index.php?page=layout-create&theme='.$_REQUEST['theme'].'&modal=true&TB_iframe=1&width=640&height=380'; ?>"><?php _e('Add New', 'ultimatum');?></a>
	 <a class="add-new-h2 thickbox" href="<?php echo './index.php?page=layout-assigner&theme='.$_REQUEST['theme'].'&modal=true&TB_iframe=1&width=95%&height=100%'; ?>"><?php _e('Assign Layouts','ultimatum');?></a>
	 <a class="add-new-h2" href="./admin.php?page=wonder-templates"><?php _e('Templates','ultimatum');?></a>
	</h2>
	
 	<div id="ultimatum_layout_list">
	<?php include(ULTIMATUM_ADMIN_AJAX.DS.'list-layouts.php') ;?>
	</div>
	<?php
}





function ultimatum_layout_generator() {
	require_once('ultimatum-widgets.php');
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$tablerows = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
	$layoutid=$_GET["layoutid"];
	$query = "SELECT * FROM $table WHERE `id`='$layoutid'";
	$layout = $wpdb->get_row($query,ARRAY_A);

?>
<style>td{vertical-align: top;}</style>
<div id="blocker">
<div><h1><i class="fa fa-save"></i> Saving..</h1></div>
</div>
	<div class="ultadmnavi" style="position:absolute;top:0;width:100%;margin-right:25px;">
 		<div class="navbar">
 			<div class="navbar-inner">
 				<a class="brand" href="">EDIT LAYOUT</a>
 				<ul class="nav">
 					<li>
 						<a class="thickbox"  href="<?php echo admin_url(); ?>?page=ultimatum-row-layouts&layout_id=<?php echo $_GET["layoutid"];?>&template_id=<?php echo $_GET['theme'];?>&TB_iframe=1&width=770&height=480" title="<?php _e('Click on row style you want to insert and then click insert button','ultimatum');?>"><?php _e('Insert Row','ultimatum');?></a>
 					</li>
 					<?php if($layout['type']=='full'){ ?>
 					<li class="dropdown" >
 						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('EDIT CSS','ultimatum');?><b class="caret"></b></a>
 						<ul class="dropdown-menu" role="menu" >
 							<li><a tabindex="-1" href="./admin.php?page=wonder-css&template_id=<?php echo $layout['theme'];?>"><?php _e('Template CSS','ultimatum');?></a></li>
 							<li><a tabindex="-1" href="./admin.php?page=wonder-css&layout_id=<?php echo $layout['id'];?>"><?php _e('Layout Specific CSS','ultimatum');?></a></li>
 						</ul>
 					</li>
 					<li class="dropdown">
 						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php _e('Custom CSS','ultimatum');?><b class="caret"></b></a>
 						<ul class="dropdown-menu" role="menu" >
 						<li><a href="./index.php?page=ultimatum-custom-css&template_id=<?php echo $layout['theme'];?>&modal=true&TB_iframe=1&width=640&height=380" class="thickbox" title="<?php _e('Type your Custom CSS','ultimatum');?>"><?php _e('Template wide Custom CSS','ultimatum');?></a></li>
 						<li><a class="thickbox"  href="./index.php?page=ultimatum-custom-css&layout_id=<?php echo $layout["id"];?>&modal=true&TB_iframe=1&width=640&height=380" title="<?php _e('Type your Custom CSS','ultimatum');?>">
 						<?php _e('Layout Specific Custom CSS','ultimatum');?></a></li>
 						</ul>
 					</li>
 					<?php } ?>
                    <?php if($layout['type']!='part'){ ?>
                    <li>
                        <a class="thickbox" id="layout-opts-link" href="<?php echo admin_url(); ?>?page=ultimatum-layout-options&layout_id=<?php echo $_GET["layoutid"];?>&template_id=<?php echo $_GET['theme'];?>&TB_iframe=1&width=770&height=480" title="<?php _e('Layout Options and extra classes','ultimatum');?>"><?php _e('Layout Options','ultimatum');?></a>
                    </li>
                    <?php } ?>
 					<li>
 						<a href="admin.php?page=wonder-layout&theme=<?php echo $layout["theme"];?>"><?php _e('Back to Layouts Screen','ultimatum');?></a>
 					</li>
 				</ul>
 			</div>
 		</div>
 	</div>

			<form action="" method="post" id="layout-form">
				<label for="layout-name"><?php _e('Layout Name','ultimatum');?>: </label>
				<input type="hidden" name="id" id="layoutid" value="<?php echo $layout["id"];?>"/>
				<input type="text" name="layoutname" id="layoutname" value="<?php echo $layout["title"];?>" size="50" />
				<input type="hidden" name="rows" id="layout_row_ids" value="<?php echo $layout["rows"];?>"/>
				<input type="hidden" name="before" id="before_main" value="<?php echo $layout["before"];?>"/>
				<input type="hidden" name="after" id="after_main" value="<?php echo $layout["after"];?>"/>
				<input type="hidden" name="type" id="layout_type" value="<?php echo $layout['type'];?>" />
				<input type="hidden" name="default" id="isdefault" value="<?php echo $layout['default'];?>" />
				<input type="hidden" name="theme" id="theme" value="<?php echo $layout['theme'];?>" />
				<input type="hidden" name="saveandcontinue" value="no" />
				<input class="button-primary autowidth" type="submit" id="layosavebutton" value="<?php _e('Save Layout','ultimatum');?>"/>
			</form>
	<h2><?php _e('The Layout Body','ultimatum');?></h2>
	<div class="lay-gen-container <?php if(get_ultimatum_option('extras', 'element_position')){ echo 'bottom-elements'; }?>">
			<?php if($layoutid){?>
				<div class="widget-liquid-left">
					<div id="widgets-right" >
					<?php if($layout['type']=='part'){ ?>
					<div id="body_cont" class="connectedSortable"  >  
					<?php
					if(strlen($layout['rows'])>>1):
					$rows = explode(',',$layout["rows"]);
					if(count($rows)!=0):
					foreach ($rows as $row){
					$rowito= explode('-',$row);
					
					$row_id = $rowito[1];				
					$query = "SELECT * FROM $tablerows WHERE id='$row_id'";
					$row = $wpdb->get_row($query,ARRAY_A);
					include (ULTIMATUM_ADMIN.DS.'ajax'.DS.'row-generator.php');
					
					}
					endif;
					endif;
					?>
					</div>
					<?php  } else { ?>
					<div style="width:100%;float:left;background-color:#FCF8E3;">
					<div style="padding:0 10px 10px 10px;">
					<small>Header</small>
					<div id="header_cont" class="connectedSortable" style="min-height: 10px;"> 
					<?php
					if(strlen($layout['before'])>>1):
					$rows = explode(',',$layout["before"]);
					
					foreach ($rows as $row){
					$rowito= explode('-',$row);
					if($rowito[0]=='row'){	
					$row_id = $rowito[1];				
					$query = "SELECT * FROM $tablerows WHERE id='$row_id'";
					$row = $wpdb->get_row($query,ARRAY_A);
					include (ULTIMATUM_ADMIN.DS.'ajax'.DS.'row-generator.php');
					} else {
					printLayoutasRow($rowito[1]);
					}
					}
					endif;
					?>
					</div>
					</div>
					</div>
					<div style="width:100%;float:left;background-color:#D9EDF7;">
					<div style="padding:0 10px 10px 10px;">
					<small>Body</small>
					<div id="body_cont" class="connectedSortable"  style="min-height: 10px;">  
					<?php
					if(strlen($layout['rows'])>>1):
					$rows = explode(',',$layout["rows"]);
					foreach ($rows as $row){
					$rowito= explode('-',$row);
					if($rowito[0]=='row'){	
					$row_id = $rowito[1];				
					$query = "SELECT * FROM $tablerows WHERE id='$row_id'";
					$row = $wpdb->get_row($query,ARRAY_A);
					include (ULTIMATUM_ADMIN.DS.'ajax'.DS.'row-generator.php');
					} else {
					printLayoutasRow($rowito[1]);
					}
					}
					endif;
					?>
					</div>
					</div>
					</div>
					<div style="width:100%;float:left;background-color:#DFF0D8;">
					<div  style="padding:0 10px 10px 10px;">
					<small>Footer</small>
					<div id="footer_cont" class="connectedSortable"  style="min-height: 10px;">  
					<?php
					if(strlen($layout['after'])>>1):
					$rows = explode(',',$layout["after"]);
					foreach ($rows as $row){
					$rowito= explode('-',$row);
					if($rowito[0]=='row'){	
					$row_id = $rowito[1];				
					$query = "SELECT * FROM $tablerows WHERE id='$row_id'";
					$row = $wpdb->get_row($query,ARRAY_A);
					include (ULTIMATUM_ADMIN.DS.'ajax'.DS.'row-generator.php');
					} else {
					printLayoutasRow($rowito[1]);
					}
					}
					endif;
					?>
					</div>
					
					</div>
					</div>	
					<?php } ?>
					</div>
				</div>
				<div class="widget-liquid-right">
				<div id="widgets-left">
					<?php if($layout["type"]=='full'){?>
					<div id="partial-layos" class="widgets-holder-wrap">
						<div class="sidebar-name">
						<div class="sidebar-name-arrow"><br /></div>
						<h3><?php _e('Available Parts','ultimatum');?></h3></div>
						<div class="layout-holder">
						<div id="parts">
						<?php printPartial($layout);?>	
						</div>
						<br class='clear' />
						</div>
						<br class="clear" />
					</div>
					<?php } ?>
					<div id="available-widgets" class="widgets-holder-wrap">
						<div class="sidebar-name">
						<div class="sidebar-name-arrow"><br /></div>
						<h3><?php _e('Widgets','ultimatum');?> <span id="removing-widget"><?php _ex('Deactivate', 'removing-widget', 'ultimatum'); ?> <span></span></span></h3></div>
						<div class="widget-holder">
						<div id="widget-list">
						<?php ultimatum_list_widgets(); ?>
						</div>
						<br class='clear' />
						</div>
						<br class="clear" />
					</div>
				</div>
				</div>
				
				
				<br class="clear" />
				<form action="" method="post">
				<?php wp_nonce_field( 'save-sidebar-widgets', '_wpnonce_widgets', false ); ?>
				</form>
				<?php } ?>
				</div>

<?php
do_action('ult_layout_builder_after');
}

function curPageURL() {
 $pageURL =$_SERVER["REQUEST_URI"];
 
 return $pageURL;
}

function printPartial($layout){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$query = "SELECT * FROM $table WHERE `type`='part' AND `theme`='$layout[theme]'";
	$result = $wpdb->get_results($query,ARRAY_A);
	foreach ($result as $fetch){
	?>
	<div id="layout-<?php echo $fetch["id"];?>" data-id="layout-<?php echo $fetch["id"];?>" class="partial_layo">
		<div class="partial-layout-title">
			<h4><?php echo $fetch['title']; ?></h4>
		</div>
		<div class="row-container partial_layout" style="height:55px">
			<div class="row-options">
				<div class="drag"><i class="fa fa-arrows"></i></div>
				<div class="poppover">
					<i class="fa fa-trash delete-part"></i>
				</div>
			</div>
			<div class="row-content">
				<table class="admin_preview" width="100%">
					<tr valign="top">
						<td width="100%" style="text-align: center">
							<h3><?php echo $fetch['title'];?><span style="font-size:12px;font-weight:normal;float:right;margin-right:10px;"><a href="./admin.php?page=wonder-layout&task=edit&theme=<?php echo $fetch['theme'];?>&layoutid=<?php echo $fetch['id'];?>">Edit Layout</a></span></h3>
						</td>
					</tr>	
				</table>
			</div>
		</div>
	</div>
	<?php 
	}	
}

function ultimatum_list_widgets() {
	global $wp_registered_widgets, $sidebars_widgets, $wp_registered_widget_controls;
	$sort = $wp_registered_widgets;
	usort( $sort, '_sort_name_callback_ultimatum' );
	$done = array();
	foreach ( $sort as $widget ) {
		if ( in_array( $widget['callback'], $done, true ) ) // We already showed this multi-widget
			continue;
		$sidebar = is_active_widget( $widget['callback'], $widget['id'], false, false );
		$done[] = $widget['callback'];
		if ( ! isset( $widget['params'][0] ) )
			$widget['params'][0] = array();
		$args = array( 'widget_id' => $widget['id'], 'widget_name' => $widget['name'], '_display' => 'template' );
		if ( isset($wp_registered_widget_controls[$widget['id']]['id_base']) && isset($widget['params'][0]['number']) ) {
			$id_base = $wp_registered_widget_controls[$widget['id']]['id_base'];
			$args['_temp_id'] = "$id_base-__i__";
			$args['_multi_num'] = ult_next_widget_id_number($id_base);
			$args['_add'] = 'multi';
		} else {
			$args['_add'] = 'single';
			if ( $sidebar )
				$args['_hide'] = '1';
		}
		$args = wp_list_widget_controls_dynamic_sidebar( array( 0 => $args, 1 => $widget['params'][0] ) );
		
		call_user_func_array( 'wp_widget_control', $args );
	}
}
function _sort_name_callback_ultimatum( $a, $b ) {
	return strnatcasecmp( $b['name'], $a['name'] );
}

function themeName($id){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_themes';
	$sql = "SELECT * FROM $table WHERE  `id`='$id'";
	$theme = $wpdb->get_row($sql,ARRAY_A);
	echo $theme['name'];
}

function printLayoutasRow($id){
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
$sql = "SELECT * FROM $table WHERE  `id`='$id'";
$layout = $wpdb->get_row($sql,ARRAY_A);
?>
<div id="layout-<?php echo $id;?>">
	<div class="row-container partial_layout" style="height:55px">
		<div class="row-options">
			<div class="drag"><i class="fa fa-arrows"></i></div>
			<div class="poppover">
				<i class="fa fa-trash delete-part"></i>
			</div>
		</div>
		<div class="row-content">
			<table class="admin_preview" width="100%">
				<tr valign="top">
					<td width="100%" style="text-align: center">
					<h3><?php echo $layout['title'];?> <span style="font-size:12px;font-weight:normal;float:right;margin-right:10px;"><a href="./admin.php?page=wonder-layout&task=edit&theme=<?php echo $layout['theme'];?>&layoutid=<?php echo $layout['id'];?>">Edit Layout</a></span></h3>
					
					</td>
				</tr>	
			</table>
		</div>
	</div>
</div>
<?php 
}


