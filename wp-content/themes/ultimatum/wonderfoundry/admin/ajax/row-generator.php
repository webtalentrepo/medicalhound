<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
this file under any circumstances.
*/

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.38
 */
 ?>
 <?php 
if (!function_exists('printrowEditor')) {
function printrowEditor($row,$full=null){
?>
<div class="row-options">
<div class="drag"><i class="fa fa-arrows"></i></div>
<div class="poppover">
<div class='cssmenu'>
  <ul>
     <li class='active'><i class="fa fa-edit"></i>
        <ul>
           <li class='has-sub '><a href='#'><?php echo 'Options for Row-'.$row;?></a>
           <li><a class="thickbox" href="<?php echo admin_url();?>index.php?page=ultimatum-css-gen&layoutid=<?php echo $_GET["layoutid"];?>&container=<?php echo 'wrapper-'.$row;?>&modal=true&TB_iframe=1&width=640&height=380">Wrapper CSS</a></li>
		   <?php if(!$full){?>
		   <li><a class="thickbox" href="<?php echo admin_url();?>index.php?page=ultimatum-css-gen&layoutid=<?php echo $_GET["layoutid"];?>&container=<?php echo 'container-'.$row;?>&modal=true&TB_iframe=1&width=640&height=380">Container CSS</a></li>
		   <?php } ?>
           <li><a class="delete-item" data-row="row-<?php echo $row;?>">Delete</a></li>
	  </ul>
  </li>
  </ul>
</div>
</div>
</div>
<?php 
}

}
if (!function_exists('printColEditor')) {
function printColEditor($row,$col){
?>
<div class="col_container">
	<div class="poppover">
		<small><?php echo 'col-'.$row.'-'.$col;?></small>
		<a class="close-popover thickbox" href="<?php echo admin_url();?>index.php?page=ultimatum-css-gen&layoutid=<?php echo $_GET["layoutid"];?>&container=<?php echo 'col-'.$row.'-'.$col;?>&modal=true&TB_iframe=1&width=640&height=380"><i class="fa fa-cog"></i></a>
	</div>
	<div class="col_content">
	<?php ultimate_wp_list_widget_controls('sidebar-'.$row.'-'.$col);?>
	</div>
</div>
<?php 
}
}
?>
<div id="row-<?php echo $row["id"];?>" class="rowsoflayout">
<?php switch($row["type_id"]){ ?>
<?php case '1': ?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="100%"><?php  printColEditor($row['id'],1);?></td>
			</tr>	
		</table>
	</div>
</div>
<?php break; ?>
<?php case '37': ?>
<div class="row-container">
	<?php printrowEditor($row['id'],'full');?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="100%"><?php  printColEditor($row['id'],1);?></td>
			</tr>	
		</table>
	</div>
</div>
<?php break; ?>
<?php case '2': ?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview">
            <tr valign="top">
                <td class="one_fourth"><?php  printColEditor($row['id'],1);?></td>
                <td class="one_fourth"><?php  printColEditor($row['id'],2);?></td>
                <td class="one_fourth"><?php  printColEditor($row['id'],3);?></td>
                <td class="one_fourth"><?php  printColEditor($row['id'],4);?></td>	
            </tr>	
        </table>
	</div>
</div>
<?php break; ?>
<?php case '3':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview" width="100%">
            <tr valign="top">
                <td width="33%"><?php  printColEditor($row['id'],1);?></td>
                <td width="33%"><?php  printColEditor($row['id'],2);?></td>
                <td width="33%"><?php  printColEditor($row['id'],3);?></td>
            </tr>	
        </table>
	</div>
</div>
<?php break; ?>
<?php case '4':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview" width="100%">
        <tr valign="top">
            <td width="50%"><?php  printColEditor($row['id'],1);?></td>
            <td width="50%"><?php  printColEditor($row['id'],2);?></td>
        </tr>	
        </table>
	</div>
</div>
<?php break; ?>
<?php case '5': ?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview" width="100%">
            <tr valign="top">
                <td class="one_fourth"><?php  printColEditor($row['id'],1);?></td>
                <td class="one_fourth"><?php  printColEditor($row['id'],2);?></td>
                <td width="50%"><?php  printColEditor($row['id'],3);?></td>
            </tr>
        </table>
	</div>
</div>
<?php break; ?>
<?php case '6': ?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
            <tr valign="top">
                <td width="50%"><?php  printColEditor($row['id'],1);?></td>
                <td class="one_fourth"><?php  printColEditor($row['id'],2);?></td>
                <td class="one_fourth"><?php  printColEditor($row['id'],3);?></td>
            </tr>
      </table>
	</div>
</div>
<?php break; ?>
<?php case '7': ?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview" width="100%">
        <tr valign="top">
            <td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
            <td width="50%"><?php printColEditor($row["id"],2);?></td>
            <td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
        </tr>	
        </table>
	</div>
</div>
<?php break; ?>
<?php case '8':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
				<td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
				<td width="75%"><?php printColEditor($row["id"],2);?></td>
	  </tr>	
	  </table>
</div>
</div>
<?php break; ?>
<?php case '9':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
    <table class="admin_preview" width="100%">
        <tr valign="top">
            <td width="75%"><?php printColEditor($row["id"],1);?></td>
            <td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
        </tr>	
    </table>
    </div>
</div>
<?php break; ?>
<?php case '10':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview" width="100%">
            <tr valign="top">
            <td width="33%"><?php printColEditor($row["id"],1);?></td>
            <td width="66%"><?php printColEditor($row["id"],2);?></td>
            </tr>	
        </table>
    </div>
</div>
<?php break; ?>
<?php case '11':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="66%"><?php printColEditor($row["id"],1);?></td>
				<td width="33%"><?php printColEditor($row["id"],2);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '12':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],1);?></td>
				<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
				<td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
				<td class="one_fourth"><?php printColEditor($row["id"],4);?></td>
			</tr>	
			<tr>
				<td width="75%" colspan="3"><?php printColEditor($row["id"],5);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '13':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
				<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
				<td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
                <td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],4);?></td>
			</tr>
			<tr>
				<td width="75%" colspan="3"><?php printColEditor($row["id"],5);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '14':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],2);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],4);?></td>
		</tr>	
		<tr>
			<td width="50%" colspan="2"><?php printColEditor($row["id"],5);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '15':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
				<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
				<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],3);?></td>	
                <td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],4);?></td>
			</tr>
			<tr>
				<td width="50%" colspan="2"><?php printColEditor($row["id"],5);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '16':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
        <tr valign="top">
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>	
		<tr>
			<td width="50%" colspan="2"><?php printColEditor($row["id"],5);?></td>
		</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '17':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],1);?></td>
            <td width="50%"><?php printColEditor($row["id"],2);?></td>
            <td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
		</tr>	
		<tr>
			<td width="75%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '18':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
            <td width="50%"><?php printColEditor($row["id"],3);?></td>
		</tr>
		<tr>
			<td width="75%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '19':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
            <td width="50%"><?php printColEditor($row["id"],2);?></td>
            <td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],3);?></td>
		</tr>
		<tr>
			<td width="75%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '20':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="50%"><?php printColEditor($row["id"],1);?></td>
            <td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
			<td class="one_fourth" rowspan="2"><?php printColEditor($row["id"],3);?></td>
		</tr>	
		<tr>
			<td width="75%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '21':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="50%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
		</tr>
		<tr>
			<td width="50%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '22':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
			<td width="50%" rowspan="2"><?php printColEditor($row["id"],3);?></td>
		</tr>
		<tr>	
			<td width="50%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '23':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="33%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td width="33%"><?php printColEditor($row["id"],2);?></td>
			<td width="33%"><?php printColEditor($row["id"],3);?></td>
		</tr>
		<tr>
			<td width="66%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '24':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="33%"><?php printColEditor($row["id"],1);?></td>
            <td width="33%"><?php printColEditor($row["id"],2);?></td>
            <td width="33%" rowspan="2"><?php printColEditor($row["id"],3);?></td>
		</tr>	
		<tr>
			<td width="66%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '25':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="50%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td width="50%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>	
		<tr>
			<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],3);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '26':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="50%" colspan="2"><?php printColEditor($row["id"],4);?></td>
			<td width="50%" rowspan="2"><?php printColEditor($row["id"],3);?></td>
		</tr>	
		<tr>
			<td class="one_fourth"><?php printColEditor($row["id"],1);?></td>
			<td class="one_fourth"><?php printColEditor($row["id"],2);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '27':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
	<table class="admin_preview" width="100%">
		<tr valign="top">
			<td width="33%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
			<td width="66%" colspan="2"><?php printColEditor($row["id"],4);?></td>
		</tr>	
		<tr>
			<td width="33%"><?php printColEditor($row["id"],2);?></td>
			<td width="33%"><?php printColEditor($row["id"],3);?></td>
		</tr>
	</table>
	</div>
