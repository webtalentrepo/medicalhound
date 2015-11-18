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



function ultimatum_web_app_meta(){
		wp_enqueue_script('jquery');
		
	?>
		<!-- iPhone -->
		<?php if(get_ultimatum_option('general', 'touchicon')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'touchicon');?>"  sizes="57x57" rel="apple-touch-icon" />
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'startimage')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'startimage');?>" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image" />
	    <?php endif; ?>
	    <!-- iPhone (Retina) -->
	    <?php if(get_ultimatum_option('general', 'iphoneretina')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'iphoneretina');?>" sizes="114x114" rel="apple-touch-icon" />
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'iphoneretinastart')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'iphoneretinastart');?>" media="(device-width: 320px) and (device-height: 480px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	    <!-- iPhone 5 -->
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'iphone5start')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'iphone5start');?>" media="(device-width: 320px) and (device-height: 568px) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	    <!-- iPad -->
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'ipad')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'ipad');?>" sizes="72x72" rel="apple-touch-icon" />
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'ipadportrait')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'ipadportrait');?>" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image" />
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'ipadlandscape')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'ipadlandscape');?>" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 1)" rel="apple-touch-startup-image" />  
	    <!-- iPad (Retina) -->
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'ipadretina')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'ipadretina');?>" sizes="144x144" rel="apple-touch-icon" />
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'ipadrportrait')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'ipadrportrait');?>" media="(device-width: 768px) and (device-height: 1024px) and (orientation: portrait) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	    <?php endif; ?>
	    <?php if(get_ultimatum_option('general', 'ipadrlandscape')):?>
	        <link href="<?php echo get_ultimatum_option('general', 'ipadrlandscape');?>" media="(device-width: 768px) and (device-height: 1024px) and (orientation: landscape) and (-webkit-device-pixel-ratio: 2)" rel="apple-touch-startup-image" />
	    <?php endif; ?> 
		<?php 
		echo '<meta content="yes" name="apple-mobile-web-app-capable" />';
		echo '<meta content="600" name="MobileOptimized" />';
		echo '<meta content="telephone=no" name="format-detection" />';
		echo '<meta content="true" name="HandheldFriendly" />';
		echo '<meta content="black" name="apple-mobile-web-app-status-bar-style" />';
}
function ultimatum_web_app_bubble(){
	wp_enqueue_script('ios-bubble');
	wp_enqueue_script('mobile-js');
}
function ultimatum_web_app_link_hider(){
$script = <<<JS
		<script type="text/javascript">
		var noddy, remotes = false;
	
	document.addEventListener('click', function(event) {
		
		noddy = event.target;
		
		// Bubble up until we hit link or top HTML element. Warning: BODY element is not compulsory so better to stop on HTML
		while(noddy.nodeName !== "A" && noddy.nodeName !== "HTML") {
	        noddy = noddy.parentNode;
	    }
		
		if('href' in noddy && noddy.href.indexOf('http') !== -1 && (noddy.href.indexOf(document.location.host) !== -1 || remotes))
		{
			event.preventDefault();
			document.location.href = noddy.href;
		}
	
	},false);
		</script>
JS;
		echo $script;
}
