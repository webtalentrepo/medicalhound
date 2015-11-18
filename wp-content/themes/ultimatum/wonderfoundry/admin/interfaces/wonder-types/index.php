<?php 
function curPageURL() {
 $pageURL = $_SERVER["REQUEST_URI"];
 return $pageURL;
}
function PostTypes(){
	echo '<div class="wrap ultwrap">';?>
	<script LANGUAGE="JavaScript">
			<!--
			function confirmSubmit()
			{
			var agree=confirm("<?php _e('Are you sure you wish to delete?', 'ultimatum');?>");
			if (agree)
				return true ;
			else
				return false ;
			}
			// -->
			</script>
	<?php
	$defpage='./admin.php?page=wonder-types';
	$task=false;
	if(isset($_GET['task'])) $task = $_GET['task'];
	
	?>
		<div class="ultadmnavi" style="position:absolute;top:0;width:100%;margin-right:25px;">
	 		<div class="navbar">
	 			<div class="navbar-inner">
	 				<a class="brand" href="<?php echo $defpage;?>"><i class="fa fa-folder-open"></i>&nbsp;<?php _e('Custom Post Types','ultimatum');?></a>
	 				<ul class="nav">
	 				<?php if(!$task):?>
		 				<li <?php if($task=="edit") echo ' class="active"' ;?>>
		 					<a href="<?php echo $defpage.'&task=editptype'; ?>"><?php _e('Create a Post Type','ultimatum');?></a>
		 				</li>
		 			<?php endif;?>
	 				</ul>
	 			</div>
	 		</div>
	 	</div>
	 	<p></p>
	 <?php 
	if(isset($_REQUEST["task"])){
		$task = $_REQUEST["task"];
	} else {
		$task=false;
	}
	switch ($task) {
		case 'editptype':
			editpostType();
		break;
		case 'edittax':
			edittaxType();
		break;
		default:
		global $wpdb;
		$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_ptypes';
		$table2 = $wpdb->prefix.ULTIMATUM_PREFIX.'_tax';	
		if($_POST){
			if($_POST[action]=='delptype'){
				// delete post type
				$delete = "DELETE  FROM $table WHERE `name`='$_POST[delptype]'";
				$r = $wpdb->query($delete);
				$url = curPageURL();
				//delete taxonomies of post type
				$delete = "DELETE  FROM $table2 WHERE `pname`='$_POST[delptype]'";
				$r = $wpdb->query($delete);
			}
			if($_POST[action]=='delcptax'){
				//delete tax type
				$delete = "DELETE  FROM $table2 WHERE `tname`='$_POST[delcptax]'";
				$r = $wpdb->query($delete);
				$url = curPageURL();
			}
			?>
			<script language="JavaScript">
				parent.location.href='<?php echo $url; ?>';
			</script>
			<?php 
		}
		flush_rewrite_rules(false);
		
		$query = "SELECT * FROM $table";
		$result = $wpdb->get_results($query,ARRAY_A);
		
		echo '<table class="table table-bordered">';
		echo '<thead>';
		//<th style="text-align:right;" width="150"><a href="admin.php?page=wonder-types&task=editptype" class="button-primary">'.__('Add Post Type', 'ultimatum').'</a></td>
		echo '<tr class="info">
				<td width="150">'.__('Custom Post Type', 'ultimatum').'</td><td>'.__('Taxonomies', 'ultimatum').'</td><td></td>
				</tr>';
		echo '</thead>';
		echo '<tbody>';
		foreach ($result as $ptypes){
			$properties = unserialize($ptypes["properties"]);
			echo '<tr>
					<td style="font-size:14px"><a href="admin.php?page=wonder-types&task=editptype&name='.$ptypes["name"].'">'.$properties["label"].'</a></td>
					<td>'.getTaxes($ptypes["name"]).'</td>
					<td align="right">
		 			<form method="post" action="">
		 			<input type="hidden" name="action" value="delptype" /><input type="hidden" name="delptype" value="'.$ptypes["name"].'" />
					<div class="btn-group templateactions">
		 				<a href="admin.php?page=wonder-types&task=editptype&name='.$ptypes["name"].'" class="btn-primary btn">'.__('Edit Post Type', 'ultimatum').'</a>
	 					<a href="admin.php?page=wonder-types&task=edittax&name='.$ptypes["name"].'" class="btn-info btn">'.__('Add Taxonomy', 'ultimatum').'</a>
						<input type="submit" value="'.__('Delete Post Type', 'ultimatum').'" class="btn-danger btn" style="height:30px;" onClick="return confirmSubmit()" />
					</div>
					</form>
						</td></tr>';
		}
		echo '</tbody>';
		echo '</table>';
		break;
	}
	echo '</div>';
}
function getTaxes($name=null){
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_tax';	
$query = "SELECT * FROM $table WHERE pname='$name'";
$result = $wpdb->get_results($query,ARRAY_A);
$taxes='';
foreach ($result as $f){
	$taxes .= '<div style="margin-right:10px;height:25px;line-height:25px;padding:5px;background:#d3d3d3;border-radius:4px;width:auto;float:left;"><span style="font-size:14px;float:left;margin-right:5px;">'.$f["tname"].'</span><a href="admin.php?page=wonder-types&task=edittax&tname='.$f["tname"].'&name='.$f["pname"].'" class="button-secondary" style="float:left; font-size: 12px;line-height: 18px;padding: 3px 8px;">'.__('Edit', 'ultimatum').'</a>&nbsp;<div style="float:left"><form method="post" action="" ><input type="hidden" name="action" value="delcptax" /><input type="hidden" name="delcptax" value="'.$f["tname"].'" /><input type="submit" value="'.__('Delete', 'ultimatum').'" class="button-secondary" onClick="return confirmSubmit()" style="float:left"/></form></div></div>';
}
return $taxes;
}