</div>
<?php break; ?>
<?php case '28':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="66%" colspan="2"><?php printColEditor($row["id"],4);?></td>
                <td width="33%" rowspan="2"><?php printColEditor($row["id"],3);?></td>
			</tr>	
			<tr>
				<td width="33%"><?php printColEditor($row["id"],1);?></td>
                <td width="33%"><?php printColEditor($row["id"],2);?></td>		
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '29':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="75%" colspan="3"><?php printColEditor($row["id"],1);?></td>
                <td width="25%" rowspan="2"><?php printColEditor($row["id"],2);?></td>
			</tr>	
			<tr>
				<td width="25%"><?php printColEditor($row["id"],3);?></td>
                <td width="25%"><?php printColEditor($row["id"],4);?></td>
                <td width="25%"><?php printColEditor($row["id"],5);?></td>		
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '30':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
                <td width="25%" rowspan="2"><?php printColEditor($row["id"],2);?></td>
                <td width="50%" colspan="2"><?php printColEditor($row["id"],3);?></td>
			</tr>	
			<tr>
				<td width="25%"><?php printColEditor($row["id"],4);?></td>
                <td width="25%"><?php printColEditor($row["id"],5);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '31':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="50%" colspan="2"><?php printColEditor($row["id"],1);?></td>
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],2);?></td>
                <td width="25%" rowspan="2"><?php printColEditor($row["id"],3);?></td>
			</tr>	
			<tr>
				<td width="25%"><?php printColEditor($row["id"],4);?></td>
                <td width="25%"><?php printColEditor($row["id"],5);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '32':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
				<td width="50%" colspan="2"><?php printColEditor($row["id"],2);?></td>
                <td width="25%" rowspan="2"><?php printColEditor($row["id"],3);?></td>
			</tr>	
			<tr>
				<td width="25%"><?php printColEditor($row["id"],4);?></td>
                <td width="25%"><?php printColEditor($row["id"],5);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '33':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
				<td width="75%" colspan="2"><?php printColEditor($row["id"],2);?></td>
			</tr>	
			<tr>
				<td width="50%"><?php printColEditor($row["id"],3);?></td>
                <td width="25%"><?php printColEditor($row["id"],4);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '34':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],1);?></td>
				<td width="75%" colspan="2"><?php printColEditor($row["id"],2);?></td>
			</tr>	
			<tr>
				<td width="25%"><?php printColEditor($row["id"],3);?></td>
				<td width="50%"><?php printColEditor($row["id"],4);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '35':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="75%" colspan="2"><?php printColEditor($row["id"],1);?></td>
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],2);?></td>
			</tr>	
			<tr>
				<td width="25%"><?php printColEditor($row["id"],3);?></td>
				<td width="50%"><?php printColEditor($row["id"],4);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php case '36':?>
