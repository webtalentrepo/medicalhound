<?php
wp_enqueue_script('slider-s3');

?>
<div class="s3Slider" id="<?php echo $this->id.'-s3'; ?>" style="width:<?php echo $instance[Width]?>px;height:<?php echo $instance[Height]?>px">
<ul class="s3sliderContent" id="<?php echo $this->id.'-s3'; ?>Content" style="width:<?php echo $instance[Width]?>px;height:<?php echo $instance[Height]?>px">

<?php
foreach($images as $image){
			if($uslider){
				$img_src['url'] = THEME_SLIDESHOW.'/'.$instance['slide'].'/'.$image['image'];
				$img_src['fpath'] = THEME_SLIDESHOW_DIR.'/'.$instance['slide'].'/'.$image['image'];
				$imgsrc = UltimatumImageResizer( null, $img_src,$instance["Width"], $instance["Height"], true );
			} else {
				$imgsrc = UltimatumImageResizer( $image['image_id'], null,$instance["Width"], $instance["Height"], true );
			}
			?>
<li class="s3sliderImage <?php echo $this->id.'-s3'; ?>Image">
<img src="<?php echo $imgsrc; ?>" style="float:right" alt="<?php echo $image[title]; ?>" title="<?php echo $image[title]; ?>" />
<?php if($instance['s3captions']=='left' || $instance['s3captions']=='right'){?>
<div class="<?php echo $instance['s3captions'];?> s3caption" style="width:<?php echo $instance['s3width']-20;?>px;height:<?php echo $instance[Height]-20;?>px;padding:10px;">

<h2 class="slidertitle"><?php echo $image[title]; ?></h2>
<p class="slidertext"><?php echo do_shortcode($image[text]); ?></p>

</div>
<?php } else { ?>
<div class="<?php echo $instance['s3captions'];?> s3caption" style="height:<?php echo $instance['s3height']-20;?>px;width:<?php echo $instance[Width]-20;?>px;padding:10px;">

<h3 class="slidertitle"><?php echo $image[title]; ?></h3>
<p class="slidertext"><?php echo do_shortcode($image[text]); ?></p>

</div>
<?php } ?>
</li>
<?php }	?>


<div class="clear s3sliderImage"></div>
</ul>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() {
jQuery('#<?php echo $this->id.'-s3'; ?>').s3Slider({
timeOut: <?php echo $instance['s3timeout']; ?>

});
});
//]]>
</script>