<?php
wp_enqueue_style('slider-elastic');
wp_enqueue_script('jquery-easing');
wp_enqueue_script('slider-elastic');
foreach($images as $image){
	$imgsrc[]	= array($image['title'],$image['text'],UltimatumImageResizer( $image['image_id'], null,$instance["Width"], $instance["Height"], true ));
	$thmubs[]	= array($image['title'],UltimatumImageResizer( $image['image_id'], null,150, 60, true ));
	
}
?>
<style>
#<?php echo $this->id.'elastic'; ?>{
height: <?php echo $instance['Height'];?>px;
}
</style>
<div id="<?php echo $this->id.'elastic'; ?>" class="ei-slider">
                    <ul class="ei-slider-large">
                    <?php foreach($imgsrc as $imz){?>
						<li>
                            <img src="<?php echo $imz[2];?>" alt="image06" />
                            <div class="ei-title">
                                <h2><?php echo $imz[0];?></h2>
                                <p><?php echo $imz[1];?></p>
                            </div>
                        </li>
                       <?php }?> 
                    </ul><!-- ei-slider-large -->
                    <ul class="ei-slider-thumbs">
                        <li class="ei-slider-element">Current</li>
                        <?php foreach($thmubs as  $imt){?>
						<li><a href="#"><?php echo $imt[1];?></a><img src="<?php echo $imt[1];?>" alt="thumb06" /></li>
                         <?php }?> 
                    </ul><!-- ei-slider-thumbs -->
                </div><!-- ei-slider -->
                <div class="clearfix"></div>
<script type="text/javascript">
//<![CDATA[		
jQuery(document).ready(function(){
	jQuery('#<?php echo $this->id.'elastic'; ?>').eislideshow({
		animation			: 'center',
		autoplay			: <?php  echo $instance['ei_autoplay'];?>,
		slideshow_interval	: <?php  echo $instance['ei_interval'];?>,
		titlesFactor		: 0
    });
});
//]]>
</script>