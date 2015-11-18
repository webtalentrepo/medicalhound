<?php 
function codeGeneratorChart(){
	if($_POST){
		$content.='[chart ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert Chart', 'ultimatum');?></h2>
	<form method="post" action="">
	<table>
		<tr valign="top">
			<td width="40%">
				<table>
					<tr>
						<td><?php _e('Chart Title', 'ultimatum');?></td>
						<td><input type="text" name="title" value="<?php _e('Chart Title', 'ultimatum');?>" /></td>
					</tr>
					<tr>
						<td><?php _e('Chart Background', 'ultimatum');?></td>
						<td><input type="text" name="bg" value="ffffff" /></td>
					</tr>
					<tr>
						<td><?php _e('Chart Type', 'ultimatum');?></td>
						<td>
							<select name="type">
								<option value="pie"><?php _e('3D Pie Chart', 'ultimatum');?></option>
								<option value="pie2d"><?php _e('2D Pie Chart', 'ultimatum');?></option>
								<option value="line"><?php _e('Line Chart', 'ultimatum');?></option>
								<option value="xyline"><?php _e('XY Line Chart', 'ultimatum');?></option>
								<option value="sparkline"><?php _e('Sparkline Chart', 'ultimatum');?></option>
								<option value="meter"><?php _e('Meter Chart', 'ultimatum');?></option>
								<option value="scatter"><?php _e('Scatter Chart', 'ultimatum');?></option>
								<option value="venn"><?php _e('Venn Chart', 'ultimatum');?></option>
							</select>
						</td>
					</tr>
					<tr>
						<td><?php _e('Width', 'ultimatum');?></td>
						<td><input type="text" name="width" value="450" /></td>
					</tr>
					<tr>
						<td><?php _e('Height', 'ultimatum');?></td>
						<td><input type="text" name="height" value="200" /></td>
					</tr>
				</table>
			</td>
			<td>
				<table>
					<tr valign="top">
						<td><?php _e('Labels', 'ultimatum');?>:</td>
						<td><textarea name="labels" rows="4" cols="40"></textarea></td>
						<td><?php _e('Type your labels comma(,) seperated', 'ultimatum');?></td>
					</tr>
					<tr valign="top">
						<td><?php _e('Data', 'ultimatum');?></td>
						<td><textarea name="data" rows="4" cols="40"></textarea></td>
						<td><?php _e('Type your Data comma (,) seperated', 'ultimatum');?></td>
					</tr>
					<tr valign="top">
						<td><?php _e('Colors', 'ultimatum');?></td>
						<td><textarea name="colors" rows="4" cols="40"></textarea></td>
						<td><?php _e('Type colors comma(,) seperated eg. FFFFFF,F0F0F0', 'ultimatum');?></td>
					</tr>
				</table>
			
			</td>
		</tr>
	</table>
	<input class="button-primary" type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">&nbsp;
	<input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}




function codeGeneratorVideo(){
	if($_POST){
		$content.='[video ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/video]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert Video', 'ultimatum');?></h2>
	<form method="post" action="">
	<table>
	<tr><td><?php _e('Video URL', 'ultimatum');?></td><td><input type="text" name="content" size="50" /></td></tr>
	<tr><td><?php _e('Video Width', 'ultimatum');?></td><td><input type="text" name="width" value="600" /></td></tr>
	<tr><td><?php _e('Video Height', 'ultimatum');?></td><td><input type="text" name="height" value="400" /></td></tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">&nbsp;
	<input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}


function codeGeneratorToggle(){
	if($_POST){
		$content.='[toggle ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/toggle]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert Toggle Text', 'ultimatum');?></h2>
	<form method="post" action="">
	<table>
	<tr><td><?php _e('Title', 'ultimatum');?> :</td><td><input type="text" name="title" value="<?php _e('Title', 'ultimatum');?>" /></td></tr>
	<tr>
		<td><?php _e('Text', 'ultimatum');?></td>
		<td>
			<textarea name="content" rows="10" cols="50"><?php _e('Type your text here...', 'ultimatum');?></textarea>
		</td>
	</tr>
	
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">&nbsp;
	<input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}


