<?php
$options = array(
	array(
			"name" => __("Ultimatum Menu ", 'ultimatum'),
			"type" => "start"
		),
    array(
        "name" => __("Margins ", 'ultimatum'),
        "id" => "cssvar123",
        'type' => 'margins',
        'margin-top'=>true,
        'margin-bottom'=>true,
    ),

		array(
				"name" => __("Menu Height ", 'ultimatum'),
				"id" => "cssvar124",
				"property" =>"line-height",
				"default" => "25",
				"type" => "textCSS"
		),
		array(
				"name" => __("Padding Between Items ", 'ultimatum'),
				"id" => "cssvar125",
				"property" =>"padding-right",
				"default" => "",
				"type" => "textCSS"
		),
		array(
				"name" => __("Menu Dropdown Width ", 'ultimatum'),
				"id"	=> "cssvar126",
				"property" =>"size",
				"default" => "",
				"type" => "textCSS"
		),
        array(
            "name" => __("Top Level Link Background ", 'ultimatum'),
            "id"	=> "cssvar128",
            "property" =>"background-color",
            "default" => "",
            "type" => "color"
        ),
        array(
            "name" => __("Top Level Link Hover & Active Background ", 'ultimatum'),
            "id"	=> "cssvar129",
            "property" =>"background-color",
            "default" => "",
            "type" => "color"
        ),
        array(
            "name" => __("Second Level Background ", 'ultimatum'),
            "id"	=> "cssvar132",
            "property" =>"background-color",
            "default" => "",
            "type" => "color"
        ),
        array(
            "name" => __("Second Level Hover & Active Background ", 'ultimatum'),
            "id"	=> "cssvar133",
            "property" =>"background-color",
            "default" => "",
            "type" => "color"
        ),
        array(
            "name" => __("Seperator Color ", 'ultimatum'),
            "id"	=> "cssvar134",
            "property" =>"border-color",
            "default" => "",
            "type" => "color"
        ),
    array(
        'id' => 'cssvar128',
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
        'cufon'           => false,
    ),
    array(
        'id' => 'cssvar129',
        'name' => __("Top level Links - Active & :hover", 'ultimatum'),
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
        'id' => 'cssvar127',
        'name' => __("Mega Menu Column and Widget Titles", 'ultimatum'),
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
        'id' => 'cssvar130',
        'name' => __("Sub level Links", 'ultimatum'),
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
        'id' => 'cssvar131',
        'name' => __("Sub level Links - Active & :hover", 'ultimatum'),
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