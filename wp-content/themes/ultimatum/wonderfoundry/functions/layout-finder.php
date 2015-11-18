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

add_action('ultimatum_find_layout','ultimatum_findLayout');
function ultimatum_findLayout(){
	global $post;
	global $ultimatumlayout;
	if($ultimatumlayout){
		return;
	}
	// 404 Assignment
	if(is_404()){
		$ultimatumlayout = getLayoutInfoFromAssignment('404');
	}
	// Search Assignment
	if(is_search()){
		$ultimatumlayout = getLayoutInfoFromAssignment('search');
	}
	//
	if(is_author()){
		$ultimatumlayout = getLayoutInfoFromAssignment('author');
	}
	if(is_front_page()){
		$ultimatumlayout = getLayoutInfoFromAssignment('home');
	}
	if(is_home()){
		$page_for_posts = get_option( 'page_for_posts' );
		$meta_key= THEME_SLUG.'_layout';
		$ultimatumlayout =  getLayoutInfo(get_post_meta($page_for_posts, $meta_key, true));
	}
	if(!$ultimatumlayout){
		if(is_single() || is_page()){ // look for individual post layout
			$meta_key= THEME_SLUG.'_layout';
			$ultimatumlayout =  getLayoutInfo(get_post_meta($post->ID, $meta_key, true));
			if(!$ultimatumlayout){
				$posttype = $post->post_type.'-single';
				$ultimatumlayout = getLayoutInfoFromAssignment($posttype);
			}
		} else { // Look for cats taxes for multiple posts
			if(is_category()){
				$thisCat = get_category(get_query_var('cat'),false);
				$posttype = 'cat-'.$thisCat->term_id;
				$ultimatumlayout = getLayoutInfoFromAssignment($posttype);
			} else if (is_tax()) {
				$posttype = $post->post_type;
				global $wp_query;
				$tax =  get_query_var('taxonomy');
				$term =  get_query_var('term');
				$posttype =  $posttype.'-'.$tax.'-'.$term;
				$ultimatumlayout = getLayoutInfoFromAssignment($posttype);
			} else if(is_tag()){
				$posttype = $post->post_type;
				global $wp_query;
				$tax =  'post_tag';
				$term =  get_query_var('tag');
				$posttype =  $posttype.'-'.$tax.'-'.$term;
				$ultimatumlayout = getLayoutInfoFromAssignment($posttype);
			}
			if(!$ultimatumlayout){
				$posttype =  str_replace($post->post_type.'_', '',$posttype);
				$ultimatumlayout = getLayoutInfoFromAssignment($posttype);
			}
		}
	}
	if(!$ultimatumlayout){ //look for post type layout
		$posttype=$post->post_type;
		$ultimatumlayout = getLayoutInfoFromAssignment($posttype);
	}
	if(!$ultimatumlayout){//none found go with default
		$ultimatumlayout = getDefaultTempLateandLayout();
	}
	add_filter('body_class','ultimatum_body_class',10);
	//print_r($ultimatumlayout);
}


add_action('ultimatum_find_layout','ultimatumLayoutInfoParser',20);
function ultimatumLayoutInfoParser(){
	global $ultimateresponsive;
	global $theme_grid;
	global $ultimatumlayout;
	$ultimateresponsive = false;
	if($ultimatumlayout->ttype==1){
		$ultimateresponsive = true;
		add_action('ultimatum_meta', 'ultimatum_add_noscale_meta');
	}
	$maxwidth = 'width';
	$maxmargin = 'margin';
	if($ultimatumlayout->ttype!=0){
		$widths = array($ultimatumlayout->width=>"a",$ultimatumlayout->mwidth=>"m",$ultimatumlayout->swidth=>"s");
		ksort($widths);
		$width_values = array_values($widths);
		if($width_values[2]!="a"){
			$maxwidth = $width_values[2].'width';
			$maxmargin = $width_values[2].'margin';
		} 
	}
	if($ultimatumlayout->gridwork!='tbs'){
		
		if(isset($ultimatumlayout->width)){
			$grid_width =	($ultimatumlayout->$maxwidth-(12*$ultimatumlayout->$maxmargin))/12;
			$rawmargin	=	$ultimatumlayout->$maxmargin;
		} else {
			$grid_width =	60;
			$rawmargin	=	20;
		}
		
	} else { //TBS
		if(isset($ultimatumlayout->width)){
			$grid_width =	($ultimatumlayout->$maxwidth-(11*$ultimatumlayout->$maxmargin))/12;
			$rawmargin	=	$ultimatumlayout->$maxmargin;
		} else {
			$grid_width = 	60;
			$rawmargin	=	20;
		}
	}
	for($i=1;$i<13;$i++){
		$grid = "grid_".$i;
		$theme_grid[$grid] = ($grid_width*$i)+(($i-1)*$rawmargin);
	}	
}

function ultimatum_add_noscale_meta(){
	echo '<meta name="viewport" content="width=device-width, minimum-scale=1.0, initial-scale=1.0; maximum-scale=4.0; user-scalable=yes" />';
}

function ultimatum_body_class($classes) {
    global $ultimatumlayout;
    $defaults = array(
        'type'  =>  'basic',
        'stickwidth'  =>  '300',
        'breakpoint'  =>  '992',
        'header' => false,
        'footer' => false,
        'class' => false,
    );
    $vals = get_option(THEME_SLUG.'_'.$ultimatumlayout->id.'_options');
    $layoutopts = wp_parse_args( $vals, $defaults );
    if($layoutopts['type']!="fluidsl" && $layoutopts['type']!="fluidsr") {
        if (isset($layoutopts['header']) && $layoutopts['header'] == 'sticky') {
            $classes[] = 'ut-sticky-header';
        }
    } else {
        if($layoutopts['type'] == 'fluidsl'){
            $classes[] = 'ut-fluid-sticky-left';
        }
        if($layoutopts['type'] == 'right'){
            $classes[] = 'ut-fluid-sticky-right';
        }
    }
    if(isset($layoutopts['footer']) && $layoutopts['footer']=='sticky'){
        $classes[] = 'ut-sticky-footer';
    }
    if(isset($layoutopts['footer']) && $layoutopts['footer']=='push'){
        $classes[] = 'ut-push-footer';
    }

    if(isset($layoutopts['class'])){
        $classes[] = $layoutopts['class'];
    }
    if($ultimatumlayout->gridwork!='ultimatum'){
        $classes[] = strtolower('ut-'.$ultimatumlayout->gridwork.'-'.$ultimatumlayout->swatch);
    } else {
        $classes[] = strtolower('ut-'.$ultimatumlayout->gridwork.'-default');
    }
    $classes[] = strtolower('ut-layout-'.sanitize_title($ultimatumlayout->title));
    return $classes;
}



