<?php
wp_enqueue_script('slider-slidedeck');
wp_enqueue_script('jquery-mousewheel');
$instance["Width"]=$instance["Width"]-50;
?>
<div id="slidedeck_frame" class="skin-slidedeck" style="width:<?php echo $instance["Width"]?>px;height:<?php echo $instance["Height"]?>px">
<dl class="slidedeck" id="<?php echo $this->id.'-sdeck'; ?>">
<?php
foreach($images as $image){
if($uslider){
$img_src['url'] = THEME_SLIDESHOW.'/'.$instance['slide'].'/'.$image['image'];
$img_src['fpath'] = THEME_SLIDESHOW_DIR.'/'.$instance['slide'].'/'.$image['image'];
$imgsrc = UltimatumImageResizer( null, $img_src,$instance["SDWidth"], $instance["SDHeight"], true );
} else {
$imgsrc = UltimatumImageResizer( $image['image_id'], null,$instance["SDWidth"], $instance["SDHeight"], true );
}
?>
<dt><?php echo $image["title"]?></dt>
<dd>
<div style="float:left;width:100%;">
<?php if($instance["SDVideo"]=='true' && strlen($image["video"])>=3){ ?>
<div style="float:right;margin-left:10px;">
<?php
$sc ='[video width="'.$instance["SDWidth"].'" height="'.$instance["SDHeight"].'"]'.$image["video"].'[/video]';
echo do_shortcode($sc);
?>
</div>
<?php } else {?>
<?php if($image["link"]) {?>
<a href="<?php echo $image["link"]; ?>"><img src="<?php echo $imgsrc; ?>" style="float:right;margin-left:10px;" alt="<?php echo $image[title]; ?>" /></a>
<?php } else {?>
<img src="<?php echo $imgsrc; ?>" style="float:right;margin-left:10px;" alt="<?php echo $image["title"]; ?>" />
<?php } ?>
<?php } ?>
<?php if($instance['SDSpines']=='true'){?>
<h3 class="slidertitle"><?php echo $image["title"]; ?></h3>
<?php } ?>
<p class="slidertext"><?php echo do_shortcode($image["text"]); ?></p>
<?php
if($image["link"]){
echo '<a href="'.$image["link"].'" class="anyLink" style="float:right"><span>'.__('Read More','ultimatum').'</span> →</a>';
}
?>
</div>
</dd>
<?php
unset($image);
}
?>
</dl>
</div>
<script type="text/javascript">
//<![CDATA[
jQuery(document).ready(function(){
jQuery('#<?php echo $this->id.'-sdeck'; ?>').slidedeck({
autoPlay: <?php echo $instance['SDAuto'];?>,
cycle: true,
autoPlayInterval: <?php echo $instance['SDInterval'];?>,
hideSpines: <?php echo $instance['SDSpines'];?>,
index: <?php echo $instance['SDIndex'];?>
});
});
//]]>
</script>