<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
this file under any circumstances.
*/

/**
 * This file
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.38
 */
$options = array(
	array(
		"name" => sprintf(__('Fonts located in "%s"', 'ultimatum'),'<code>'.str_replace( WP_CONTENT_DIR, '', THEME_CUFON_DIR ).'</code>'),
		"type" => "start"
	),
		array(
			"id" => "cufon",
			"layout" => false,
			"function" => "theme_cufon_fonts_option",
			"default" => "",
			"type" => "custom"
		),
	array(
		"type" => "end"
	),
);
return array(
	'auto' => true,
	'name' => 'fonts',
	'options' => $options
);