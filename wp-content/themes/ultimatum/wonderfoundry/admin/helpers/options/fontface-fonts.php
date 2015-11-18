<?php
$options = array(
	array(
		"name" => sprintf(__('Fonts located in "%s"', 'ultimatum'),'<code>'.str_replace( WP_CONTENT_DIR, '', THEME_FONTFACE_DIR ).'</code>'),
		"type" => "start"
	),
		array(
			"id" => "fontface",
			"layout" => false,
			"function" => "theme_fontface_fonts_option",
			"default" => '',
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