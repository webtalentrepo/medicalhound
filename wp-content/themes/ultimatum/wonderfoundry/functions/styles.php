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
function ultimatum_base_styles(){ 
$styles = array(
    array(
        'handle'	=>	'theme-global',
        'filename'	=>	'theme.global.css',
    ),
    array(
        'handle'	=>	'font-awesome',
        'filename'	=>	'font-awesome.min.css',
        'cdn'       =>  '//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
    ),
    /* Bootstrap from bootstrapCDN */
    array(
        'handle'	=>	'tbs3-default',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-cerulean',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/cerulean/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-cosmo',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/cosmo/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-cyborg',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/cyborg/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-darkly',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/darkly/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-flatly',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/flatly/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-journal',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/journal/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-lumen',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/lumen/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-paper',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/paper/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-readable',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/readable/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-sandstone',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/sandstone/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-simplex',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/simplex/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-slate',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/slate/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-spacelab',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/spacelab/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-superhero',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/superhero/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-united',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/united/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs3-yeti',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/3.3.4/yeti/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-default',
        'source'	=>	'//maxcdn.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css'
    ),
    array(
        'handle'	=>	'tbs-amelia',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/amelia/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-cerulean',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/cerulean/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-cosmo',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/cosmo/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-cyborg',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/cyborg/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-flatly',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/flatly/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-journal',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/journal/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-readable',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/readable/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-simplex',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/simplex/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-slate',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/slate/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-spacelab',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/spacelab/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-spruce',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/spruce/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-superhero',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/superhero/bootstrap.min.css'
    ),
    array(
        'handle'	=>	'tbs-united',
        'source'	=>	'//maxcdn.bootstrapcdn.com/bootswatch/2.3.2/united/bootstrap.min.css'
    ),
);

foreach($styles as $style){
	// Set Script source
    if(!isset($style['source'])) {
        if(get_ultimatum_option('scripts', 'cdnsource') && isset($style['cdn'])){
            $src = $style['cdn'];
        } else {
            if (isset($style['directory'])) {
                $fsrc = $style['directory'] . DS . $style['filename'];
                $src = $style['directory'] . '/' . $style['filename'];
            } else {
                $fsrc = $style['filename'];
                $src = $style['filename'];
            }
            // check if replacement file is on place
            if (CHILD_THEME && file_exists(THEME_DIR . DS . 'js' . DS . $fsrc)) {
                $src = THEME_URL . '/css/' . $src;
            } else {
                $src = ULTIMATUM_URL . '/assets/css/' . $src;
            }
        }
    } else {
        $src = $style['source'];
    }
	wp_register_style($style['handle'], $src);
}
}
add_action('init','ultimatum_base_styles');