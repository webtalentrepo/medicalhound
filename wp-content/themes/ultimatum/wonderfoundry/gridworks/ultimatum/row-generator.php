<div class="ult-wrapper wrapper<?php echo ' '.additonalClass($classes,'wrapper-'.$row["id"]);?>" id="wrapper-<?php echo $row["id"]; ?>">
<?php 
if($row["type_id"]!=37){
?><div class="ult-container <?php echo ' '.additonalClassContainer($classes,'container-'.$row["id"],'ultimatum');?>" id="container-<?php echo $row["id"]; ?>">

<?php
} 
switch($row["type_id"]){
	case '1':
		?>
		<div class="ult-column grid_12<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_12)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '2':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '3':
		?>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '4':
		?>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '5':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '6':
		?>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '7':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3 <?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '8':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_9<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_9)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '9':
		?>
		<div class="ult-column grid_9<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_9)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '10':
		?>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_8<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_8)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '11':
		?>
		<div class="ult-column grid_8<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_8)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '12':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_9">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_9 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php		
	break;
	case '13':
		?>
		<div class="ult-column grid_9">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_9 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php	
	break;
	case '14':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '15':
		?>
		<div class="ult-column grid_6">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>		
		<?php
	break;
	case '16':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>		
		<?php
	break;
	case '17':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_9">
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_9 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '18':
		?>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_9">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_9 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '19':
		?>
		<div class="ult-column grid_9">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_9 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '20':
		?>
		<div class="ult-column grid_9">
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_9 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '21':
		?>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '22':
		?>
		<div class="ult-column grid_6">
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '23':
		?>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_8">
			<div class="ult-column grid_4 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_4 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_8 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_8)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '24':
		?>
		<div class="ult-column grid_8">
			<div class="ult-column grid_4 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_4 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_8 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_8)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	
	case '25':
		?>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6">
			<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '26':
		?>
		<div class="ult-column grid_6">
		<div class="ult-column grid_6 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			
		</div>
		<div class="ult-column grid_6<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '27':
		?>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_8">
			<div class="ult-column grid_8 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_8)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_4 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_4 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			
		</div>
		<?php
	break;
	case '28':
		?>
		<div class="ult-column grid_8">
		<div class="ult-column grid_8 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_8)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_4 alpha<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_4 omega<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_4)){ echo '&nbsp;'; } ?></div>
			</div>
			
		</div>
		<div class="ult-column grid_4<?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '29':
		?>
		<div class="ult-column grid_9">
			<div class="ult-column grid_9 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php	
	break;
	case '30':
		?>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6">
			<div class="ult-column grid_6 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			
		</div>
		<?php
	break;
	case '31':
		?>
		<div class="ult-column grid_6">
			<div class="ult-column grid_6 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>		
		<?php
	break;
	case '32':
		?>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_6">
			<div class="ult-column grid_6 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-5');?>" id="<?php echo 'col-'.$row["id"].'-5';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-5',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>		
		<?php
	break;
	case '33':
		?>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_9">
			<div class="ult-column grid_9 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '34':
		?>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<div class="ult-column grid_9">
			<div class="ult-column grid_9 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<?php
	break;
	case '35':
		?>
		<div class="ult-column grid_9">
			<div class="ult-column grid_9 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '36':
		?>
		<div class="ult-column grid_9">
			<div class="ult-column grid_9 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_9)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_6 alpha <?php echo additonalClass($classes,'col-'.$row["id"].'-3');?>" id="<?php echo 'col-'.$row["id"].'-3';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-3',$grid_6)){ echo '&nbsp;'; } ?></div>
			</div>
			<div class="ult-column grid_3 omega <?php echo additonalClass($classes,'col-'.$row["id"].'-4');?>" id="<?php echo 'col-'.$row["id"].'-4';?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-4',$grid_3)){ echo '&nbsp;'; } ?></div>
			</div>
		</div>
		<div class="ult-column grid_3 <?php echo additonalClass($classes,'col-'.$row["id"].'-2');?>" id="<?php echo 'col-'.$row["id"].'-2';?>">
			<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-2',$grid_3)){ echo '&nbsp;'; } ?></div>
		</div>
		<?php
	break;
	case '37':
		?>
		<div class="<?php echo '29 '.additonalClass($classes,'col-'.$row["id"].'-1');?>" id="<?php echo 'col-'.$row["id"].'-1';?>">
		<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-1',$grid_4)){ echo '&nbsp;'; } ?></div>
		</div>
				
			<?php
		break;
	default:
		$row_extra = explode('_', $row["type_id"]);
		global $wpdb;
		$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_extra_rows';
		$sql = "SELECT * from $table WHERE `template_id`='".$row_extra[0]."' AND `slug`= '".$row_extra[1]."'";
		$extrarow = $wpdb->get_row($sql);
		$columns = explode(',',$extrarow->grid);
		if(count($columns)!=0){
			$ik=1;
			foreach ($columns as $column){
				$gridder = "grid_".$column;
				?>
			<div class="ult-column grid_<?php echo $column;?><?php echo ' '.additonalClass($classes,'col-'.$row["id"].'-'.$ik);?>" id="<?php echo 'col-'.$row["id"].'-'.$ik;?>">
				<div class="colwrapper"><?php if(!ultimate_dynamic_sidebar($ultimateresponsive,'sidebar-'.$row["id"].'-'.$ik,$$gridder)){ echo '&nbsp;'; } ?></div>
			</div>
			<?php
			$ik++;
			}
			} 
		 break;
}
?>
<?php 
if($row["type_id"]!=37){
?>
</div>
<?php } ?>
</div>