<?php
$options = array(
		array(
				"name" => __("Beta Versions", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Apply Beta Updates", 'ultimatum'),
				"desc" => __('If this option is set ON you will be notified about beta versions in dashboard and update will gather latest beta version. Do not use this on any production sites.', 'ultimatum'),
				"id" => "beta",
				"default" => false,
				"type" => "toggle"
		),
		array(
				"type" => "end"
		),
	
);
return array(
	'auto' => true,
	'name' => 'ultimatum_access',
	'options' => $options
);