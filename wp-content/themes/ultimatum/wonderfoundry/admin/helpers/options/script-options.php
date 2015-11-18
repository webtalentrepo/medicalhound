<?php
$options = array(
		array(
				"name" => __("Header and Footer Scripts", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Header Scripts", 'ultimatum'),
				"desc" => 'Paste any code you want to be included between &lt;head&gt;&lt;/head&gt; tags i.e Google Webmaster Tools',
				"id" => "head_scripts",
				"default" => "",
				'rows' => '5',
				"type" => "textarea"
		),
		array(
				"name" => __("Footer Scripts", 'ultimatum'),
				"desc" => 'Paste any code you want to be included right before &lt;/body&gt; tag i.e Google Analytics',
				"id" => "footer_scripts",
				"default" => "",
				'rows' => '5',
				"type" => "textarea"
		),
		array(
				"type" => "endnosave"
		),
        array(
            "name" => __("Do not use Combined and minimized JS", 'ultimatum'),
            "type" => "start"
        ),
        array(
            "name" => __('Uncombine JS','ultimatum'),
            "desc" => __("The javascript library Ultimatum uses is served as a combined minified file to increase page load speed (theme.global.tbs3.min.js/theme.global.tbs2.min.js) If you enable this option each js file will be enqueued seperately. Good for develpers.", 'ultimatum'),
            "id" => "combinedjs",
            "default" => false,
            "type" => "toggle"
        ),
        array(
            "type" => "endnosave"
        ),
        array(
            "name" => __("CDN Settings", 'ultimatum'),
            "type" => "start"
        ),
        array(
            "name" => __('JS and CSS from CDN','ultimatum'),
            "desc" => __("Some of the files we use are available via public CDNs if you want to use them enable this section. May or may not increase performance.", 'ultimatum'),
            "id" => "cdnsource",
            "default" => false,
            "type" => "toggle"
        ),
        array(
            "type" => "endnosave"
        ),
        /*
		array(
				"name" => __("CSS Combiner", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Combine CSS to one file", 'ultimatum'),
				"id" => "combinecss",
				"default" => false,
				"type" => "toggle"
		),
        array(
				"type" => "endnosave"
		),
        */
		array(
				"name" => __("Twitter OAUTH",'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Consumer key",'ultimatum'),
				"desc" => '',
				"id" => "tw_consumer_key",
				"default" => "",
				"size" => 20,
				"type" => "text"
		),
		array(
				"name" => __("Consumer Secret",'ultimatum'),
				"desc" => '',
				"id" => "tw_consumer_secret",
				"default" => "",
				"size" => 20,
				"type" => "text"
		),
		array(
				"name" => __("Access Token",'ultimatum'),
				"desc" => '',
				"id" => "tw_access_token",
				"default" => "",
				"size" => 20,
				"type" => "text"
		),
		array(
				"name" => __("Access Token Secret",'ultimatum'),
				"desc" => '',
				"id" => "tw_access_secret",
				"default" => "",
				"size" => 20,
				"type" => "text"
		),
				array(
						"type" => "endnosave"
				),
		
		array(
				"name" => __("Pretty Photo", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Theme", 'ultimatum'),
				"desc" => "",
				"id" => "pptheme",
				"default" => "facebook",
				"options" => array("default"=>__('Default', 'ultimatum'),
						"dark_rounded"=>__('Dark Rounded', 'ultimatum'),
						"dark_square"=>__('Dark Square', 'ultimatum'),
						"facebook"=>__('Facebook', 'ultimatum'),
						"ligt_rounded"=>__('Light Rounded', 'ultimatum'),
						"light_square"=>__('Light Square', 'ultimatum'),
				),
				"type" => "select"
		),
		array(
				"type" => "endnosave"
		),
		
		array(
				"name" => __("Google Web Fonts Char Set", 'ultimatum'),
				"type" => "start"
		),
		array (
				"name" => __("Charsets", 'ultimatum'),
				"desc" => __('Google by default sends out Latin Charset you can add more charsets however tehy will only work if they are existing in google libraries', 'ultimatum'),
				"id" => "google_charset",
				"default" => array(),
				"options" => array("latin"=>__('Latin', 'ultimatum'),
						"latin-ext"=>__('Latin Extended', 'ultimatum'),
						"cyrillic"=>__('Cyrillic', 'ultimatum'),
						"cyrillic-ext"=>__('Cyrillic Extended', 'ultimatum'),
						"greek"=>__('Greek', 'ultimatum'),
						"greek-ext"=>__('Greek Extended', 'ultimatum'),
				),
				"type" => "multiselect"),
				array(
						"type" => "end"
				),
		
				);
		return array(
				'auto' => true,
				'name' => 'ultimatum_scripts',
				'options' => $options
		);