<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
		<table class="admin_preview" width="100%">
			<tr valign="top">
				<td width="75%" colspan="2"><?php printColEditor($row["id"],1);?></td>
				<td width="25%" rowspan="2"><?php printColEditor($row["id"],2);?></td>
			</tr>	
			<tr>
				<td width="50%"><?php printColEditor($row["id"],3);?></td>
				<td width="25%"><?php printColEditor($row["id"],4);?></td>
			</tr>
		</table>
	</div>
</div>
<?php break; ?>
<?php default:
$row_extra = explode('_', $row["type_id"]);
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
$sql = "SELECT * from $table WHERE `template_id`='".$row_extra[0]."' AND `slug`= '".$row_extra[1]."'";
$extrarow = $wpdb->get_row($sql);
$columns = explode(',',$extrarow->grid);
if(count($columns)!=0){	
?>

<div class="row-container">
	<?php printrowEditor($row['id']);?>
	<div class="row-content">
        <table class="admin_preview">
            <tr valign="top">
            <?php 
            $ik=1;
            foreach ($columns as $column){
			$width = floor(100*($column/12));
			?>
			<td width="<?php echo $width;?>%"><?php  printColEditor($row['id'],$ik);?></td>
			<?php 
			$ik++;
			}
            
            ?>
               
            </tr>	
        </table>
	</div>
</div>
<?php } ?>
<?php break; ?>

<?php } ?>
</div>
