<?php
/**
 * Developers License Functions
 */

function devsettings($defpage,$task){
	?>
	<li class="divider"></li>
 	<li><a <?php if($task=="mobapp") echo ' class="active"' ;?> tabindex="-1" href="<?php echo $defpage.'&task=mobapp'; ?>"><?php _e('Mobile Icons','ultimatum');?></a></li>
	<?php
}



