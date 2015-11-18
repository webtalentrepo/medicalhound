<?php

function ultimatum_library_help() {
	$file = ULTIMATUM_ADMIN_HELP.'/library.php';
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

add_action('contextual_help', 'ultimatum_library_help', 10);
function wonderLibrary(){
	$task='';
	echo '<div class="wrap ultwrap">';
	if(isset($_GET["task"])){
		$task=$_GET["task"];
		include($task.'.php');
	} else {
		wonderLibHome($task);
	}
	echo '</div>';
}

function wonderLibHome($task){
	$defpage="admin.php?page=wonder-library";
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
	
}