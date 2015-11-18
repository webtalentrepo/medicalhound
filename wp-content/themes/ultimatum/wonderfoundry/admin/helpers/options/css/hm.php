<?php
$options = array(
    array(
        "name" => __("Horizontal Menu", 'ultimatum'),
        "type" => "start"
    ),
    array(
        "name" => __("Margins ", 'ultimatum'),
        "id" => "cssvar57",
        'type' => 'margins',
        'margin-top'=>true,
        'margin-bottom'=>true,
    ),
	array(
        "name" => __("Item Background ", 'ultimatum'),
        "id" => "cssvar58",
        "property" =>"background-color",
        "default" => "",
        "type" => "color"
    ),
    array(
        "name" => __("Active Item Background ", 'ultimatum'),
        "id" => "cssvar119",
        "property" =>"background-color",
        "default" => "",
        "type" => "color"
    ),
    array(
        "name" => __("Hover Background ", 'ultimatum'),
        "id" => "cssvar59",
        "property" =>"background-color",
        "default" => "",
        "type" => "color"
    ),
    array(
        "name" => __("Seperator Color", 'ultimatum'),
        "id" => "cssvar60",
        "property" =>"border-color",
        "default" => "",
        "type" => "color"
    ),
    array(
        'id' => 'cssvar61',
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
        'id' => 'cssvar120',
        'name' => __("Active Item Text", 'ultimatum'),
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
        'id' => 'cssvar62',
        'name' => __("Item :hover Text", 'ultimatum'),
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