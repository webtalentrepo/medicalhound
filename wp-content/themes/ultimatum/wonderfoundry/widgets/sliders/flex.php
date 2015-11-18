<?php
wp_enqueue_script('slider-flex');
?>
<div class="flex-container">
<div class="flexslider" id="<?php echo $this->id.'-flex'; ?>" >
<ul class="slides">

<?php
foreach($images as $image){
$imgsrca = wp_get_attachment_image_src($image['image_id'],full); 
$imgsrc = $imgsrca[0];
?>
<li>
<?php if(isset($image["link"])){?>
<a href="<?php echo $image["link"]; ?>"><img src="<?php echo $imgsrc; ?>" style="float:right" alt="<?php echo $image["title"]; ?>" title="<?php echo $image["title"]; ?>" /></a>
<?php } else { ?>
<img src="<?php echo $imgsrc; ?>" style="float:right" alt="<?php echo $image["title"]; ?>" title="<?php echo $image["title"]; ?>" />
<?php  } ?>
<?php if(strlen($image["text"])>>3) {?>
<p class="slidertext"><?php echo do_shortcode($image["text"]); ?></p>
<?php } ?>

</li>
<?php }	?>
</ul>
</div>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function() {
jQuery('#<?php echo $this->id.'-flex'; ?>').flexslider({
animation: "<?php echo $instance['flexanimation']; ?>",
slideDirection: "<?php echo $instance['flexslideDirection']; ?>",
slideshow: <?php echo $instance['flexslideshow']; ?>,
slideshowSpeed: <?php echo $instance['flexslideshowSpeed']; ?>,
animationDuration: <?php echo $instance['flexanimationDuration']; ?>,
directionNav: <?php echo $instance['flexdirectionNav']; ?>,
controlNav: <?php echo $instance['flexcontrolNav']; ?>,
keyboardNav: <?php echo $instance['flexkeyboardNav']; ?>,
mousewheel: <?php echo $instance['flexmousewheel']; ?>,
randomize: <?php echo $instance['flexrandomize']; ?>,
animationLoop: <?php echo $instance['flexanimationLoop']; ?>,
pauseOnAction: <?php echo $instance['flexpauseOnAction']; ?>,
pauseOnHover: <?php echo $instance['flexpauseOnHover']; ?>

});
});
//]]>
</script>