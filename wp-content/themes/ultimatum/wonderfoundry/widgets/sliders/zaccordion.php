<?php
$id = $this->id;
wp_enqueue_script('jquery-easing');
wp_enqueue_script('slider-zaccordion');
?>
<style type="text/css">
ul#<?php echo 'za'.$id; ?> {list-style:none;margin:0px;padding:0px;}
<?php if($instance['zAStyle']==1){ ?>
ul#<?php echo 'za'.$id; ?> li {position:relative;}
ul#<?php echo 'za'.$id; ?> li div.slider-bg {background:#<?php echo ($instance['zABcolor']);?>;bottom:0px;height:102px;width:<?php echo $instance['zAWidth'];?>px;left:0;position:absolute;z-index:10;opacity:.5;}
ul#<?php echo 'za'.$id; ?> li div.slider-info {bottom:0px;height:72px;left:0;position:absolute;width:65px;z-index:15;padding:15px;}
ul#<?php echo 'za'.$id; ?> li div.slider-info strong {font-size:18px;color:#<?php echo ($instance['zAColor']);?>;margin-bottom:5px;}
ul#<?php echo 'za'.$id; ?> li div.slider-info p {display:none;font-size:12px;line-height:14px;color:#<?php echo ($instance['zAColor']);?>;margin:0 !important;}
ul#<?php echo 'za'.$id; ?> li.slider-open div.slider-info {width:<?php echo ($instance['zAWidth']-30);?>px;}
ul#<?php echo 'za'.$id; ?> li.slider-open div.slider-info strong {font-size:22px;}
ul#<?php echo 'za'.$id; ?> li.slider-open div.slider-info p {display:block;}
<?php } else { ?>
ul#<?php echo 'za'.$id; ?> li {overflow:visible !important;}
ul#<?php echo 'za'.$id; ?> li div.slider-bg {-moz-border-radius:5px;-webkit-border-radius:5px;background:#<?php echo ($instance['zABcolor']);?>;border-radius:5px;bottom:20px;height:80px;left:25px;opacity:.75;position:absolute;width:<?php echo ($instance['zAWidth']-30);?>px;z-index:10;}
ul#<?php echo 'za'.$id; ?> li div.slider-info {bottom:30px;height:55px;left:40px;position:absolute;width:<?php echo ($instance['zAWidth']-60);?>px;z-index:15;}
ul#<?php echo 'za'.$id; ?> li h2 {font-size:14px;margin-bottom:5px;}
ul#<?php echo 'za'.$id; ?> li strong {font-size:11px;color:#<?php echo ($instance['zAColor']);?>;text-shadow:none;}
ul#<?php echo 'za'.$id; ?> li p {font-size:11px;line-height:14px;text-shadow:none;color:#<?php echo ($instance['zAColor']);?>;margin:0 !important;}
<?php } ?>
</style>
<ul id="<?php echo 'za'.$id; ?>">
<?php
foreach($images as $image){
	$imgsrc = UltimatumImageResizer( $image['image_id'], null,$instance["zAWidth"], $instance["Height"], true );
?>
<li>

<img src="<?php echo $imgsrc; ?>" />
<?php if($instance['zAStyle']==0){ ?>
<?php } else { ?>
<div class="slider-bg"></div>
<div class="slider-info">
<strong><a href="<?php echo $image['link']; ?>"><?php echo $image['title']; ?></a></strong>
<p class="slider-text"><?php echo $image['text']; ?></p>
</div>
<?php } ?>
</li>
<?php
}
?>
</ul>

<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){
jQuery('#<?php echo 'za'.$id; ?>').zAccordion({
width: <?php echo $instance["Width"];?>,
speed: <?php echo $instance['zAspeed'];?>,
timeout: <?php echo $instance['zAtimeout'];?>,
slideClass: "slider",
<?php if($instance["zAEasing"]!="null"){?>
easing              : "easeInOut<?php echo $instance["zAEasing"]; ?>",
<?php } ?>
<?php if($instance['zAStyle']==2){ ?>
animationStart: function() {
jQuery("#<?php echo 'za'.$id; ?>").find("li.slider-previous div").fadeOut();
},
animationComplete: function() {
jQuery("#<?php echo 'za'.$id; ?>").find("li.slider-open div").fadeIn();
},
<?php } ?>
auto: <?php echo $instance['zAAuto'];?>,
slideWidth: <?php echo $instance['zAWidth'];?>,
height: <?php echo $instance['Height'];?>
});
<?php if($instance['zAStyle']==2){ ?>
jQuery("#<?php echo 'za'.$id; ?>").find("li.slider-closed div").css("display", "none");
<?php } ?>
});
//]]>
</script>