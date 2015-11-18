<?php
$options = array(
		array(
				"name" => __("Touch Icons", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("iPhone (57px*57px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your App Icon here or you can insert the image through the button.", 'ultimatum'),
				"id" => "touchicon",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPhone (Retina) (114px*114px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your App Launch Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "iphoneretina",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPad (72px*72px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "ipad",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPad (Retina) (144px*144px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "ipadretina",
				"default" => "",
				"type" => "upload"
		),
		array(
				"type" => "end"
		),
		array(
				"name" => __("Startup Images", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("iPhone (320px*460px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your App Icon here or you can insert the image through the button.", 'ultimatum'),
				"id" => "startimage",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPhone (Retina) (640px*920px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your App Launch Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "iphoneretinastart",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPhone 5 (640px*1096px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "iphone5start",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPad Portrait (768px*1004px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "ipadportrait",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPad Landscape (748px*1024px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "ipadlandscape",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPad (Retina) Portrait (1536px*2008px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "ipadrportrait",
				"default" => "",
				"type" => "upload"
		),
		array(
				"name" => __("iPad (Retina) Landscape (1496px*2048px)", 'ultimatum'),
				"desc" =>__( "Paste the full URL (include <code>http://</code>) of your No Image Image here or you can insert the image through the button.", 'ultimatum'),
				"id" => "ipadrlandscape",
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