function codeGeneratorMap(){
if($_POST){
		$content= '[googlemap ';
		foreach($_POST as $key=>$value){
			$content.=$key.'="'.$value.'" ';
		}
		$content.= '] ';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
		<?php 
	}
	?>
	<h2><?php _e('Insert a Map', 'ultimatum');?></h2>
	<form action="" method="post">
<table>
	<tr>
		<td><?php _e('Width', 'ultimatum'); ?></td>
		<td>
			<input value="0" name="width" type="text" /><i><?php _e('Enter 0 for full width', 'ultimatum'); ?></i>
			
		</td>
	</tr>
	<tr>
		<td><?php _e('Height', 'ultimatum'); ?></td>
		<td><input value="400" name="height" type="text" />
		</td>
	</tr>
	<tr>
		<td><?php _e('Address (optional)', 'ultimatum'); ?></td>
		<td><input name="address" size="30" value="" type="text"></td>
	</tr>
	<tr>
		<td><?php _e('Latitude', 'ultimatum');?>:</td>
		<td><input name="latitude" id="latitude" size="30" value="" type="text"></td>
	</tr>
	<tr>
		<td><?php _e('Longitude', 'ultimatum');?></td>
		<td><input name="longitude" size="30" value="" type="text"></td>
	</tr>
	<tr>
		<td><?php _e('Zoom', 'ultimatum');?></td>
		<td><select name="zoom">
		<option value="7">7</option>
		<?php 
		for($i=1;$i<=19;$i++){
			echo '<option value="'.$i.'">'.$i.'"</option>';
		}
		?>
		</select></td>
	</tr>
	<tr>
		<td><?php _e('Marker', 'ultimatum');?></td>
		<td><input name="marker" value="true" checked="checked" type="checkbox"></td>
	</tr>
	<tr>
		<td><?php _e('Html', 'ultimatum');?></td>
		<td><input name="html"  size="30" value="" type="text"></td>
	</tr>
	<tr>
		<td><?php _e('Popup Marker', 'ultimatum');?></td>
		<td><input name="popup" id="popup" value="true" type="checkbox"></td>
	
		<td><?php _e('Controls', 'ultimatum');?></td>
		<td><input name="controls" id="controls" value="true" type="checkbox"></td>
	</tr>
	<tr>
		<td><?php _e('panControl', 'ultimatum');?></td>
		<td><input name="panControl" id="panControl" value="true" type="checkbox"></td>
	
		<td><?php _e('zoomControl', 'ultimatum');?></td>
		<td><input name="zoomControl" id="zoomControl" value="true" type="checkbox"></td>
	</tr>
	<tr>
		<td><?php _e('doubleclickzoom', 'ultimatum');?></td>
		<td><input name="doubleclickzoom" id="doubleclickzoom" value="true" type="checkbox"></td>
	
		<td><?php _e('mapTypeControl', 'ultimatum');?></td>
		<td><input name="mapTypeControl" id="mapTypeControl" value="true" type="checkbox"></td>
	</tr>
	<tr>
		<td><?php _e('scaleControl', 'ultimatum');?></td>
		<td><input name="scaleControl" id="scaleControl" value="true" type="checkbox"></td>
	
		<td><?php _e('streetViewControl', 'ultimatum');?></td>
		<td><input name="streetViewControl" id="streetViewControl" value="true" type="checkbox"></td>
	</tr>
	<tr>
		<td><?php _e('overviewMapControl', 'ultimatum');?></td>
		<td><input name="overviewMapControl" id="overviewMapControl" value="true" type="checkbox"></td>
	
		<td><?php _e('Scrollwheel', 'ultimatum');?></td>
		<td><input name="scrollwheel" value="true" type="checkbox" /></td>
	</tr>
	<tr>
		<td><?php _e('Map Type', 'ultimatum');?></td>
		<td>
		<select name="maptype" id="maptype">
			<option value="G_NORMAL_MAP" selected="selected"><?php _e('Default road map', 'ultimatum');?></option>
			<option value="G_SATELLITE_MAP"><?php _e('Google Earth satellite', 'ultimatum');?></option>
			<option value="G_HYBRID_MAP"><?php _e('Mixture of normal and satellite', 'ultimatum');?></option>
			<option value="G_DEFAULT_MAP_TYPES"><?php _e('Mixture of above three maps', 'ultimatum');?></option>
			<option value="G_PHYSICAL_MAP"><?php _e('Physical map', 'ultimatum');?></option>
		</select>
		</td>
	</tr>
	<tr>
		<td><?php _e('Align', 'ultimatum');?></td>
		<td>
		<select name="align" id="align">
			<option value="left" selected="selected"><?php _e('Left', 'ultimatum');?></option>
			<option value="right"><?php _e('Right', 'ultimatum');?></option>
			<option value="center"><?php _e('Center', 'ultimatum');?></option>
		</select>
		</td>
	</tr>
</table>
<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">&nbsp;
<input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
</form>
	<?php 
	
}
function codeGeneratorHome(){
	?>
	<h2><?php _e('Click on the ShortCode to Create Yours', 'ultimatum');?></h2>
	<table class="mce-start" width="100%">
		<tr>
			<td><a href="<?php echo curPageURL().'&task=mcols'?>"><img src="images/column-layout.png" /><?php _e('Columns', 'ultimatum');?></a></td>
			<td><a href="<?php echo curPageURL().'&task=tabsh'?>"><img src="images/toggle.png" /><?php _e('Toggle/Accordion/Tabs', 'ultimatum');?></a></td>
		</tr>
		<tr>
			<td><a href="<?php echo curPageURL().'&task=typo'?>"><img src="images/typography.png" /><?php _e('Typography', 'ultimatum');?></a></td>
			<td><?php if(get_ultimatum_option('extras','ultimatum_forms')){?><a href="<?php echo curPageURL().'&task=forms'?>"><img src="images/forms.png" /><?php _e('Forms', 'ultimatum');?></a><?php } ?></td>
		</tr>
		<tr>
			<td><a href="<?php echo curPageURL().'&task=gmap'?>"><img src="images/map.png" /><?php _e('Google Map', 'ultimatum');?></a></td>
			<td><a href="<?php echo curPageURL().'&task=chart'?>"><img src="images/googlecharts.png" /><?php _e('Google Chart', 'ultimatum');?></a></td>
		</tr>
		<tr>
			<td><a href="<?php echo curPageURL().'&task=video'?>"><img src="images/video.png" /><?php _e('Videos', 'ultimatum');?></a></td>
			<td></td>
		</tr>
		
	</table>
<?php
}
function codeGeneratorForm(){
	if($_POST){
		$content= '[form id="'.$_POST[form].'"]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
		<?php 
	}
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_forms'; 
	$query = "SELECT * FROM $table";
	$result = $wpdb->get_results($query,ARRAY_A);
	?>
	<form method="post" action="">
		<h2>Select a Form</h2><br/><br/>
		<select name="form">
		<?php 
			foreach($result as $fetch){
				echo '<option value="'.$fetch["id"].'">'.$fetch["name"].'</option>';
			}
		?>
		</select>
		<br/><br/><br/>
		<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
		<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
	</form>
	<?php 

}



