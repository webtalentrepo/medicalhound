<?php
$options =array(
		array(
				"name" => __("BreadCrumbs <a name=\"bcumb\"></a>", 'ultimatum').'',
				"type" => "title"
		),
		array (
				"type" => "txtElementHead",
		),
		
		array (
				"name"	=> __("General", 'ultimatum'),
				"type"	=> "txtElement",
				"id"	=> "cssvar30",
				"default" => array(
						"font-family" => 'inherit',
						"font-size" => 'inherit',
						"line-height" => 'inherit',
						"color" => "",
						"font-weight" => "inherit",
						"font-style" => "inherit",
						"text-decoration" => "inherit",
				),
				"cufon" => 'on',
		),
		array (
				"name"	=> __("Title (You are here)", 'ultimatum'),
				"type"	=> "txtElement",
				"id"	=> "cssvar31",
				"default" => array(
						"color" => "",
						"font-weight" => "inherit",
						"font-style" => "inherit",
						"text-decoration" => "inherit",
				),
		),
		array (
				"name"	=> __("Current", 'ultimatum'),
				"type"	=> "txtElement",
				"id"	=> "cssvar32",
				"default" => array(
						"color" => "",
						"font-style" => "inherit",
						"font-weight" => "inherit",
						"text-decoration" => "inherit",
				),
		),
		
		array(
				"type" => "justSave"
		),
		array(
				"name" => __("Page Navigation <a name=\"navi\"></a>", 'ultimatum').'',
				"type" => "title"
		),
		array (
				"type" => "txtElementHead",
		),
		array (
				"name"	=> __("General", 'ultimatum'),
				"type"	=> "txtElement",
				"id"	=> "cssvar33",
				"default" => array(
						"font-family" => 'inherit',
						"font-size" => 'inherit',
						"line-height" => 'inherit',
						"color" => "",
						"font-weight" => "inherit",
						"font-style" => "inherit",
						"text-decoration" => "inherit",
				),
		),
		array (
				"name"	=> __("Current", 'ultimatum'),
				"type"	=> "txtElement",
				"id"	=> "cssvar34",
				"default" => array(
						"color" => "",
						"font-style" => "inherit",
						"text-decoration" => "inherit",
				),
		),
		array(
				"type" => "justSave"
		),
		array(
				"name" => __("Background and Border Colors", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Background Color", 'ultimatum'),
				"id"	=> "cssvar33",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Border Color", 'ultimatum'),
				"id"	=> "cssvar35",
				"property" =>"border-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Current Background Color", 'ultimatum'),
				"id"	=> "cssvar34",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Border Color", 'ultimatum'),
				"id"	=> "cssvar36",
				"property" =>"border-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"type" => "end"
		),
		);
return array(
		'auto' => true,
		'name' => 'css',
		'options' => $options
);