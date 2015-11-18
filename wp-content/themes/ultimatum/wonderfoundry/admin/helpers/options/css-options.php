<?php
$aitself='';
$tagline='';
$opt = get_option('ultimatum_general');
if(isset($opt['text_logo']) && $opt["text_logo"]==1){
$aitself=array (
    "name"	=> __("Site Logo", 'ultimatum'),
    "id"	=> "cssvar108",
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
		);
$tagline= array (
	"name"	=> __("Tag Line", 'ultimatum'),
	"id"	=> "cssvar109",
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
		)
		;	
}
$options = array(
	array(
		"name" => __("General", 'ultimatum').'',
		"type" => "title"
	),
	array(
		"name" => __("Basic HTML", 'ultimatum'),
		"type" => "start"
	),
    array(
        "name"  => __('Body Background','ultimatum'),
        'id'    => 'cssvar1',
        'type'  =>  'background',
        'background-color'      => true,
        'background-repeat'     => true,
        'background-attachment' => true,
        'background-position'   => true,
        'background-image'      => true,
        'background-size'       => true,
    ),
    array(
        "name"  => __('Header Background','ultimatum'),
        'id'    => 'cssvar141',
        'type'  =>  'background',
        'background-color'      => true,
        'background-repeat'     => true,
        'background-attachment' => true,
        'background-position'   => true,
        'background-image'      => true,
        'background-size'       => true,
    ),
    array(
        "name"  => __('Footer Background','ultimatum'),
        'id'    => 'cssvar142',
        'type'  =>  'background',
        'background-color'      => true,
        'background-repeat'     => true,
        'background-attachment' => true,
        'background-position'   => true,
        'background-image'      => true,
        'background-size'       => true,
    ),
    array(
        'name' => 'General Font',
        'id' => 'cssvar1',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'H1',
        'id' => 'cssvar3',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'H2',
        'id' => 'cssvar4',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'H3',
        'id' => 'cssvar5',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'H4',
        'id' => 'cssvar6',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'H5',
        'id' => 'cssvar7',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'H6',
        'id' => 'cssvar8',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'Quotes',
        'id' => 'cssvar110',
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
        'default' => array(

        )
    ),
    array(
        'name' => 'links',
        'id' => 'cssvar9',
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
        'cufon'           => false,
        'default' => array(

        )
    ),
    array(
        'name' => 'links :hover',
        'id' => 'cssvar10',
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
        'cufon'           => false,
        'default' => array(

        )
    ),
	array(
		"type" => "end"
	),

	array(
		"name" => __("LOGO", 'ultimatum'),
		"type" => "start"
	),
    array(
        "name" => __("Margins ", 'ultimatum'),
        "id" => "cssvar2",
        'type' => 'margins',
        'margin-top'=>true,
        'margin-bottom'=>true,
    ),
	$aitself,
    $tagline,
	array(
		"type" => "endnosave"
	),

	array(
		"type" => "justSave"
	)
);
return array(
	'auto' => true,
	'name' => 'css',
	'options' => $options
);