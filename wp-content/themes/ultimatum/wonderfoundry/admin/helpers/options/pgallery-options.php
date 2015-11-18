<?php
$options = array(
		array(
				"name" => __("Post Types to enable Post Galleries", 'ultimatum'),
				"type" => "start"
		),);
$options[]=array(
		"name" => 'page',
		"id" => 'page',
		"default" => false,
		"type" => "toggle"
);
$args=array('public'   => true,'publicly_queryable' => true);
$posttypes=array();
$post_types=get_post_types($args,'names');
foreach ($post_types as $post_type ) {
	if($post_type!='attachment' && $post_type!='ult_slideshow'){
		$options[]=array(
				"name" => $post_type,
				"id" => $post_type,
				"default" => false,
				"type" => "toggle"
		);
	}
}
$options[] = 	array(
				"type" => "end"
		);
	
return array(
	'auto' => true,
	'name' => 'ultimatum_postgals',
	'options' => $options
);