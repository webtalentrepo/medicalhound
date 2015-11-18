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
 
add_filter('widget_text', 'do_shortcode');

add_filter('excerpt_more', 'new_excerpt_more');
function new_excerpt_more($more) {
	return '';
}
add_filter('excerpt_length', 'new_excerpt_length');
function new_excerpt_length($length) {
	return 1000;
}