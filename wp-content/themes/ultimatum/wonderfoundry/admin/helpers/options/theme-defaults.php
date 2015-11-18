<?php
$options = array(


		array(
		"name" => __("Default Logo <small><i>(In layouts generator this will be set as default if no options are selected.)</i></small>", 'ultimatum'),
		"type" => "start"
	),
	array(
			"name" => __("Title as Logo", 'ultimatum'),
			"desc" => sprintf(__('If this option is on, the "Site Title" you defined in <a href="%s/wp-admin/options-general.php">Settings->General</a> will be used as logo
image.', 'ultimatum'),get_option('siteurl')),
			"id" => "text_logo",
			"default" => true,
			"type" => "toggle"
		),
		
		array(
			"name" => __("Image Logo", 'ultimatum'),
			"desc" =>__( "Paste the full URL (include <code>http://</code>) of your custom logo here or you can insert the image through the button.", 'ultimatum'),
			"id" => "logo",
			"default" => "",
			"type" => "upload"
		),
		array(
			"name" => __("Display Site Description <small><i>(tag line)</i></small>", 'ultimatum'),
			"desc" => sprintf(__('If you set logo to be text, you can choose whether to display <a href="%s/wp-admin/options-general.php">Tagline</a> after Site Title.', 'ultimatum'),get_option('siteurl')),
			"id" => "display_site_desc",
			"default" => true,
			"type" => "toggle"
		),
	array(
		"type" => "endnosave"
	),
	
	array(
		"name" => __("Favicon", 'ultimatum'),
		"type" => "start"
	),
	array(
			"name" => __("Favorite Icon", 'ultimatum'),
			"desc" =>__( "Paste the full URL (include <code>http://</code>) of your favicon here or you can insert the image through the button.", 'ultimatum'),
			"id" => "favicon",
			"default" => "",
			"type" => "upload"
		),
	array(
		"type" => "endnosave"
	),
		array(
				"name" => __("Image Placeholder", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Image Placeholder", 'ultimatum'),
				"desc" =>__( "Used for posts with no featured image set.<br/>Paste the full URL (include <code>http://</code>) of your favicon here or you can insert the image through the button.", 'ultimatum'),
				"id" => "noimage",
				"default" => "",
				"type" => "upload"
		),
		array(
				"type" => "end"
		),

	
	
);
return array(
	'auto' => true,
	'name' => 'ultimatum_general',
	'options' => $options
);