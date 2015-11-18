<?php
wp_enqueue_script('jquery-easing');
wp_enqueue_script('slider-supersized');
if($instance['superType']=="part"){
	?>
<style type="text/css">
.supercontainer, #supersized {
position: absolute;
left:0; top:<?php echo $instance["superTop"]; ?>px;
margin:0px;
overflow:hidden;
z-index:-999;
height:<?php echo $instance["superHeight"]; ?>px;
width:100%;
}
#supersized li {
position: absolute;left:0; top:0;height:<?php echo $instance["superHeight"]; ?>px;}
#supersized a {position: absolute;left:0; top:0;height:<?php echo $instance["superHeight"]; ?>px;}

</style>
<div style="height:<?php echo $instance["superHeight"];?>px;float:left;width:100%;"></div>
<!--Arrow Navigation-->
<div class="supercontainer Any<?php echo $instance['super_color']; ?>" style="z-index:0;" >
<?php if($instance['superControls']=='true'){?>
<a id="prevslide" class="load-item back"></a>
<a id="nextslide" class="load-item forward"></a>
<?php } ?>
<?php if($instance['superCaptions']=='true'){?>
<style type="text/css">
#slidecaption h3 a {
color:#<?php echo $instance['superCaptionsText']; ?>;
opacity:1;
}
</style>
<div id="slidecaption" style="background-color:#<?php echo $instance['superCaptionsColor']; ?>;opacity:0.5;"></div>
<?php } ?>
</div>

<?php

} ?>

<script type="text/javascript">

jQuery(document).ready(function(){

jQuery.supersized({

// Functionality
slideshow               :   1,
autoplay				:	1,
start_slide             :   1,
stop_loop				:	0,
random					: 	0,
slide_interval          :   <?php echo $instance['superInterval']; ?>,
transition              :   <?php echo $instance['superTrans']; ?>,
transition_speed		:	<?php echo $instance['superSpeed']; ?>,
new_window				:	1,
pause_hover             :   0,
keyboard_nav            :   1,
performance				:	1,
image_protect			:	1,
min_width		        :   0,
min_height		        :   0,
vertical_center         :   1,
horizontal_center       :   1,
fit_always				:	0,
fit_portrait         	:   1,
fit_landscape			:   0,
slide_links				:	'false',
thumb_links				:	1,
thumbnail_navigation    :   0,
slides 					:  	[
<?php
foreach($images as $image){
$imgsrca = wp_get_attachment_image_src($image['image_id'],full);
$imgsrc = $imgsrca[0];
$superslides[]="{image : '".$imgsrc."', title : '<h3><a href=\"".$image['link']."\">".$image['title']."</a></h2>', url : '".$image['link']."'}";
}
$superslider = implode(',',$superslides);
echo $superslider;
?>
]


});
});

</script>