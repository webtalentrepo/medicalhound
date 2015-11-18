<?php
$options =array(
    array(
        "name" => __("Toggles", 'ultimatum'),
        "type" => "start"
    ),
    array(
        "name" => __("Title Background ", 'ultimatum'),
        "id" => "cssvar94",
        "property" =>"background-color",
        "default" => "",
        "type" => "color",
    ),
    array(
        "name" => __("Active Title Background", 'ultimatum'),
        "id" => "cssvar95",
        "property" =>"background-color",
        "default" => "0",
        "type" => "color",
    ),
    array(
        "name" => __("Content Background ", 'ultimatum'),
        "id" => "cssvar96",
        "property" =>"background-color",
        "default" => "",
        "type" => "color"
    ),
    array(
        'id' => 'cssvar97',
        'name' => __("Title", 'ultimatum'),
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
        'cufon'           => false,
    ),
    array(
        'id' => 'cssvar98',
        'name' => __("Content", 'ultimatum'),
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
        'cufon'           => false,
    ),
    array(
        "type" => "endnosave"
    ),
    array(
        "type" => "justsave"
    )
);
return array(
		'auto' => true,
		'name' => 'css',
		'options' => $options
);