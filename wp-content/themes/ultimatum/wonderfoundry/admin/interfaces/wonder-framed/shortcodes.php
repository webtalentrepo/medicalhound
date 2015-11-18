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


add_action('admin_enqueue_scripts','layouteditor_scripts');
add_action('admin_enqueue_scripts','layouteditor_styles');

function layouteditor_styles(){
	wp_enqueue_style('thickbox');
	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_style('isotope-css',ULTIMATUM_ADMIN_ASSETS. '/css/isotope.css');
	wp_enqueue_style('animate-css',ULTIMATUM_ADMIN_ASSETS. '/css/animate.css');
	wp_enqueue_style('ultimatum-sc-editor',ULTIMATUM_ADMIN_ASSETS.'/css/ultimatum-sc-editor.css');
}

function layouteditor_scripts(){
	global $wp_version;
	wp_enqueue_media();
	wp_enqueue_script('media-upload');
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_script( 'ultimatum-bootstrap',ULTIMATUM_ADMIN_ASSETS.'/js/admin.bootstrap.min.js' );
	wp_enqueue_script( 'ultimatum-admin',ULTIMATUM_ADMIN_ASSETS.'/js/ultimatum.admin.js' );
	wp_enqueue_script( 'jquery-addrow',ULTIMATUM_ADMIN_ASSETS.'/js/jquery.table.addrow.js' );
	wp_enqueue_script('isotope',ULTIMATUM_ADMIN_ASSETS. '/js/jquery.isotope.min.js' );
	wp_enqueue_script('ultimatum-mce-plugin',ULTIMATUM_URL. '/wonderfoundry/addons/plugins/tinymce/tinymce.js' );
	
}


add_action( 'load-dashboard_page_shortcode-create', 'ultimatum_shortcode_thickbox' );

function ultimatum_shortcode_thickbox(){
	iframe_header();
	$uri = admin_url().'index.php?page=shortcode-create';
	$folder = ULTIMATUM_LIBRARY_DIR.'/images/icons/48/';
	$folderi = ULTIMATUM_LIBRARY_DIR.'/images/icons/';
	$icons = array();
	
	if (is_dir($folder) && $handle = opendir($folder)) {
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != ".." && preg_match('/.png/i', $entry)) {
				if(file_exists($folderi.'32/'.$entry) && file_exists($folderi.'24/'.$entry) && file_exists($folderi.'16/'.$entry)){
					$icons[]=str_replace('.png', '', $entry);
				}
			}
		}
		closedir($handle);
	}
	?>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<style>
	.wp-picker-holder{position:absolute;z-index:999}
	</style>
	<?php 
	$task=false;
	if(isset($_GET["task"])) $task=$_GET["task"];
	switch ($task){
		default:
			codeGeneratorHome($uri);
		break;
		case 'boxes':
			codeGeneratorBoxes($icons);
		break;
		case 'button':
			codeGeneratorButton($icons);
		break;
		case 'mcols':
			codeGeneratorCols();
		break;
		case 'typo':
			codeGeneratorTypo($uri);
		break;
		case 'list':
			 codeGeneratorList($icons);
		break;
		case 'dcap':
			 codeGeneratorDropCap();
		break;
		case 'icontext':
			 codeGeneratorIcontext($icons);
		break;
		case 'quote':
			 codeGeneratorQuote();
		break;
		case 'forms':
			 codeGeneratorForm();
		break;
		case 'gmap':
			 codeGeneratorMap();
		break;
		case 'content':
			 codeGeneratorContent();
		break;
		case 'tabsh':
			 codeGeneratorTabsh($uri);
		break;
		case 'tabs':
			 codeGeneratorTabs();
		break;
		case 'acc':
			 codeGeneratorAccord();
		break;
		case 'toggle':
			 codeGeneratorToggle();
		break;
		case 'video':
			 codeGeneratorVideo();
		break;
		case 'chart':
			 codeGeneratorChart();
		break;
}
	iframe_footer();
	exit;
}

