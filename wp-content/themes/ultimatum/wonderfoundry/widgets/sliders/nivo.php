<?php
wp_enqueue_script('slider-nivo');
if(preg_match('/theme/i',$instance["nivo_color"])){
	$nivocolor = $instance["nivo_color"];
} else {
	$nivocolor = 'theme-ultimatum nivo'.$instance["nivo_color"];
}
?>

<div class="slider-wrapper <?php echo $nivocolor;?>">
	<div id="<?php echo $this->id.'-nivo'; ?>" class="nivoSlider"  >
	<?php 
	foreach($images as $image){
			if($uslider){
				$img_src['url'] = THEME_SLIDESHOW.'/'.$instance['slide'].'/'.$image['image'];
				$img_src['fpath'] = THEME_SLIDESHOW_DIR.'/'.$instance['slide'].'/'.$image['image'];
				$imgsrc = UltimatumImageResizer( null, $img_src,$instance["Width"], $instance["Height"], true );
			} else {
				$imgsrc = UltimatumImageResizer( $image['image_id'], null,$instance["Width"], $instance["Height"], true );
			}
			if($instance['nivo_captions']=='false'){
				$image["title"]='';
			}
			if($image["link"]) {
			?>
				<a href="<?php echo $image["link"]; ?>"><img src="<?php echo $imgsrc; ?>" style="float:right" title="<?php echo $image["title"]; ?>" alt="<?php echo $image["title"]; ?>" /></a>
			<?php
			} else {
			?>
				<img src="<?php echo $imgsrc; ?>" style="float:right" alt="<?php echo $image["title"]; ?>" title="<?php echo $image["title"]; ?>"  />
			<?php 
			} 
	}
?>	
	</div>
</div>
<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready(function($) {
		$('#<?php echo $this->id.'-nivo'; ?>').nivoSlider({
		effect:'<?php echo $instance['nivo_effect'];?>',
		slices:<?php echo $instance['nivo_segments'];?>,
		animSpeed:<?php echo $instance['nivo_animspeed'];?>,
		pauseTime:<?php echo $instance['nivo_pausetime'];?>,
		directionNav:<?php echo $instance['nivo_nav'];?>,
		directionNavHide:<?php echo $instance['nivo_navhover'];?>,
		controlNav:<?php echo $instance['nivo_controls'];?>,
		pauseOnHover:<?php echo $instance['nivo_pausehover'];?>,
		captionOpacity:<?php echo $instance['nivo_captionsopacity'];?>
		});
	});
	//]]>
</script>
