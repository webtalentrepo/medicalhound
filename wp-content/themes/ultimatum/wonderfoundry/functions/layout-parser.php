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
 

function ultimatum_layout_header_content(){
	global $ultimatumlayout;
	global $theme_grid;
	global $ultimateresponsive;
	if(strlen($ultimatumlayout->before)>=1) $before = explode(',',$ultimatumlayout->before);
	if(isset($before) && count($before)>=1){
		do_action('ultimatum_before_headwrapper_open');
		echo '<header class="headwrapper">'."\n";
		do_action('ultimatum_after_headwrapper_open');
		foreach($before as $bl){
			callLayout($ultimatumlayout->id,$bl,$theme_grid,$ultimateresponsive,$ultimatumlayout->gridwork);
		}
		do_action('ultimatum_before_headwrapper_close');
		echo '</header>'."\n";
		do_action('ultimatum_after_headwrapper_close');
	}
	
}
function ultimatum_layout_body_content(){
	global $ultimatumlayout;
	global $theme_grid;
	global $ultimateresponsive;
	if(strlen($ultimatumlayout->rows)>=1) $rows = explode(',',$ultimatumlayout->rows);
	do_action('ultimatum_before_bodywrapper_open');
	echo '<div class="bodywrapper" id="bodywrapper">'."\n";
	do_action('ultimatum_after_bodywrapper_open');
	if(isset($rows) && count($rows)>=1){
		foreach($rows as $r){
			callLayout($ultimatumlayout->id,$r,$theme_grid,$ultimateresponsive,$ultimatumlayout->gridwork);
		}
	}
	do_action('ultimatum_before_bodywrapper_close');
	echo '</div>'."\n";
	do_action('ultimatum_after_bodywrapper_close');
	

}
function ultimatum_layout_footer_content(){
	global $ultimatumlayout;
	global $theme_grid;
	global $ultimateresponsive;
	
	if(strlen($ultimatumlayout->after)>=1) $after = explode(',',$ultimatumlayout->after);
	if(isset($after) && count($after)>=1){
		do_action('ultimatum_before_footwrapper_open');
		echo '<footer class="footwrapper">'."\n";
		do_action('ultimatum_after_footwrapper_open');
		foreach($after as $al){
			callLayout($ultimatumlayout->id,$al,$theme_grid,$ultimateresponsive,$ultimatumlayout->gridwork);
		}
		do_action('ultimatum_before_footwrapper_close');
		echo '</footer>'."\n";
		do_action('ultimatum_after_footwrapper_close');
	}

}
add_action('ultimatum_print_header','ultimatum_layout_header_content');
add_action('ultimatum_print_body','ultimatum_layout_body_content');
add_action('ultimatum_print_footer','ultimatum_layout_footer_content');

function callLayout($ultimatumlayout,$part,$theme_grid,$ultimateresponsive,$gridwork){
	foreach($theme_grid as $key=>$value){
		$$key = $value;
	}
	$partinfo= explode('-',$part);
	if($partinfo[0]!='row'){
		$ultimatumlayout = $partinfo[1];
	}
	global $wpdb;
	$table = $wpdb->prefix.ULTIMATUM_PREFIX.'_layout';
	$rtable = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
	$query = "SELECT * FROM $table WHERE `id`='$ultimatumlayout'";
	$ultimatumlayout = $wpdb->get_row($query,ARRAY_A);
	$table2 = $wpdb->prefix.ULTIMATUM_PREFIX.'_classes';
	$query2 = "SELECT * FROM $table2 WHERE `layout_id`='$ultimatumlayout[id]'";
	$results = $wpdb->get_results($query2);
	$classes=array();
	foreach($results as $result){
		$classes[$result->container] ='';
		if(strlen($result->user_class)!=0) $classes[$result->container]		.=	$result->user_class;
		if(strlen($result->hidephone)!=0) $classes[$result->container]		.=	' '.$result->hidephone;
		if(strlen($result->hidetablet)!=0) $classes[$result->container]		.=	' '.$result->hidetablet;
		if(strlen($result->hidedesktop)!=0) $classes[$result->container]	.=	' '.$result->hidedesktop;
	}
	
	if(!$ultimatumlayout){
		return;
	}
	if($partinfo[0]!='row'){
		$rows = explode(',',$ultimatumlayout["rows"]);
		if(count($rows)>=1){
			foreach ($rows as $row_id){
				$query = "SELECT * FROM $rtable WHERE id='".str_replace('row-','', $row_id)."'";
				$row = $wpdb->get_row($query,ARRAY_A);
				include (TEMPLATEPATH.DS.'wonderfoundry'.DS.'gridworks'.DS.$gridwork.DS.'row-generator.php');
				echo "\n";
			}
		}
	} else {
		$row_id= $partinfo[1];
		$query = "SELECT * FROM $rtable WHERE id='$row_id'";
		$row = $wpdb->get_row($query,ARRAY_A);
		include (TEMPLATEPATH.DS.'wonderfoundry'.DS.'gridworks'.DS.$gridwork.DS.'row-generator.php');
		echo "\n";
	}
}

function additonalClass($classes,$container){
    if(isset($classes[$container])){
        if(preg_match('/parallax/i', $classes[$container])){
            wp_enqueue_script('stellar-js');
            $classes[$container] .= '" data-stellar-background-ratio="0.5';
        }
        return $classes[$container];
    }

}

function additonalClassContainer($classes,$container,$gw){
    $result = '';
    $tbs3   = false;
    if($gw=='ultimatum'){
        $result = 'container_12 ';
    } elseif ($gw=='tbs'){
        $result = 'container ';
    } else {
        if(isset($classes[$container]) && preg_match('/container-fluid/i', $classes[$container])) {
        } else {
            $result = 'container ';
        }
    }
    if(isset($classes[$container])){
        $result .= $classes[$container];
       if(preg_match('/parallax/i', $classes[$container])){
            wp_enqueue_script('stellar-js');
            $result .='" data-stellar-background-ratio="0.5';
        }

    }
    return $result;
}
