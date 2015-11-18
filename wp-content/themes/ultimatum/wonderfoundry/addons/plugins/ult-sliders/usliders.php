<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @package  Ultimatum
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.50
 */
 
register_post_type('ult_slideshow', array(
	'labels' => array(
		'name' => _x('Slideshows', 'post type general name', 'ultimatum' ),
		'singular_name' => _x('Slideshow', 'post type singular name', 'ultimatum' ),
		'add_new' => _x('Add New', 'ult_slideshow', 'ultimatum' ),
		'add_new_item' => __('Add New Slideshow', 'ultimatum' ),
		'edit_item' => __('Edit Slideshow', 'ultimatum' ),
		'new_item' => __('New Slideshow', 'ultimatum' ),
		'view_item' => __('View Slideshow', 'ultimatum' ),
		'search_items' => __('Search Slideshows', 'ultimatum' ),
		'not_found' =>  __('No Slideshow found', 'ultimatum' ),
		'not_found_in_trash' => __('No Slideshows found in Trash', 'ultimatum' ),
		'parent_item_colon' => '',
		'menu_name' => __('Slideshows', 'ultimatum' ),
	),
	'singular_label' => __('ult_slideshow', 'ultimatum' ),
	'public' => false,
	'publicly_queryable' => false,
	'exclude_from_search' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'menu_icon' => ULTIMATUM_ADMIN_ASSETS. '/images/slider_menu.png',  // Icon Path
	//'menu_position' => 20,
	'capability_type' => 'post',
	'hierarchical' => false,
	'supports' => array('title',),
	'has_archive' => false,
	'rewrite' => array( 'slug' => 'ult_slideshow', 'with_front' => false, 'pages' => false, 'feeds'=>false ),
	'query_var' => false,
	'can_export' => true,
	'show_in_nav_menus' => true,
));

require_once (ULTIMATUM_ADMIN_HELPERS.'/metabox.generator.php');
require_once (ULTIMATUM_ADMIN_HELPERS.'/metaboxes/gallery.php');