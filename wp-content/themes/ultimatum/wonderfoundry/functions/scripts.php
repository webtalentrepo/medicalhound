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
 * @version 2.38
 */
 
// Register Scripts 
// For replacable scripts define an array
function ultimatum_base_scripts(){
$scripts = array(
    array(
        'handle'	=>	'stellar-js',
        'filename'	=>	'stellar.js',
        'version'	=>	'0.6.2',
        'directory'	=>	'plugins',
        'cdn'       =>  '//cdn.jsdelivr.net/jquery.stellar/0.6.2/jquery.stellar.min.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-tweets',
        'filename'	=>	'jquery.tweet.js',
        'version'	=>	'2.38',
        'directory'	=>	'plugins',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'swfobject',
        'filename'	=>	'swfobject.js',
        'version'	=>	'2.38',
        'directory'	=>	'plugins',
        'cdn'       =>  '//cdn.jsdelivr.net/swfobject/2.2/swfobject.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-google-maps',
        'filename'	=>	'jquery.gmap.js',
        'version'	=>	'2.38',
        'bottom'	=>	true,
        'directory'	=>	'plugins',
    ),
    array(
        'handle'	=>	'ios-bubble',
        'directory'	=>	'pro',
        'filename'	=>	'bmb.js',
        'version'	=>	'2.38',
        'bottom'	=>	false
    ),
    array(
        'handle'	=>	'mobile-js',
        'directory'	=>	'pro',
        'filename'	=>	'ultimatum-mobile.js',
        'version'	=>	'2.38',
        'bottom'	=>	false
    ),
    array(
        'handle'	=>	'slider-anything',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.anythingslider.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-anything-fx',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.anthingslider.fx.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-elastic',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.eislideshow.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-anything-video',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.anthingslider.video.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-flex',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.flexslider-min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-nivo',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.nivo.slider.pack.js',
        'version'	=>	'3.2',
        'cdn'       =>  '//cdn.jsdelivr.net/nivoslider/3.2/jquery.nivo.slider.pack.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-s3',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.s3slider.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-zaccordion',
        'directory'	=>	'slideshows',
        'filename'	=>	'jquery.zaccordion.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-slidedeck',
        'directory'	=>	'slideshows',
        'filename'	=>	'slidedeck.jquery.lite.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-supersized',
        'directory'	=>	'slideshows',
        'filename'	=>	'supersized.3.2.7.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'slider-supersized-shutter',
        'directory'	=>	'slideshows',
        'filename'	=>	'supersized.shutter.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'menu-ddsmooth',
        'directory'	=>	'menus',
        'filename'	=>	'ddsmoothmenu.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'menu-hmega',
        'directory'	=>	'menus',
        'filename'	=>	'jquery.dcmegamenu.1.3.3.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'menu-vmega',
        'directory'	=>	'menus',
        'filename'	=>	'jquery.dcverticalmegamenu.1.3.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-easing',
        'directory'	=>	'plugins',
        'filename'	=>	'jquery.easing.min.js',
        'version'	=>	'2.38',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-mousewheel',
        'directory'	=>	'plugins',
        'filename'	=>	'jquery.mousewheel.min.js',
        'version'	=>	'3.0.6',
        'cdn'       =>  '//cdn.jsdelivr.net/mousewheel/3.0.6/jquery.mousewheel.min.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-hoverIntent',
        'directory'	=>	'plugins',
        'filename'	=>	'jquery.hoverIntent.min.js',
        'version'	=>	'r7',
        'cdn'       => '//cdn.jsdelivr.net/jquery.hoverintent/r7/jquery.hoverIntent.minified.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'theme-global',
        'filename'	=>	'theme.global.tbs2.min.js',
        'version'	=>	'2',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'theme-global-3',
        'filename'	=>	'theme.global.tbs3.min.js',
        'version'	=>	'2',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'bootstrap-2',
        'filename'	=>	'bootstrap.2.3.2.min.js',
        'version'	=>	'2.3.2',
        'directory' =>  'src',
        'cdn'       => '//maxcdn.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'bootstrap-3',
        'filename'	=>	'bootstrap.3.3.4.min.js',
        'version'	=>	'3.3.4',
        'directory' =>  'src',
        'cdn'       => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-fidvids',
        'filename'	=>	'jquery.fitvids.js',
        'version'	=>	'1.1',
        'directory' =>  'src',
        'cdn'       =>  '//cdn.jsdelivr.net/fitvids/1.1.0/jquery.fitvids.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'prettyphoto',
        'filename'	=>	'jquery.prettyPhoto.js',
        'version'	=>	'3.1.5',
        'directory' =>  'src',
        'cdn'       => '//cdn.jsdelivr.net/prettyphoto/3.1.5/js/jquery.prettyPhoto.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-sidr',
        'filename'	=>	'jquery.sidr.min.js',
        'version'	=>	'1.2.1',
        'directory' =>  'src',
        'cdn'       => '//cdn.jsdelivr.net/jquery.sidr/1.2.1/jquery.sidr.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'jquery-slicknav',
        'filename'	=>	'jquery.slicknav.js',
        'version'	=>	'1.0.2',
        'directory' =>  'src',
        'cdn'       =>  '//cdn.jsdelivr.net/jquery.slicknav/1.0.2/jquery.slicknav.min.js',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'ult-menu-js',
        'filename'	=>	'ult.menu.js',
        'version'	=>	'2.8.0',
        'directory' =>  'src',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'theme-js',
        'filename'	=>	'theme.js',
        'version'	=>	'2.8.0',
        'directory' =>  'src',
        'bottom'	=>	true
    ),
    array(
        'handle'	=>	'holder',
        'directory'	=>	'plugins',
        'filename'	=>	'holder.js',
        'version'	=>	'1.9.0',
        'cdn'       => '//cdn.jsdelivr.net/holder/1.9.0/holder.js',
        'bottom'	=>	false
    ),
);

foreach($scripts as $script){
	// Set Script source
    // if we are to use CDN and script has CDN source do it and go
    if(get_ultimatum_option('scripts', 'cdnsource') && isset($script['cdn'])){
        $src = $script['cdn'];
    } else {
        if (isset($script['directory'])) {
            $fsrc = $script['directory'] . DS . $script['filename'];
            $src = $script['directory'] . '/' . $script['filename'];
        } else {
            $fsrc = $script['filename'];
            $src = $script['filename'];
        }
        // check if replacement file is on place
        if (CHILD_THEME && file_exists(THEME_DIR . DS . 'js' . DS . $fsrc)) {
            $src = THEME_URL . '/js/' . $src;
        } else {
            $src = ULTIMATUM_URL . '/assets/js/' . $src;
        }
    }
	wp_register_script($script['handle'], $src,array(),$script['version'],$script['bottom']);
}
}
add_action('init','ultimatum_base_scripts');
