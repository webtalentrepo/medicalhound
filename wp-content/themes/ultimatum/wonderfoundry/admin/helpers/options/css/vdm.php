<?php
$options= array(

		array(
				"name" => __("Vertical Dropdown Menu", 'ultimatum'),
				"type" => "start"
		),
    array(
        "name" => __("Margins ", 'ultimatum'),
        "id" => "cssvar74",
        'type' => 'margins',
        'margin-top'=>true,
        'margin-bottom'=>true,
    ),
		array(
				"name" => __("Top Level Items Background ", 'ultimatum'),
				"id" => "cssvar75",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Top Level Hover and sub items background ", 'ultimatum'),
				"id" => "cssvar76",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Top Level Active items background ", 'ultimatum'),
				"id" => "cssvar117",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Sub Levels Hover background ", 'ultimatum'),
				"id" => "cssvar77",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
    array(
        'id' => 'cssvar78',
        'name' => __("Top level Links", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => true,
        'font-size'       => true,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => false,
        'text-transform'  => true,
        'font-variant'    => true,
        'text-decoration' => true,
        'color'           => true,
        'line-height'     => true,
        'word-spacing'    => true,
        'letter-spacing'  => true,
        'cufon'           => true,
    ),
    array(
        'id' => 'cssvar118',
        'name' => __("Top level Links - Active", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => false,
        'font-size'       => false,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => false,
        'text-transform'  => false,
        'font-variant'    => false,
        'text-decoration' => true,
        'color'           => true,
        'line-height'     => false,
        'word-spacing'    => false,
        'letter-spacing'  => false,
        'cufon'           => true,
    ),
    array(
        'id' => 'cssvar79',
        'name' => __("Top level Links - :hover", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => false,
        'font-size'       => false,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => false,
        'text-transform'  => false,
        'font-variant'    => false,
        'text-decoration' => true,
        'color'           => true,
        'line-height'     => false,
        'word-spacing'    => false,
        'letter-spacing'  => false,
        'cufon'           => true,
    ),
    array(
        'id' => 'cssvar80',
        'name' => __("Second level Links", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => true,
        'font-size'       => true,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => false,
        'text-transform'  => true,
        'font-variant'    => true,
        'text-decoration' => true,
        'color'           => true,
        'line-height'     => true,
        'word-spacing'    => true,
        'letter-spacing'  => true,
        'cufon'           => true,
    ),
    array(
        'id' => 'cssvar81',
        'name' => __("Second level Links - :hover", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => false,
        'font-size'       => false,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => false,
        'text-transform'  => false,
        'font-variant'    => false,
        'text-decoration' => true,
        'color'           => true,
        'line-height'     => false,
        'word-spacing'    => false,
        'letter-spacing'  => false,
        'cufon'           => true,
    ),
		array(
				"type" => "endnosave"
		),

		array(
				"type" => "justsave"
		),
		
		);

return array(
		'auto' => true,
		'name' => 'css',
		'options' => $options
);