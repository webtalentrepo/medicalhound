<?php
$options= array(

		array(
				"name" => __("Vertical Menu", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Item Background ", 'ultimatum'),
				"id" => "cssvar82",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Active Item Background ", 'ultimatum'),
				"id" => "cssvar121",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
		array(
				"name" => __("Hover Background ", 'ultimatum'),
				"id" => "cssvar83",
				"property" =>"background-color",
				"default" => "",
				"type" => "color"
		),
    array(
        'id' => 'cssvar84',
        'name' => __("Item Text", 'ultimatum'),
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
        'id' => 'cssvar122',
        'name' => __("Item Text - Active", 'ultimatum'),
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
        'id' => 'cssvar85',
        'name' => __("Item Text - :hover", 'ultimatum'),
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