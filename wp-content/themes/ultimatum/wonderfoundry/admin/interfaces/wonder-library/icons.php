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
 				<a class="brand" href=""><i class="fa fa-book"></i>&nbsp;LIBRARY</a>
 				<ul class="nav">
 					
 					<li <?php if($task=='fonts') echo ' class="active"' ;?>>
 						<a href="admin.php?page=wonder-fonts"><i class="fa fa-font"></i><?php _e('Fonts','ultimatum');?></a>
 					</li>
 					<li <?php if($task=="icons") echo ' class="active"' ;?>>
 						<a href="<?php echo $defpage.'&task=icons'; ?>"><i class="fa fa-lightbulb"></i><?php _e('Icons','ultimatum');?></a>
 					</li>
 				</ul>	
 			</div>
 		</div>
 	</div>
<?php
$folder = ULTIMATUM_LIBRARY_DIR.'/images/icons/48/';
$folder32 = ULTIMATUM_LIBRARY_DIR.'/images/icons/32/';
$folder24 = ULTIMATUM_LIBRARY_DIR.'/images/icons/24/';
$folder16 = ULTIMATUM_LIBRARY_DIR.'/images/icons/16/';
$folderi = ULTIMATUM_LIBRARY_DIR.'/images/icons/';
$form = false;
if(is_multisite()){
	if(current_user_can("manage_network")){
		$form = true;
	}
} else { 
	if(current_user_can('manage_options')) {
		$form = true;
	}	
}
if($form && $_POST['action']=='delete'){
	$filename = $folder.$_POST['icon'].'.png';
	if(file_exists($filename)) unlink($filename);
	$filename = $folder32.$_POST['icon'].'.png';
	if(file_exists($filename)) unlink($filename);
	$filename = $folder24.$_POST['icon'].'.png';
	if(file_exists($filename)) unlink($filename);
	$filename = $folder16.$_POST['icon'].'.png';
	if(file_exists($filename)) unlink($filename);
}	
$handle = opendir($folder);
if ($handle) {
	while (false !== ($entry = readdir($handle))) {
		if ($entry != "." && $entry != ".." && stripos($entry,".png")) {
			if(file_exists($folderi.'32/'.$entry) && file_exists($folderi.'24/'.$entry) && file_exists($folderi.'16/'.$entry)){
				$icons[]=str_replace('.png', '', $entry);
			}
		}
	}
	closedir($handle);
}
asort($icons);
foreach($icons as $icon){
	echo '<div style="width:150px;height:100px;float:left;border:1px solid #ececec;background:#e7e7e7;margin:5px;text-align:center;padding:10px;">';
	echo '<div>'.$icon."</div>";
	echo '<img src="'.ULTIMATUM_LIBRARY_URI.'/images/icons/48/'.$icon.'.png"  />';
	if($form){
	echo '<div><form action="" method="post"><input type="hidden" name="action" value="delete" /><input type="hidden" name="icon" value="'.$icon.'" /><button class="btn btn-danger "><i class="fa fa-trash"></i>&nbsp;Delete</button></form></div>';
	}
	echo '</div>';
}