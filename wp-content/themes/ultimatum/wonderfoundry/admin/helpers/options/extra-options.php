<?php
$options = array(

	array(
		"name" => __("Ultimatum Extra Tools", 'ultimatum'),
		"type" => "start"
	),
		array(
				"name" => __("Ultimatum Slideshows", 'ultimatum'),
				"id" => "ultimatum_slideshows",
				"desc" => __('The most often used sliders like nivo, flex and supersized are packed with Ultimatum you may enable / disable them here. ', 'ultimatum'),
				"default" => false,
				"type" => "toggle"
		),
		array(
				"name" => __("Ultimatum Shortcodes", 'ultimatum'),
				"id" => "ultimatum_shortcodes",
				"desc" => __('Ultimatum comes with a handful of shortcodes. They are designed not to conflict with other shortcdes you may have but still you can disable them. ', 'ultimatum'),
				"default" => false,
				"type" => "toggle"
		),
		array(
				"name" => __("Ultimatum Shortcodes Legacy Mode", 'ultimatum'),
				"id" => "ultimatum_shortcodes_legacy",
				"desc" => __('If you were using 2.3 shortcodes this will make them work again.', 'ultimatum'),
				"default" => false,
				"type" => "toggle"
		),
		array(
				"name" => __("Post Galleries", 'ultimatum'),
				"id" => "ultimatum_postgals",
				"default" => false,
				"desc" => __('Adds a Gallery metabox to your posts so that you can have nice sliders in layouts. ', 'ultimatum'),
				"type" => "toggle"
		),
		array(
		"type" => "endnosave"
	),
		array(
				"name" => __("Layout Editor Options", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Elements at bottom", 'ultimatum'),
				"id" => "element_position",
				"default" => false,
				"desc" => __('If set ON the elements part in Layout Editor will be shown below layout body. Otherwise it will be on right hand side. ', 'ultimatum'),
				"type" => "toggle"
		),
		array(
				"type" => "end"
		),
);
return array(
		'auto' => true,
		'name' => 'ultimatum_extras',
		'options' => $options
);