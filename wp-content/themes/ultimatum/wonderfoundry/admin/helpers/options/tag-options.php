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
 * @version 2.38
 */
$options = array(

		array(
				"name" => __("Headings for Multi Post Page", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Tag For Logo (site title)", 'ultimatum'),
				"id" => "multi_logo",
				"default" => 'h1',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Slogan (tag line)", 'ultimatum'),
				"id" => "multi_slogan",
				"default" => 'span',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Archive Title", 'ultimatum'),
				"id" => "archive_article",
				"default" => 'h1',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
		
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Articles", 'ultimatum'),
				"id" => "multi_article",
				"default" => 'h2',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Widget Titles", 'ultimatum'),
				"id" => "multi_widget",
				"default" => 'h3',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"type" => "end"
		),
		array(
				"name" => __("Headings for Single Post / Page", 'ultimatum'),
				"type" => "start"
		),
		array(
				"name" => __("Tag For Logo (site title)", 'ultimatum'),
				"id" => "single_logo",
				"default" => 'h1',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Slogan (tag line)", 'ultimatum'),
				"id" => "single_slogan",
				"default" => 'span',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Articles", 'ultimatum'),
				"id" => "single_article",
				"default" => 'h2',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"name" => __("Tag For Widget Titles", 'ultimatum'),
				"id" => "single_widget",
				"default" => 'h3',
				"options" => array(
						"h1"=>__('&lt;h1&gt;', 'ultimatum'),
						"h2"=>__('&lt;h2&gt;', 'ultimatum'),
						"h3"=>__('&lt;h3&gt;', 'ultimatum'),
						"h4"=>__('&lt;h4&gt;', 'ultimatum'),
						"h5"=>__('&lt;h5&gt;', 'ultimatum'),
						"h6"=>__('&lt;h6&gt;', 'ultimatum'),
						"div"=>__('&lt;div&gt;', 'ultimatum'),
						"span"=>__('&lt;span&gt;', 'ultimatum'),
						
				),
				"type" => "select"
		),
		array(
				"type" => "end"
		),
);
return array(
		'auto' => true,
		'name' => 'ultimatum_tags',
		'options' => $options
);