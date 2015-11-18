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
global $wpdb;
$query = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='full' AND `theme`='$theme' ORDER BY `default` DESC, `title` ASC";
$result = $wpdb->get_results($query,ARRAY_A);
$queryp = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT."` WHERE `type`='part' AND `theme`='$theme' ORDER BY `title` ASC";
$resultp = $wpdb->get_results($queryp,ARRAY_A);
foreach($result as $layout){
	$full[]=$layout;
	$lid = $layout["id"];
}
?>
<h3><?php _e('Full Layouts','ultimatum');?></h3>
	<table class="widefat ult-tables">
	<thead>
	<tr class="info">
		<th><?php _e('Layout Name','ultimatum');?></th>
		<th><?php _e('Assigned to','ultimatum');?></th>
	</tr>
	</thead>
	<tbody>
	<?php 
	if($full){
	$count = 1;
	$class = '';
	foreach($full as $layout){
		$class = ( $count % 2 == 0 ) ? '' : ' class="alternate"';
		if($layout['default']==1){ $class =' class="active"';}
		echo '<tr'.$class.'>';	
		echo '<th>';
		echo '<a href="./admin.php?page=wonder-layout&task=edit&theme='.$theme.'&layoutid='.$layout["id"].'">'.$layout["title"].'</a>';
		echo '<div class="row-actions">';
		echo '<form method="post" action="" class="layoutactions">';
		echo '<a href="./admin.php?page=wonder-layout&task=edit&theme='.$theme.'&layoutid='.$layout["id"].'" class=""><i class="fa fa-edit"></i> '.__('Edit ','ultimatum').'</a>  | ';
		echo '<a class="clonelayout" data-layout="'.$layout["id"].'"><i class="fa fa-copy"></i> '.__('Clone','ultimatum').'</a>  |  ';
		echo '<input type="hidden" name="action" value="" class="action" />';
		echo '<input type="hidden" name="layoutid" value="'.$layout["id"].'" />';
		echo '<a class=" deletelayout" data-layout="'.$layout["id"].'"><i class="fa fa-trash"></i> Delete</a> | ';
		if($layout['default']!='1'){
			echo'<a class="setdefault" data-template="'.$theme.'" data-layout="'.$layout["id"].'"><i class="fa fa-ok-sign"></i> '.__('Set Default','ultimatum').'</a>';
		}
		
		
		echo '</form>';
		echo '</div>';
		echo '</td>';
		echo '<td>';
		$getassigned = "SELECT * FROM `".ULTIMATUM_TABLE_LAYOUT_ASSIGN."`  WHERE `layout_id`='$layout[id]'";
		$gres =$wpdb->get_results($getassigned,ARRAY_A);
		foreach ($gres as $gfecth){
			$posttypes[]=array($gfecth["post_type"],$gfecth["post_type"]);
		}
		if(isset($posttypes)){
		foreach($posttypes as $posttyped):
		?>
		<div class="assigned">
		<a href="admin.php?page=wonder-layout&delassigner=<?php echo $posttyped[1]; ?>&delposter=<?php echo $layout["id"]; ?>&theme=<?php echo $theme; ?>">x</a>
		<?php echo $posttyped[0];?>
		</div>
		<?php 
		endforeach;
		unset($posttypes);
		}
		echo '</td>';
		echo '</tr>';
		$count++;
	}
	}
	?>
	</tbody>
	</table>
	<h3><?php _e('Partial Layouts','ultimatum');?></h3>
	<table class="widefat">
	<thead>
	<tr class="info">
		<th><?php _e('Layout Name','ultimatum');?></th>
	</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach ($resultp as $layout){
		if($i!=1){
			echo '<tr class="alternate">';
			$i=1;
		} else {
			echo '<tr>';
			$i=2;
		}
		echo '<th>';
		echo '<a href="./admin.php?page=wonder-layout&task=edit&theme='.$theme.'&layoutid='.$layout["id"].'">'.$layout["title"].'</a>';
		echo '<div class="row-actions">';
		echo '<form method="post" action="" class="layoutactions">';
		echo '<a href="./admin.php?page=wonder-layout&task=edit&theme='.$theme.'&layoutid='.$layout["id"].'" ><i class="fa fa-edit"></i> '.__('Edit ','ultimatum').'</a> | ';
		echo '<a class="clonelayout" data-layout="'.$layout["id"].'"><i class="fa fa-copy"></i> '.__('Clone','ultimatum').'</a> | ';
		echo '<input type="hidden" name="action" value="" class="action" />';
		echo '<input type="hidden" name="layoutid" value="'.$layout["id"].'" />';
		echo '<a class="deletelayout" data-layout="'.$layout["id"].'"><i class="fa fa-trash"></i> Delete</a>';
		
		
		echo '</form>';
		echo '</div>';
		echo'</th>';
		echo '</tr>';
	}
	?>
	</tbody>
	</table>