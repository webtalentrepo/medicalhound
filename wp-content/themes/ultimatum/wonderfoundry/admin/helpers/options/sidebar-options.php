<?php
$options = array(
				array(
						"name" => __("Sidebars", 'ultimatum'),
						"type" => "start"
				),
				array(
						"name" => __("Sidebar Names", 'ultimatum'),
						"desc" => __('Type in names of sidebars you need with using <code>;</code> as seperator', 'ultimatum'),
						"id" => "sidebars",
						"default" => "",
						'rows' => '5',
						"type" => "textarea"
				),
				array(
						"type" => "end"
				),
		);
return array(
	'auto' => true,
	'name' => 'sidebars',
	'options' => $options
);