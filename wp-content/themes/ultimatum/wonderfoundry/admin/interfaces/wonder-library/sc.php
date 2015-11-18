<?php 
$defpage="admin.php?page=wonder-library";
$task='';
if(isset($_GET["task"])){
	$task=$_GET["task"];
}
?>
<div class="ultadmnavi" style="position:absolute;top:0;width:100%;margin-right:25px;">
 		<div class="navbar">
 			<div class="navbar-inner">
 				<a class="brand" href="<?php echo $defpage;?>"><i class="fa fa-book"></i>&nbsp;LIBRARY</a>
 				<ul class="nav">
 					
 					<li <?php if($task=='fonts') echo ' class="active"' ;?>>
 						<a href="admin.php?page=wonder-fonts"><i class="fa fa-font"></i><?php _e('Fonts','ultimatum');?></a>
 					</li>
 					<li <?php if($task=="icons") echo ' class="active"' ;?>>
 						<a href="<?php echo $defpage.'&task=icons'; ?>"><i class="fa fa-lightbulb"></i><?php _e('Icons','ultimatum');?></a>
 					</li>
 					<li <?php if($task=="sc") echo ' class="active"' ;?>>
 						<a href="<?php echo $defpage.'&task=sc'; ?>"><i class="fa fa-magic"></i><?php _e('Shortcodes','ultimatum');?></a>
 					</li>
 				</ul>	
 			</div>
 		</div>
 	</div>
<?php
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_sc';
// Add delete

$query = "SELECT * FROM `$table`";
$results = $wpdb->get_results($query);
if($results){
	echo '<h3>Your saved ShortCodes</h3><table class="widefat">';
	echo '<thead><tr><th>Name</th><th>Type</th><th style="width:130px;">Actions</th></tr></thead>';
	echo '<tbody>';
	foreach ($results as $result){
	$link = get_bloginfo('siteurl').'/index.php?uscpreviewcode=true&type='.$result->type;
	$properties = unserialize($result->properties);
	foreach ($properties as $p=>$value){
		$link .= '&'.$p.'='.$value;
	}
	$link.='&TB_iframe=1&width=770&height=480';
		echo '<tr><td>'.$result->name.'</td><td>'.$result->type.'</td><td>';
		echo '<form method="post" action="">
	<input type="hidden" name="action" value="delete" /><input type="hidden" name="delid" value="'.$result->id.'" />
	<div class="btn-group">
	<button " style="height:30px !important" class="btn btn-danger" onClick="return confirmSubmit()" ><i class="fa fa-trash"></i></button>
	<a href="'.$link.'" class="thickbox btn btn-primary"><i class="fa fa-external-link"></i> '
	.__('Preview', 'ultimatum').'</a>
	
	</div>
	</form>';
		echo '</td></tr>';
	}
	echo "</tbody></table>";
} else {
	echo "<h3>You don't seem to have any shortcodes saved yet.</h3>";
}