function codeGeneratorBoxes($icons){
	global $wpdb;
	$sctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_sc';
	$type='';
	if(isset($_GET["type"])) $type=$_GET["type"];
	switch ($type){
			case 'roundbox':
			if($_POST){
				$content.='[roundbox ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/roundbox]';
				if(strlen($_POST["save_style"])>=1){
					$properties = serialize($property);
					$query = "INSERT INTO $sctable (`type`,`name`,`properties`) VALUES ('roundbox','".$_POST["save_style"]."','$properties')";
					$wpdb->query($query);
				}
				?>
				<script>
				var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
				insertUltimateContent(theCode);
				</script>
			<?php 
			}
			if(isset($_GET["id"])){
				$query = "SELECT * FROM $sctable WHERE id='".$_GET["id"]."'";
				$fetch = $wpdb->get_row($query,ARRAY_A);
				$properties = unserialize($fetch["properties"]);
			}
			?>
			<form method="post" action="">
			<table width="100%">
				<tr valign="top">
					<td width="50%">
						<h2><?php _e('Box Styling', 'ultimatum');?></h2>
						<table>
							<tr>
								<td><?php _e('Text Color', 'ultimatum');?>:</td>
								<td>
									<div id="txtColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["color"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?>:</td>
								<td>
									<div id="bgColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["backgroundcolor"]; } else { echo '#FFFFFF'; } ?>"></div>
										</div>
										<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Color', 'ultimatum');?>:</td>
								<td>
									<div id="brColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["bordercolor"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="bordercolor" type="text" value="<?php if(isset($properties)){ echo $properties["bordercolor"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Size', 'ultimatum');?>:</td>
								<td><input type="text" name="borderwidth" value="<?php if(isset($properties)){ echo $properties["borderwidth"]; } else { echo '1'; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Border Style', 'ultimatum');?> :</td>
								<td>
									<select name="borderstyle">
										<option value="solid" <?php if($properties["borderstyle"]=='solid') echo 'selected="selected"';?>>Solid</option>
										<option value="dotted" <?php if($properties["borderstyle"]=='dotted') echo 'selected="selected"';?>>Dotted</option>
										<option value="dashed" <?php if($properties["borderstyle"]=='dashed') echo 'selected="selected"';?>>Dashed</option>
										<option value="none" <?php if($properties["borderstyle"]=='none') echo 'selected="selected"';?>>None</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php _e('Icon', 'ultimatum');?> :</td>
								<td>
									<select name="icon">
										<option value="">None</option>
										<?php 
										foreach($icons as $icon){
											echo '<option value="'.$icon.'"';
											$key=$icon;
											if($properties[icon]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr><td><?php _e('Save as favorite', 'ultimatum');?>:</td><td><input type="text" name="save_style" /></td></tr>
						</table>
					</td>
					<td>
						<h2><?php _e('Box Content', 'ultimatum');?></h2>
						<textarea rows="10" style="width:100%" name="content"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
						<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
					</td>
				</tr>
			</table>
			</form>
			<?php  	
			break;
			case 'cornerbox':
						if($_POST){
				$content.='[cornerbox ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/cornerbox]';
				if(strlen($_POST["save_style"])>=1){
					$properties = serialize($property);
					$query = "INSERT INTO $sctable (`type`,`name`,`properties`) VALUES ('cornerbox','".$_POST["save_style"]."','$properties')";
					$wpdb->query($query);
				}
				?>
				<script>
				var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
				insertUltimateContent(theCode);
				</script>
			<?php 
			}
			if(isset($_GET["id"])){
				$query = "SELECT * FROM $sctable WHERE id='".$_GET["id"]."'";
				$fetch = $wpdb->get_row($query,ARRAY_A);
				$properties = unserialize($fetch["properties"]);
					}
			?>
			<form method="post" action="">
			<table width="100%">
				<tr valign="top">
					<td width="50%">
						<h2><?php _e('Box Styling', 'ultimatum');?></h2>
						<table>
							<tr>
								<td><?php _e('Text Color', 'ultimatum');?>:</td>
								<td>
									<div id="txtColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["color"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?>:</td>
								<td>
									<div id="bgColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["backgroundcolor"]; } else { echo '#FFFFFF'; } ?>"></div>
										</div>
										<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Color', 'ultimatum');?> :</td>
								<td>
									<div id="brColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["bordercolor"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="bordercolor" type="text" value="<?php if(isset($properties)){ echo $properties["bordercolor"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Size', 'ultimatum');?>:</td>
								<td><input type="text" name="borderwidth" value="<?php if(isset($properties)){ echo $properties["borderwidth"]; } else { echo '1'; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Border Style', 'ultimatum');?> :</td>
								<td>
									<select name="borderstyle">
										<option value="solid" <?php if($properties["borderstyle"]=='solid') echo 'selected="selected"';?>>Solid</option>
										<option value="dotted" <?php if($properties["borderstyle"]=='dotted') echo 'selected="selected"';?>>Dotted</option>
										<option value="dashed" <?php if($properties["borderstyle"]=='dashed') echo 'selected="selected"';?>>Dashed</option>
										<option value="none" <?php if($properties["borderstyle"]=='none') echo 'selected="selected"';?>>None</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php _e('Icon', 'ultimatum');?> :</td>
								<td>
									<select name="icon">
										<option value="">None</option>
										<?php 
										foreach($icons as $icon){
											echo '<option value="'.$icon.'"';
											$key=$icon;
											if($properties["icon"]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr><td><?php _e('Save as favorite', 'ultimatum');?>:</td><td><input type="text" name="save_style" /></td></tr>
						</table>
					</td>
					<td>
						<h2><?php _e('Box Content', 'ultimatum');?></h2>
						<textarea rows="10" style="width:100%" name="content"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
						<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
					</td>
				</tr>
				
			</table>
			</form>
			<?php  	
			break;
			case 'infobox':
			if($_POST){
				$content.='[infobox ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/infobox]';
				if(strlen($_POST["save_style"])>=1){
					$properties = serialize($property);
					$query = "INSERT INTO $sctable (`type`,`name`,`properties`) VALUES ('infobox','".$_POST["save_style"]."','$properties')";
					$wpdb->query($query);
				}
				?>
				<script>
				var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
				insertUltimateContent(theCode);
				</script>
				<?php 
				
			}
			if(isset($_GET["id"])){
				$query = "SELECT * FROM $sctable WHERE id='".$_GET["id"]."'";
				$fetch = $wpdb->get_row($query,ARRAY_A);
				$properties = unserialize($fetch["properties"]);
			}
			?>
			<form method="post" action="">
			<table width="100%">
				<tr valign="top">
					<td width="50%">
						<h2><?php _e('Box Styling', 'ultimatum');?></h2>
						<table>
							<tr>
								<td><?php _e('Text Color', 'ultimatum');?>:</td>
								<td>
									<div id="txtColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["color"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?>:</td>
								<td>
									<div id="bgColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["backgroundcolor"]; } else { echo '#FFFFFF'; } ?>"></div>
										</div>
										<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Color', 'ultimatum');?> :</td>
								<td>
									<div id="brColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["bordercolor"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="bordercolor" type="text" value="<?php if(isset($properties)){ echo $properties["bordercolor"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Icon', 'ultimatum');?> :</td>
								<td>
									<select name="icon">
										<option value="">None</option>
										<?php 
										foreach($icons as $icon){
											echo '<option value="'.$icon.'"';
											$key=$icon;
											if($properties["icon"]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr><td><?php _e('Save as favorite', 'ultimatum');?>:</td><td><input type="text" name="save_style" /></td></tr>
						</table>
					</td>
					<td>
						<h2><?php _e('Box Content', 'ultimatum');?></h2>
						<textarea rows="10" style="width:100%" name="content"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
						<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
					</td>
				</tr>
			</table>
			</form>
			<?php  	
			break;
			default:
			?>
			<table width="100%">
			<tr valign="top">
			<td width="50%">
				<table class="mce-start" width="100%">
				<tr><td style="width:100%"><a href="<?php echo curPageURL().'&amp;type=roundbox'?>"><?php _e('Rounded Corner Box', 'ultimatum');?></a></td></tr>
				<tr><td><a href="<?php echo curPageURL().'&amp;type=cornerbox'?>"><?php _e('Bordered Box', 'ultimatum');?></a></td></tr>
				<tr><td><a href="<?php echo curPageURL().'&amp;type=infobox'?>"><?php _e('Info Box', 'ultimatum');?></a></td></tr>
				</table>
			</td>
			<td>
			<table class="mce-start" width="100%">
				<tr><td style="width:100%" class="savedstyles">
				<h2><?php _e('Saved Box Styles', 'ultimatum');?></h2>
					<ul>
						<?php 
						$query = "SELECT * FROM $sctable WHERE type='roundbox' OR type='cornerbox' OR type='infobox'";
						$result = $wpdb->get_results($query,ARRAY_A);
						foreach ($result as $fetch){
							echo '<li><a href="'.curPageURL().'&amp;type='.$fetch["type"].'&amp;id='.$fetch["id"].'">'.$fetch["name"].'-'.$fetch["type"].'</a>';
						}
						?>
					</ul>
					</td></tr></table>
			</td>
			</tr>			
			</table>
			
			<input class="button-primary" type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
			<?php
			break;
		} 
}

function codeGeneratorCols(){
if(isset($_POST["insert"])){
			
			foreach ($_POST["content"] as $pcontent){
				foreach ($pcontent as $key=>$value){
					$content .= '['.$key.']'.($value).'[/'.$key.']'." ";
				}
			}
			$content = str_replace("\r\n", "<br />",$content);  
			?>
			<script>
			var theCode ="<?php echo $content; ?>";
			insertUltimateContent(theCode);
			</script>
			<?php 
			
		} elseif(isset($_POST["row_style"])){
			?>
			<h2><?php _e('Type in your content in boxes below and click Insert', 'ultimatum');?></h2>
			<form method="post" action="">
			<?php 
			switch ($_POST["row_style"]){
				case '1':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="25%">One Fourth Last<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '2':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="33%">One Third<br/><textarea style="width:100%" rows="10"  name="content[][one_third]">Your Content Here</textarea></td>
								<td width="33%">One Third<br/><textarea style="width:100%" rows="10"  name="content[][one_third]">Your Content Here</textarea></td>
								<td width="33%">One Third Last<br/><textarea style="width:100%" rows="10"  name="content[][one_third_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '3':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="50%">One Half<br/><textarea style="width:100%" rows="10"  name="content[][one_half]">Your Content Here</textarea></td>
								<td width="50%">One Half Last<br/><textarea style="width:100%" rows="10"  name="content[][one_half_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '4':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="50%">One Half Last<br/><textarea style="width:100%" rows="10"  name="content[][one_half_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '5':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="50%">One Half<br/><textarea style="width:100%" rows="10"  name="content[][one_half]">Your Content Here</textarea></td>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="25%">One Fourth Last<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '6':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="50%">One Half<br/><textarea style="width:100%" rows="10"  name="content[][one_half]">Your Content Here</textarea></td>
								<td width="25%">One Fourth Last<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '7':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="25%">One Fourth<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth]">Your Content Here</textarea></td>
								<td width="75%">Three Fourth Last<br/><textarea style="width:100%" rows="10"  name="content[][three_fourth_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '8':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="75%">Three Fourth<br/><textarea style="width:100%" rows="10"  name="content[][three_fourth]">Your Content Here</textarea></td>
								<td width="25%">One Fourth Last<br/><textarea style="width:100%" rows="10"  name="content[][one_fourth_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '9':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="33%">One Third<br/><textarea style="width:100%" rows="10"  name="content[][one_third]">Your Content Here</textarea></td>
								<td width="66%">Two Third Last<br/><textarea style="width:100%" rows="10"  name="content[][two_third_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				case '10':
					echo '<table class="preview" style="width:100%">
							<tr>
								<td width="66%">Two Third<br/><textarea style="width:100%" rows="10"  name="content[][two_third]">Your Content Here</textarea></td>
								<td width="33%">One Third Last<br/><textarea style="width:100%" rows="10"  name="content[][one_third_last]">Your Content Here</textarea></td>
							</tr>
						</table>';
				break;
				
			}
			?>
			<input class="button-primary" type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
			<input type="hidden" name="insert" value="1" />
			<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
			</form>
			<?php
		} else {
		?>
		<ol id="selectable">
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="25%">25%</td>
				<td width="25%">25%</td>
				<td width="25%">25%</td>
				<td width="25%">25%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="33%">33%</td>
				<td width="33%">33%</td>
				<td width="33%">33%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="50%">50%</td>
				<td width="50%">50%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="25%">25%</td>
				<td width="25%">25%</td>
				<td width="50%">50%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="50%">50%</td>
				<td width="25%">25%</td>
				<td width="25%">25%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="25%">25%</td>
				<td width="50%">50%</td>
				<td width="25%">25%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="25%">25%</td>
				<td width="75%">75%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="75%">75%</td>
				<td width="25%">25%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="33%">33%</td>
				<td width="66%">66%</td>
			</tr>
		</table>
		
		</li>
		<li class="ui-widget-content">
		<table class="preview2">
			<tr>
				<td width="66%">66%</td>
				<td width="33%">33%</td>
			</tr>
		</table>
		</li>
		</ol>
		<h2><?php _e('Select Layout', 'ultimatum');?></h2>
		<p>
		<?php _e('Click on any layout you want on Left and click Continue Button below.', 'ultimatum');?>
		</p>
		<form action="" method="post">
			<input id="select-result" name="row_style" type="hidden" />
			<INPUT class="button-primary" type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
			<input class="button-primary" type="submit" value="<?php _e('Continue', 'ultimatum');?>" />
		</form>
		
		
			<script>
				jQuery(function() {
					jQuery( "#selectable" ).selectable({
						stop: function() {
							var result = jQuery( "#select-result" ).empty();
							jQuery( ".ui-selected", this ).each(function() {
								var index = jQuery( "#selectable li" ).index( this );
								result.val(( index + 1 ) );
							});
						}
					});
					jQuery( "#selectable" ).selectable( "option", "filter", 'li' );
				});
				jQuery( "#selectable" ).disableSelection();
				<?php if(isset($_GET["layout_id"])){?>
				function InsertRowtoLayout(){
					var id= "<?php echo $_GET["layout_id"]; ?>";
					var style = jQuery( "#select-result" ).val();
					var win = window.dialogArguments || opener || parent || top;
					win.LayoutGetRow(id,style);
					win.tb_remove();
				}
				<?php }?>
				</script>
		<?php 
		}
}
function codeGeneratorTabsh($uri){
	?>
	<table class="mce-start" width="100%">
		<tr>
			<td><a href="<?php echo $uri;?>?task=tabs"><?php _e('Tabs', 'ultimatum');?></a></td>
		</tr>
		<tr>
			<td><a href="<?php echo $uri;?>?task=acc"><?php _e('Accordion', 'ultimatum');?></a></td>
		</tr>
		<tr>
			<td><a href="<?php echo $uri;?>?task=toggle"><?php _e('Toggle', 'ultimatum');?></a></td>
		</tr>
	
	</table>
	<input class="button-primary" type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
	<?php
}

function codeGeneratorTypo($uri){
	?>
	<h2><?php _e('Click on the ShortCode to Create Yours', 'ultimatum');?></h2>
	<table class="mce-start" width="100%">
		<tr>
			<td><a href="<?php echo $uri;?>?task=boxes"><?php _e('Boxes', 'ultimatum');?></a></td>
			<td><a href="<?php echo $uri;?>?task=button"><?php _e('Buttons', 'ultimatum');?></a></td>
		</tr>
		<tr>
			<td><a href="<?php echo $uri;?>?task=dcap"><?php _e('Dropcap', 'ultimatum');?></a></td>
			<td><a href="<?php echo $uri;?>?task=list"><?php _e('Lists', 'ultimatum');?></a></td>
		</tr>
		<tr>
			<td><a href="<?php echo $uri;?>?task=quote"><?php _e('Quotes', 'ultimatum');?></a></td>
			<td><a href="<?php echo $uri;?>?task=icontext"><?php _e('Icon Text', 'ultimatum');?></a></td>
		</tr>
	</table>
	<input class="button-primary" type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
	<?php
}

function codeGeneratorButton($icons){
	global $wpdb;
	$sctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_sc';
				if($_POST){
				$content.='[button ';
				foreach ($_POST as $key=>$value){
					if($key!='buttontext' && $key!='save_style'){
						$cont[]=$key.'="'.$value.'"';
						$property[$key]=$value;
					}
				}
				$content .= implode(' ',$cont);
				$content .=']'.($_POST["buttontext"]).'[/button] ';
				if(strlen($_POST["save_style"])>=1){
					$properties = serialize($property);
					$query = "INSERT INTO $sctable (`type`,`name`,`properties`) VALUES ('button','".$_POST["save_style"]."','$properties')";
					$wpdb->query($query);
				}
				?>
				<script>
				var theCode ='<?php echo $content;?>';
				insertUltimateContent(theCode);
				</script>
			<?php 
			}
			if(isset($_GET["id"])){
				$query = "SELECT * FROM $sctable WHERE id='".$_GET["id"]."'";
				$fetch = $wpdb->get_row($query,ARRAY_A);
				$properties = unserialize($fetch["properties"]);
					}
			?>

			<form method="post" action="">
			<table width="100%">
				<tr valign="top">
					<td width="40%">
					<h2>Saved Button Styles</h2>	
					<ul>
						<?php 
						$query = "SELECT * FROM $sctable WHERE type='button'";
						$result = $wpdb->get_results($query,ARRAY_A);
						if($result){
						foreach ($result as $fetch){
							echo '<li><a href="'.curPageURL().'&amp;type='.$fetch["type"].'&amp;id='.$fetch["id"].'">'.$fetch["name"].'-'.$fetch["type"].'</a>';
						}
						}
						?>
					</ul>
					</td>
					<td>
						<h2><?php _e('Button Styling', 'ultimatum');?></h2>
						<table>
							<tr>
								<td><?php _e('Button Text', 'ultimatum');?> :</td>
								<td><input type="text" name="buttontext" value="<?php if(isset($properties["buttontext"])){ echo $properties["buttontext"]; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Button Link', 'ultimatum');?> :</td>
								<td><input type="text" name="buttonlink" value="<?php if(isset($properties["buttonlink"])){ echo $properties["buttonlink"]; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Button Size', 'ultimatum');?> :</td>
								<td>
									<select name="buttonsize">
										<option value="small" <?php if($properties["buttonsize"]=='small') echo 'selected="selected"';?>>small</option>
										<option value="medium" <?php if($properties["buttonsize"]=='medium') echo 'selected="selected"';?>>medium</option>
										<option value="large" <?php if($properties["buttonsize"]=='large') echo 'selected="selected"';?>>large</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php _e('Text Color', 'ultimatum');?> :</td>
								<td>
									<div id="txtColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["color"]; } else { echo '#000000'; } ?>"></div>
										</div>
										<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Text Hover Color', 'ultimatum');?> :</td>
								<td>
									<div id="txthColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["hovercolor"]; } else { echo '#FFFFFF'; } ?>"></div>
										</div>
										<input name="hovercolor" type="text" value="<?php if(isset($properties)){ echo $properties["hovercolor"]; } else { echo 'none'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?> :</td>
								<td>
									<div id="bgColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["backgroundcolor"]; } else { echo '#FFFFFF'; } ?>"></div>
										</div>
										<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Hover Color', 'ultimatum');?> :</td>
								<td>
									<div id="brColor" class="cPicker">
										<div class="colorSelector">
											<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties["hoverbgcolor"]; } else { echo '#FFFFFF'; } ?>"></div>
										</div>
										<input name="hoverbgcolor" type="text" value="<?php if(isset($properties)){ echo $properties["hoverbgcolor"]; } else { echo 'none'; } ?>"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Icon', 'ultimatum');?> :</td>
								<td>
									<select name="icon">
										<option value="">None</option>
										<?php 
										foreach($icons as $icon){
											echo '<option value="'.$icon.'"';
											$key=$icon;
											if($properties["icon"]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php _e('Open in Light box?', 'ultimatum');?> :</td>
								<td>
									<select name="rel">
										<option value="" <?php if($properties["rel"]=='') echo 'selected="selected"';?>>No</option>
										<option value="prettyPhoto" <?php if($properties["rel"]=='prettyPhoto') echo 'selected="selected"';?>>Yes</option>
									</select>
								</td>
							</tr>
							<tr><td><?php _e('Save as favorite', 'ultimatum');?>:</td><td><input type="text" name="save_style" /></td></tr>
						</table>
						
					</td>
				</tr>
				<tr>
					<td colspan="2" style="text-align:right;">
						<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
						<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
					</td>
				</tr>
			</table>
			</form>
	<?php 
}
function codeGeneratorIcontext($icons){
			if($_POST){
				$content.='[icontext ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/icontext]';
				
				?>
				<script>
				var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
				insertUltimateContent(theCode);
				</script>
			<?php 
			}
			?>

			<form method="post" action="">
			<table width="100%">
				<tr valign="top">
					<td>
						<h2><?php _e('Icon Text', 'ultimatum');?></h2>
						<table>
							<tr>
								<td><?php _e('Text', 'ultimatum');?> :</td>
								<td><input type="text" name="content" value="<?php if(isset($properties)){ echo $properties[buttontext]; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Link', 'ultimatum');?> :</td>
								<td><input type="text" name="link" value="<?php if(isset($properties)){ echo $properties[buttonlink]; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Size', 'ultimatum');?> :</td>
								<td>
									<select name="size">
										<option value="small" <?php if($properties[buttonsize]=='small') echo 'selected="selected"';?>>small</option>
										<option value="medium" <?php if($properties[buttonsize]=='medium') echo 'selected="selected"';?>>medium</option>
										<option value="large" <?php if($properties[buttonsize]=='large') echo 'selected="selected"';?>>large</option>
										<option value="huge" <?php if($properties[buttonsize]=='large') echo 'selected="selected"';?>>huge</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php _e('HTML Tag', 'ultimatum');?> :</td>
								<td>
									<select name="tag">
										<option value="h1">H1</option>
										<option value="h2">H2</option>
										<option value="h3">H3</option>
										<option value="h4">H4</option>
										<option value="h5">H5</option>
										<option value="h6">H6</option>
										<option value="p">p</option>
										<option value="span">span</option>
									</select>
								</td>
							</tr>
							<tr>
								<td><?php _e('Icon', 'ultimatum');?> :</td>
								<td>
									<select name="icon">
										<option value="">None</option>
										<?php 
										foreach($icons as $icon){
											echo '<option value="'.$icon.'"';
											$key=$icon;
											if($properties["icon"]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
								<tr>
								<td><?php _e('Open in Light box?', 'ultimatum');?> :</td>
								<td>
									<select name="rel">
										<option value="" <?php if($properties["rel"]=='') echo 'selected="selected"';?>>No</option>
										<option value="prettyPhoto" <?php if($properties[rel]=='prettyPhoto') echo 'selected="selected"';?>>Yes</option>
									</select>
								</td>
							</tr>
						</table>
						
					</td>
				</tr>
				<tr>
					<td style="text-align:right;">
						<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)">
						<input class="button-primary" type="submit" value="<?php _e('Insert', 'ultimatum');?>" />
					</td>
				</tr>
			</table>
			</form>
	<?php 
}

function codeGeneratorList($icons){
	if($_POST){
		$content ='';
		$content.='[list] ';
		foreach($_POST[icon] as $key=>$value){
			$content.= '[listitem icon="'.$_POST[icon][$key].'"]'.$_POST[content][$key].'[/listitem] ';
		}
		$content.= '[/list] ';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
		<?php 
		
	}
	?>
	<h2><?php _e('Insert a Styled List', 'ultimatum');?></h2>
	<form method="post" action="">
	<table>
		<tr><td colspan="3"><input type="button" class="addRow button-primary" value="Add Row"/></td></tr>
		<tr valign="top"><td><?php _e('Icon', 'ultimatum');?> :</td>
									<td>
										<select name="icon[]">
											<?php 
											foreach($icons as $icon){
												echo '<option value="'.$icon.'"';
												echo'>'.$icon.'</option>';
											}
											?>
										</select>
									</td><td><?php _e('Text', 'ultimatum');?></td><td><input type="text" name="content[]" size="24"/></td><td><input type="button" class="delRow button-primary" value="Delete Row"/></td></tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".addRow").btnAddRow();
			jQuery(".delRow").btnDelRow();
		});
	</script>
	<?php 
}

function codeGeneratorDropCap(){
	if($_POST){
		$content.='[dropcap ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/dropcap]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert a DropCap', 'ultimatum');?></h2>
	<form method="post" action="">
	<table>
	<tr><td><?php _e('Letter', 'ultimatum');?> :</td><td><input type="text" name="content" /></td></tr>
	<tr>
		<td><?php _e('Style', 'ultimatum');?> :</td>
		<td>
			<select name="type">
			<option value="normal">Normal</option>
			<option value="round">Round</option>
			</select>
		</td>
	</tr>
	<tr>
		<td><?php _e('Text Color', 'ultimatum');?> :</td>
		<td>
			<div id="txtColor" class="cPicker">
				<div class="colorSelector">
					<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties[color]; } else { echo '#000000'; } ?>"></div>
				</div>
				<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties[color]; } else { echo ''; } ?>"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><?php _e('Background Color', 'ultimatum');?> :</td>
		<td>
			<div id="bgColor" class="cPicker">
				<div class="colorSelector">
					<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties[backgroundcolor]; } else { echo '#FFFFFF'; } ?>"></div>
				</div>
				<input  name="bcolor" type="text" value="<?php if(isset($properties)){ echo $properties[backgroundcolor]; } else { echo ''; } ?>"/>
			</div>
		</td>
	</tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}


function codeGeneratorQuote(){
	if($_POST){
		$content.='[blockquote ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/blockquote]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert a Quote', 'ultimatum');?></h2>
	<form method="post" action="">
	<table>
	<tr><td><?php _e('Text', 'ultimatum');?> :</td><td><textarea name="content" rows="5" cols="50">Your Content Here</textarea></td></tr>
	<tr><td><?php _e('Align', 'ultimatum');?> :</td><td><select name="align"><option value="">none</option><option value="left">Left</option><option value="right">Right</option></select>
	<tr><td><?php _e('Cite', 'ultimatum');?> :</td><td><input type="text" name="cite" /></td></tr>
	<tr>
		<td><?php _e('Text Color', 'ultimatum');?> :</td>
		<td>
			<div id="txtColor" class="cPicker">
				<div class="colorSelector">
					<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties[color]; } else { echo '#000000'; } ?>"></div>
				</div>
				<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties[color]; } else { echo ''; } ?>"/>
			</div>
		</td>
	</tr>
	<tr>
		<td><?php _e('Background Color', 'ultimatum');?> :</td>
		<td>
			<div id="bgColor" class="cPicker">
				<div class="colorSelector">
					<div style="background-color:<?php if(isset($properties)){ echo '#'.$properties[backgroundcolor]; } else { echo '#FFFFFF'; } ?>"></div>
				</div>
				<input  name="bcolor" type="text" value="<?php if(isset($properties)){ echo $properties[backgroundcolor]; } else { echo ''; } ?>"/>
			</div>
		</td>
	</tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}

function codeGeneratorAccord(){
	if($_POST){
		$content.='[accordion] ';
		foreach ($_POST["title"] as $key=>$value){
			$content .= '[accrow title="'.$_POST["title"][$key].'"]'.$_POST["content"][$key].'[/accrow] ';
		}
		$content .='[/accordion]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert Accordion Content', 'ultimatum');?></h2>
<form method="post" action="">
	<table>
		<tr><td colspan="3"><input type="button" class="addRow button-primary" value="Add Row"/></td></tr>
		<tr valign="top">
			<td><?php _e('Title', 'ultimatum');?>:</td>
			<td><input type="text" name="title[]" value="Accordion Title" /></td>
			<td><?php _e('Content', 'ultimatum');?></td>
			<td><textarea name="content[]" rows="3" cols="50"><?php _e('Your Content Here', 'ultimatum');?>...</textarea></td>
			<td><input type="button" class="delRow button-primary" value="Delete Row"/></td>
		</tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".addRow").btnAddRow();
			jQuery(".delRow").btnDelRow();
		});
	</script>
	<?php 
}

function codeGeneratorTabs(){
	if($_POST){
		$content.='[tabs] ';
		foreach ($_POST[title] as $key=>$value){
			$content .= '[tab title="'.$_POST[title][$key].'"]'.$_POST[content][$key].'[/tab] ';
		}
		$content .='[/tabs]';
		?>
		<script>
			var theCode ='<?php echo str_replace("\r\n", "<br />",$content).' ';?>';
			insertUltimateContent(theCode);
		</script>
	<?php
	}
	?>
	<h2><?php _e('Insert Tabbed Content', 'ultimatum');?></h2>
<form method="post" action="">
	<table>
		<tr><td colspan="3"><input type="button" class="addRow button-primary" value="Add Tab"/></td></tr>
		<tr valign="top">
			<td><?php _e('Title', 'ultimatum');?>:</td>
			<td><input type="text" name="title[]" value="Tab Title" /></td>
			<td><?php _e('Content', 'ultimatum');?></td>
			<td><textarea name="content[]" rows="3" cols="50"><?php _e('Your Content Here', 'ultimatum');?>...</textarea></td>
			<td><input type="button" class="delRow button-primary" value="Delete Tab"/></td>
		</tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery(".addRow").btnAddRow();
			jQuery(".delRow").btnDelRow();
		});
	</script>
	<?php 
}

function curPageURL() {
	return $_SERVER['REQUEST_URI'];
}
?>