function edittaxType(){
global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_tax';
		if($_POST){
			if(!$_GET["tname"]){
			$_POST["custom_tax"]["name"]=$_POST["pname"].'_'.$_POST["custom_tax"]["name"];
			}
			$name = str_replace($_POST[pname].'_', '',$_POST["custom_tax"]["name"]);
			
			if(!$_POST["custom_tax"]["slug"]){
				$_POST["custom_tax"]["slug"] = $name;
			}
			$properties = serialize($_POST["custom_tax"]);
			if(!$name || !$_POST["custom_tax"]["singular_label"] || !$_POST["custom_tax"]["label"]){
				?><script language="JavaScript">
					alert('Please fill in all Fields');
				</script>	
				<?php 
			} else {
			$ins = "REPLACE INTO $table VALUES('$name','$_POST[pname]','$properties')";
			$wpdb->query($ins);
			$url = 'admin.php?page=wonder-types';
			
		?>
		<script language="JavaScript">
			parent.location.href='<?php echo $url; ?>';
		</script>
		<?php
			} 
		}
		if(isset($_GET["tname"])){
			$query = "SELECT * FROM $table WHERE tname='$_GET[tname]'";
			$fetch=$wpdb->get_row($query,ARRAY_A);
			$properties = unserialize($fetch["properties"]);
			foreach ($properties as $key=>$value){
			 $$key = $value;
			}
		}
	?>
	<form method="post" action="">
	<input name="pname" type="hidden" value="<?php echo $_GET["name"];?>">
	<table class="table-bordered table">
                    <tr valign="top">
                    <td scope="row"><?php _e('Taxonomy Name', 'ultimatum') ?> <span style="color:red;">*</span></td>
                    <td><input type="text" name="custom_tax[name]" tabindex="21" <?php if (isset($name)) { echo 'value="'.esc_attr($name).'" disabled="disabled"'; } ?> /></td><td><?php _e('The taxonomy name.  Used to retrieve custom taxonomy content.  Should be short and sweet (e.g. actors)', 'ultimatum');?></td>
                    </tr>

                   <tr valign="top">
                    <td scope="row"><?php _e('Label', 'ultimatum') ?></td>
                    <td><input type="text" name="custom_tax[label]" tabindex="22" value="<?php if (isset($label)) { echo esc_attr($label); } ?>" /></td><td><?php _e('Taxonomy label.  Used in the admin menu for displaying custom taxonomy. (e.g. Actors)', 'ultimatum');?></td>
                    </tr>

                   <tr valign="top">
                    <td scope="row"><?php _e('Singular Label', 'ultimatum') ?></td>
                    <td><input type="text" name="custom_tax[singular_label]" tabindex="23" value="<?php if (isset($singular_label)) { echo esc_attr($singular_label); } ?>" /></td><td><?php _e('Taxonomy Singular label.  Used in WordPress when a singular label is needed. (e.g. Actor)', 'ultimatum');?></td>
                    </tr>
					<tr valign="top">
                    <td scope="row"><?php _e('Rewrite Slug', 'ultimatum') ?></td>
                    <td><input type="text" name="custom_tax[slug]" tabindex="23" value="<?php if (isset($slug)) { echo esc_attr($slug); } ?>" /></td><td><?php _e('Rewrite slug for your Taxonomy use no spaces and all small lettters leave blank if you want it created from your Taxonomy name', 'ultimatum');?></td>
                    </tr>
                    
                </table>

                <p class="submit">
                <?php if (isset($name)) { ?>
                	<input type="hidden" name="custom_tax[name]" value="<?php echo $name;?>" />
                <?php } ?>
                	<input type="submit" class="button-primary" tabindex="29" value="<?php _e('Save Taxonomy', 'ultimatum') ?>" />
                </p>
            </form>
	<?php
}


