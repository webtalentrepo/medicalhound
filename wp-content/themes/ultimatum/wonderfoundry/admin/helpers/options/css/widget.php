<?php
$options = array(
    array(
        "name" => __("Widgets and Specific Widgets", 'ultimatum'),
        "type" => "start"
    ),
    array(
        'id' => "cssvar104",
        'type' => 'background',
        "name" => __("Widget Title Background", 'ultimatum'),
        'background-color'      => true,
        'background-repeat'     => true,
        'background-attachment' => true,
        'background-position'   => true,
        'background-image'      => true,
        'background-size'       => true,
    ),
    array(
        'id' => "cssvar104",
        'type' => 'borders',
        "name" => __("Widget Title Border", 'ultimatum'),
        'border-top' => true,
        'border-bottom' => true
    ),
    array(
        'id' => "cssvar104",
        'type' => 'margins',
        "name" => __("Widget Title Margin", 'ultimatum'),
        'margin-top' => true,
        'margin-bottom' => true
    ),
    array(
        'id' => 'cssvar103',
        'name' => __("Widget Title Typography", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => true,
        'font-size'       => true,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => true,
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
        'id' => 'cssvar102',
        'name' => __("Super Title Typography", 'ultimatum'),
        'type' => 'typography',
        'font-family'     => true,
        'font-size'       => true,
        'font-weight'     => true,
        'font-style'      => true,
        'text-align'      => true,
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
        "type" => "end"
    ),
    array(
		"type" => "justsave",
	),
);
return array(
    'auto' => true,
    'name' => 'css',
    'options' => $options
);