function ultimatum_shortcode_creator(){}
//Functions
function codeGeneratorChart(){
	if($_POST){
		$content.='[ult_chart ';
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
		$content.='[ult_video ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/ult_video]';
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
		$content.='[ult_toggle ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/ult_toggle]';
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
		$content= '[ult_googlemap ';
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
function codeGeneratorHome($uri){
	?>
	
	<h2><?php _e('Click on the ShortCode to Create Yours', 'ultimatum');?></h2>
	<ul id="filters">
	  <li><a href="#" data-filter="*">All</a></li>
	  <li><a href="#" data-filter=".column">Columns</a></li>
	  <li><a href="#" data-filter=".typography">Typography</a></li>
	  <li><a href="#" data-filter=".toggler">Toggle/Accordion/Tabs</a></li>
	  <li><a href="#" data-filter=".gmap">Google Map</a></li>
	  <li><a href="#" data-filter=".gchart">Google Chart</a></li>
	  <li><a href="#" data-filter=".videos">Videos</a></li>
	</ul>
	<div id="container">
		<a href="<?php echo $uri;?>&task=mcols&row_style=1" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-4-48px.png';?>" />
		25/25/25/25
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=2" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-3-48px.png';?>" />
		33/33/33
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=3" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-2-48px.png';?>" />
		50/50
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=4" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-2d4-3-48px.png';?>" />
		25/25/50
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=5" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-2d4-1-48px.png';?>" />
		50/25/25
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=6" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-2d4-2-48px.png';?>" />
		25/50/25
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=7" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-3d4-2-48px.png';?>" />
		25/75
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=8" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-3d4-1-48px.png';?>" />
		75/25
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=9" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-2d3-1-48px.png';?>" />
		33/66
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=mcols&row_style=10" class="column">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/cols-2d3-2-48px.png';?>" />
		66/33
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=tabs" class="toggler">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/tabs-48px.png';?>" />
		Tabs
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=toggle" class="toggler">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/heading-48px.png';?>" />
		Toggle
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=acc" class="toggler">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/accordion-48px.png';?>" />
		Accordion
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=boxes&type=roundbox" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		Rounded Corner Box
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=boxes&type=cornerbox" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		Bordered Box
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=boxes&type=infobox" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		Info Box
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=dcap" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		DropCap
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=button" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		Button
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=list" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/list-48px.png';?>" />
		List
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=quote" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/testimonials-48px.png';?>" />
		Quote
		</div>
		</a>
		<a href="./index.php?page=shortcode-create&task=icontext" class="typography">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		Icon Text
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=gmap" class="gmap">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/googlemap-48px.png';?>" />
		Google Map
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=chart" class="gchart">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/ultimatum_48.png';?>" />
		Google Chart
		</div>
		</a>
		<a href="<?php echo $uri;?>&task=video" class="videos">
		<div class="codes">
		<img src="<?php echo ULTIMATUM_URL.'/wonderfoundry/admin/assets/images/video-48px.png';?>" />
		Video
		</div>
		</a>
		
		
		
	</div>
	
	<script type="text/javascript">
<!--
jQuery(document).ready(function(){
var container = jQuery('#container');
//initialize isotope
container.isotope({
//options...
});

//filter items when filter link is clicked
jQuery('#filters a').click(function(){
var selector = jQuery(this).attr('data-filter');
container.isotope({ filter: selector });
return false;
});
});
//-->
</script>
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
				$content.='[ult_roundbox ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/ult_roundbox]';
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
									<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?>:</td>
								<td>
									<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Color', 'ultimatum');?>:</td>
								<td>
									<input name="bordercolor" type="text" value="<?php if(isset($properties)){ echo $properties["bordercolor"]; } else { echo '000000'; } ?>" class="ult-color-field"/>
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
										<option value="solid" <?php if(isset($properties) && $properties["borderstyle"]=='solid') echo 'selected="selected"';?>>Solid</option>
										<option value="dotted" <?php if(isset($properties) && $properties["borderstyle"]=='dotted') echo 'selected="selected"';?>>Dotted</option>
										<option value="dashed" <?php if(isset($properties) && $properties["borderstyle"]=='dashed') echo 'selected="selected"';?>>Dashed</option>
										<option value="none" <?php if(isset($properties) && $properties["borderstyle"]=='none') echo 'selected="selected"';?>>None</option>
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
											if(isset($properties) && $properties[icon]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
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
				$content.='[ult_cornerbox ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/ult_cornerbox]';
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
									<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?>:</td>
								<td>
									<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Color', 'ultimatum');?> :</td>
								<td>
									<input name="bordercolor" type="text" value="<?php if(isset($properties)){ echo $properties["bordercolor"]; } else { echo '000000'; } ?>" class="ult-color-field"/>
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
										<option value="solid" <?php if(isset($properties) && $properties["borderstyle"]=='solid') echo 'selected="selected"';?>>Solid</option>
										<option value="dotted" <?php if(isset($properties) && $properties["borderstyle"]=='dotted') echo 'selected="selected"';?>>Dotted</option>
										<option value="dashed" <?php if(isset($properties) && $properties["borderstyle"]=='dashed') echo 'selected="selected"';?>>Dashed</option>
										<option value="none" <?php if(isset($properties) && $properties["borderstyle"]=='none') echo 'selected="selected"';?>>None</option>
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
											if(isset($properties) && $properties["icon"]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
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
				$content.='[ult_infobox ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/ult_infobox]';
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
									<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>" class="ult-color-field"/>
									</div>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?>:</td>
								<td>
									<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Border Color', 'ultimatum');?> :</td>
								<td>
									<input name="bordercolor" type="text" value="<?php if(isset($properties)){ echo $properties["bordercolor"]; } else { echo '000000'; } ?>" class="ult-color-field" />
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
											if(isset($properties) && $properties["icon"]==$key) echo 'selected="selected"';
											echo'>'.$icon.'</option>';
										}
										?>
									</select>
								</td>
							</tr>
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
			
		} elseif(isset($_GET["row_style"])){
			?>
			<h2><?php _e('Type in your content in boxes below and click Insert', 'ultimatum');?></h2>
			<form method="post" action="">
			<?php 
			switch ($_GET["row_style"]){
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
		} 
}



function codeGeneratorButton($icons){
	global $wpdb;
	$sctable = $wpdb->prefix.ULTIMATUM_PREFIX.'_sc';
				if($_POST){
				$content.='[ult_button ';
				foreach ($_POST as $key=>$value){
					if($key!='buttontext' && $key!='save_style'){
						$cont[]=$key.'="'.$value.'"';
						$property[$key]=$value;
					}
				}
				$content .= implode(' ',$cont);
				$content .=']'.($_POST["buttontext"]).'[/ult_button] ';
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
									<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties["color"]; } else { echo '000000'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Text Hover Color', 'ultimatum');?> :</td>
								<td>
										<input name="hovercolor" type="text" value="<?php if(isset($properties)){ echo $properties["hovercolor"]; } else { echo 'none'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Color', 'ultimatum');?> :</td>
								<td>
									<input  name="backgroundcolor" type="text" value="<?php if(isset($properties)){ echo $properties["backgroundcolor"]; } else { echo 'FFFFFF'; } ?>" class="ult-color-field"/>
								</td>
							</tr>
							<tr>
								<td><?php _e('Background Hover Color', 'ultimatum');?> :</td>
								<td>
								<input name="hoverbgcolor" type="text" value="<?php if(isset($properties)){ echo $properties["hoverbgcolor"]; } else { echo 'none'; } ?>" class="ult-color-field"/>
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
				$content.='[ult_icontext ';
				foreach ($_POST as $key=>$value){
					if($key!='content' && $key!='save_style'){
						$content.=$key.'="'.$value.'" ';
						$property[$key]=$value;
					}
				}
				$content .=']'.($_POST["content"]).'[/ult_icontext]';
				
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
								<td><input type="text" name="content" value="<?php if(isset($properties)){ echo $properties["buttontext"]; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Link', 'ultimatum');?> :</td>
								<td><input type="text" name="link" value="<?php if(isset($properties)){ echo $properties["buttonlink"]; } ?>" />
							</tr>
							<tr>
								<td><?php _e('Size', 'ultimatum');?> :</td>
								<td>
									<select name="size">
										<option value="small" <?php if($properties["buttonsize"]=='small') echo 'selected="selected"';?>>small</option>
										<option value="medium" <?php if($properties["buttonsize"]=='medium') echo 'selected="selected"';?>>medium</option>
										<option value="large" <?php if($properties["buttonsize"]=='large') echo 'selected="selected"';?>>large</option>
										<option value="huge" <?php if($properties["buttonsize"]=='large') echo 'selected="selected"';?>>huge</option>
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
		$content.='[ult_list] ';
		foreach($_POST[icon] as $key=>$value){
			$content.= '[listitem icon="'.$_POST[icon][$key].'"]'.$_POST[content][$key].'[/listitem] ';
		}
		$content.= '[/ult_list] ';
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
		$content.='[ult_dropcap ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/ult_dropcap]';
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
			<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties[color]; } else { echo ''; } ?>" class="ult-color-field"/>
		</td>
	</tr>
	<tr>
		<td><?php _e('Background Color', 'ultimatum');?> :</td>
		<td>
			<input  name="bcolor" type="text" value="<?php if(isset($properties)){ echo $properties[backgroundcolor]; } else { echo ''; } ?>" class="ult-color-field"/>
		</td>
	</tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}


function codeGeneratorQuote(){
	if($_POST){
		$content.='[ult_blockquote ';
		foreach ($_POST as $key=>$value){
			if($key!='content' && $key!='save_style'){
				$content.=$key.'="'.$value.'" ';
			}
		}
		$content .=']'.($_POST[content]).'[/ult_blockquote]';
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
			<input name="color" type="text" value="<?php if(isset($properties)){ echo $properties[color]; } else { echo ''; } ?>" class="ult-color-field"/>
		</td>
	</tr>
	<tr>
		<td><?php _e('Background Color', 'ultimatum');?> :</td>
		<td>
			<input  name="bcolor" type="text" value="<?php if(isset($properties)){ echo $properties[backgroundcolor]; } else { echo ''; } ?>" class="ult-color-field"/>
		</td>
	</tr>
	</table>
	<input class="button-primary"  type="button" value="<?php _e('Back', 'ultimatum');?>" onclick="history.go(-1)"><input type="submit"class="button-primary" value="<?php _e('Insert', 'ultimatum');?>"/>
	</form>
	<?php 
}

function codeGeneratorAccord(){
	if($_POST){
		$content.='[ult_accordion] ';
		foreach ($_POST["title"] as $key=>$value){
			$content .= '[ult_accrow title="'.$_POST["title"][$key].'"]'.$_POST["content"][$key].'[/ult_accrow] ';
		}
		$content .='[/ult_accordion]';
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
		$content.='[ult_tabs] ';
		foreach ($_POST[title] as $key=>$value){
			$content .= '[ult_tab title="'.$_POST["title"][$key].'" active="'.$_POST["active"][$key].'"]'.$_POST["content"][$key].'[/ult_tab] ';
		}
		$content .='[/ult_tabs]';
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
			<td><input name="active[]" value="active" type="hidden" class="active_set"/><?php _e('Active','ultimatum');?><input type="radio" name="activ[]" value="active" class="actif" onclick="activate_sel()"/></td>
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
		function activate_sel(){
			 jQuery('.active_set').val('');
		     jQuery("input:checked").siblings('.active_set').val('active');
			}
	</script>
	<?php 
}

function curPageURL() {
	return $_SERVER['REQUEST_URI'];
}