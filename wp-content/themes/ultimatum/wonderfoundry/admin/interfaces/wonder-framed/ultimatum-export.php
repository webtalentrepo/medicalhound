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
 
add_action( 'load-dashboard_page_ultimatum-export', 'ultimatum_export_thickbox' );

function ultimatum_export_thickbox()
{
	iframe_header();
	Ultimatum_Exporter();
	iframe_footer();
	exit;
}

function ultimatum_export(){
	
}