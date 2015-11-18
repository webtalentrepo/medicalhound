<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */
 $help = array(
 		"tabs"=> array(
 				"tab1"=>array(
 						'title'	=> __('About Layouts', 'ultimatum'),
 						'content'	=>
						'<p>' . __('Ultimatum uses two types of layouts, Full layouts and partial layouts. Full layouts are the layouts you call directly to your front end while partial layouts are the parts you may want to re use in many layouts like header,footer etc. ','ultimatum' ) . '</p>' ,
 						),
 				"tab2"=>array(
 						'title'	=> __('Assign Layouts', 'ultimatum'),
 						'content'	=>
 						'<p>' .__('Ultimatum may assign layouts to post types categories and some core pages of Wordpress.','ultimatum') .'</p>'
 				),
 				
 				"tab3"=>array(
 						'title'	=> __('Creating a Layout', 'ultimatum'),
 						'content'	=>
 						'<p>' .__('Ultimatum uses rows to create structural layout of your page. So you will want to insert at least a row before you can drag and drop Elemnts(Widgets). If you are creating/editing a full layout you may also drag and drop partial layouts in your layout.','ultimatum') .'</p>'.
 						'<p style="color:red;font-weight:bold">' .__('The CONTENT is called with Wordpress Default Loop. Do not use Include Page for calling your content. That widget is supposed to be used as a WYSIWYG widget.','ultimatum') .'</p>'
 				),
 				
 				),
 		"sidebar" => 	'<p><strong>' . __('For more information:', 'ultimatum') . '</strong></p>' .
 						'<p>' . __('<a href="http://ultimatumtheme.com" target="_blank">Ultimatum Theme Home</a>', 'ultimatum') . '</p>' .
 						'<p>' . __('<a href="http://docs.ultimatumtheme.com" target="_blank">Ultimatum Documentation</a>', 'ultimatum') . '</p>' .
 						'<p>' . __('<a href="http://forums.ultimatumtheme.com" target="_blank">Ultimatum Forums</a>', 'ultimatum') . '</p>' .
 						'<p>' . __('<a href="http://marketplace.ultimatumtheme.com" target="_blank">Ultimatum Marketplace</a>', 'ultimatum') . '</p>'
 				
 		
 		);