function editpostType(){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_ptypes';
		if($_POST){
			if(!$_POST["custom_post_type"]["slug"]){
				$_POST["custom_post_type"]["slug"] = $_POST["custom_post_type"]["name"];
			}
			$properties = serialize($_POST["custom_post_type"]);
			$name = strtolower(str_replace(' ','',$_POST["custom_post_type"]["name"]));
			$ins = "REPLACE INTO $table VALUES('$name','$properties')";
			$wpdb->query($ins);
			$url = 'admin.php?page=wonder-types';
			flush_rewrite_rules(false);
		?>
		<script language="JavaScript">
			parent.location.href='<?php echo $url; ?>';
		</script>
		<?php 
		}
		if(isset($_GET["name"])){
			$name = $_GET["name"];
			$query = "SELECT * FROM $table WHERE name='$_GET[name]'";
			$fetch = $wpdb->get_row($query,ARRAY_A);
			$properties = unserialize($fetch["properties"]);
			foreach ($properties as $key=>$value){
			 $$key = $value;
			}
		}
		?>
            <form method="post" action="">
            	<table class="table-bordered table">
            	    <tr valign="top">
                    <th scope="row"><?php _e('Post Type Name', 'ultimatum') ?> <span style="color:red;">*</span></th>
                    <td colspan="2">
                    	<input type="text" name="custom_post_type[name]" tabindex="1" <?php if (isset($name)) { echo 'value="'.esc_attr($name).'" disabled="disabled"'; } ?> /><?php _e('The post type name.  Used to retrieve custom post type content.  Should be short and sweet.(e.g. movies)', 'ultimatum');?>
                    	<?php if (isset($name)) { echo '<input type="hidden" name="custom_post_type[name]" tabindex="1" value="'.esc_attr($name).'" />'; } ?>
                    
                    </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row"><?php _e('Label', 'ultimatum') ?></th>
                    <td colspan="2"><input type="text" name="custom_post_type[label]" tabindex="2" value="<?php if (isset($label)) { echo esc_attr($label); } ?>" /><?php _e('Post type label.  Used in the admin menu for displaying post types.(e.g. Movies)', 'ultimatum');?></td>
                    </tr>
	                <tr valign="top">
                    <th scope="row"><?php _e('Singular Label', 'ultimatum') ?></th>
                    <td colspan="2"><input type="text" name="custom_post_type[singular_label]" tabindex="3" value="<?php if (isset($singular_label)) { echo esc_attr($singular_label); } ?>" /><?php _e('Custom Post Type Singular label.  Used in WordPress when a singular label is needed. (e.g. Movie)', 'ultimatum');?></td>
                    </tr>
                     </tr>
	                <tr valign="top">
                    <th scope="row"><?php _e('Rewrite Slug', 'ultimatum') ?></th>
                    <td colspan="2"><input type="text" name="custom_post_type[slug]" tabindex="3" value="<?php if (isset($slug)) { echo esc_attr($slug); } ?>" /><?php _e('Rewrite slug for your Post Type use no spaces and all small lettters leave blank if you want it created from your post type name', 'ultimatum');?></td>
                    </tr>
            	    <tr valign="top">
                    <th scope="row" colspan="3"><?php _e('Supports', 'ultimatum') ?></th>
                    </tr>
                    <tr><th scope="row"><?php _e('Title', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="11" value="title" <?php if (isset($supports) && is_array($supports)) { if (in_array('title', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; } ?> /></div></td><td><?php _e('Adds the title meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Editor', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="12" value="editor" <?php if (isset($supports) && is_array($supports)) { if (in_array('editor', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; } ?> /></div></td><td><?php _e('Adds the content editor meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Excerpt', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="13" value="excerpt" <?php if (isset($supports) && is_array($supports)) { if (in_array('excerpt', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; } ?> /></div></td><td><?php _e('Adds the excerpt meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Trackbacks', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="14" value="trackbacks" <?php if (isset($supports) && is_array($supports)) { if (in_array('trackbacks', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; } ?> /></div></td><td><?php _e('Adds the trackbacks meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Custom Fields', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="15" value="custom-fields" <?php if (isset($supports) && is_array($supports)) { if (in_array('custom-fields', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; }  ?> /></div></td><td><?php _e('Adds the custom fields meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Comments', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="16" value="comments" <?php if (isset($supports) && is_array($supports)) { if (in_array('comments', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; }  ?> /></div></td><td><?php _e('Adds the comments meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Revisions', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="17" value="revisions" <?php if (isset($supports) && is_array($supports)) { if (in_array('revisions', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; }  ?> /></div></td><td><?php _e('Adds the revisions meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Featured Image', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="18" value="thumbnail" <?php if (isset($supports) && is_array($supports)) { if (in_array('thumbnail', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; }  ?> /></div></td><td><?php _e('Adds the featured image meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Author', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[supports][]" tabindex="19" value="author" <?php if (isset($supports) && is_array($supports)) { if (in_array('author', $supports)) { echo 'checked="checked"'; } }elseif (!isset($_GET['edittype'])) { echo 'checked="checked"'; }  ?> /></div></td><td><?php _e('Adds the author meta box when creating content for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Categories', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[categories]" tabindex="19" value="categories" <?php if (isset($categories)) { echo 'checked="checked"';  }  ?> /></div></td><td><?php _e('Adds categories for this custom post type', 'ultimatum');?></td></tr>
                    <tr><th scope="row"><?php _e('Tags', 'ultimatum');?></th><td><div class="make-switch switch-small" data-on="success" data-off="warning"><input type="checkbox" name="custom_post_type[tags]" tabindex="19" value="post_tags" <?php if (isset($tags)) { echo 'checked="checked"';  } ?> /></div></td><td><?php _e('Adds tags for this custom post type', 'ultimatum');?></td></tr>
                    
                 </table>
                    <p class="submit">
                    
                <input type="submit" class="button-primary" value="<?php _e('Save Post Type', 'ultimatum') ?>" />
                </p>
            </form>
		<?php 
	
}
