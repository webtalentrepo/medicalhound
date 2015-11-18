<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
this file under any circumstances.
*/

/**
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.38
 */
add_action('init','ult_register_cpt',5);
add_action('init','ult_register_taxonomy',5);

function ult_register_taxonomy(){
global $wpdb;
$table2 = $wpdb->prefix.ULTIMATUM_PREFIX.'_tax';
$query = "SELECT * FROM $table2";
$result = $wpdb->get_results($query,ARRAY_A);
foreach($result as $fetch){
	$properties = unserialize($fetch["properties"]);
		//set custom taxonomy values
			$label = esc_html($properties["label"]);
			$singular_label = esc_html($properties["singular_label"]);
			$rewrite_slug =  esc_html($properties["slug"]);
			$post_types = $fetch["pname"];

			//set custom label values
			$labels['name'] = $label;
			$labels['singular_name'] = $properties["singular_label"];
			$labels['search_items'] = 'Search ' .$label;
			$labels['popular_items'] ='Popular ' .$label;
			
			$labels['parent_item'] = 'Parent ' .$singular_label;
			$labels['parent_item_colon'] ='Parent ' .$singular_label. ':';
			$labels['edit_item'] ='Edit ' .$singular_label;
			$labels['update_item'] = 'Update ' .$singular_label;
			$labels['add_new_item'] ='Add New ' .$singular_label;
			$labels['new_item_name'] = 'New ' .$singular_label. ' Name';
			$labels['separate_items_with_commas'] = 'Separate ' .$label. ' with commas';
			$labels['add_or_remove_items'] ='Add or remove ' .$label;
			$labels['choose_from_most_used'] = 'Choose from the most used ' .$label;

			//register our custom taxonomies
			register_taxonomy( esc_html($properties["name"]),
				array($post_types),
				array( 
					'hierarchical' => true,
					'label' => $label,
					'show_ui' => true,
					'show_in_nav_menus' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => $rewrite_slug, 'with_front' => false ),
					'singular_label' => $singular_label,
					'labels' => $labels,
					) 
				);
			unset($properties);
			unset($labels);

}}

function ult_register_cpt(){
global $wpdb;
$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_ptypes';
$query = "SELECT * FROM $table";
$result = $wpdb->get_results($query,ARRAY_A);
foreach($result as $fetch){
	$properties = unserialize($fetch["properties"]);
		//set post type values
			$label = esc_html($properties["label"]);
			$singular = esc_html($properties["singular_label"]);
			$rewrite_slug = esc_html($properties["slug"]);
			$menu_position =  null ;
			$taxonomies = array();
			if(isset($properties['tags'])) { $taxonomies[]='post_tag';}
			if(isset($properties['categories'])) { $taxonomies[]='category';}
			$supports = ( !$properties["supports"] ) ? array() : $properties["supports"];
			//set custom label values
			$labels['name'] = $label;
			$labels['singular_name'] = $properties["singular_label"];
			$labels['add_new'] =  'Add ' .$singular;
			$labels['add_new_item'] = 'Add New ' .$singular;
			$labels['edit'] =  'Edit';
			$labels['edit_item'] =  'Edit ' .$singular;
			$labels['all_items'] = 'All ' .$label;
			$labels['new_item'] = 'New ' .$singular;
			$labels['view'] = 'View ' .$singular;
			$labels['view_item'] =  'View ' .$singular;
			$labels['search_items'] =  'Search ' .$label;
			$labels['not_found'] =  'No ' .$label. ' Found';
			$labels['not_found_in_trash'] = 'No ' .$label. ' Found in Trash';
			$labels['parent'] = 'Parent ' .$singular;
			register_post_type(esc_html($properties["name"]), array(
					'labels' =>$labels,
					'singular_label' => $singular,
					'public' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => false,
					'show_ui' => true,
					'show_in_menu' => true,
					//'menu_position' => 20,
					'capability_type' => 'post',
					'hierarchical' => false,
					'supports' => $supports,
					'show_in_nav_menus' => true,
					'has_archive' => true,
					'taxonomies' => $taxonomies,
					'rewrite' => array( 'slug' => $rewrite_slug, 'with_front' => false ),
					'query_var' => false,
					'can_export' => true,
					
		));
			unset($properties);
			unset($labels);
}
}
function slug_single($name){
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_ptypes';
	$query = "SELECT * FROM $table WHERE `name` = '$name'";
	$fetch = $wpdb->get_row($query,ARRAY_A);
	$properties = unserialize($fetch['properties']);
	$slug = $properties["slug"];
	return $slug;
}