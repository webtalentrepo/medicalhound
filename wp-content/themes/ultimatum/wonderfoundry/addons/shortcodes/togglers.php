<?php
function shortcode_toggle($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'title' => false
	), $atts));
	$content =  do_shortcode(trim($content));
	$randomnr=rand(1,1000000);
	$tabid= str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $title));
	$html = 
<<<HTML
<div class="panel-group accordion toggler" id="{$randomnr}">
  <div class="panel panel-default accordion-group">
    <div class="panel-heading accordion-heading">
      <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#{$randomnr}" href="#{$randomnr}{$tabid}">
     {$title}
      </a>
    </div>
    <div id="{$randomnr}{$tabid}" class="panel-collapse accordion-body collapse">
      <div class="panel-body accordion-inner">
        {$content}
      </div>
    </div>
  </div>
</div>
<div class="clearfix clear"></div>
HTML;
	return $html;
}
add_shortcode('ult_toggle', 'shortcode_toggle');
if(get_ultimatum_option('extras', 'ultimatum_shortcodes_legacy')){
	add_shortcode('toggle', 'shortcode_toggle');
}

function tab_func( $atts, $content = null ) {
    extract(shortcode_atts(array(
	    'title'      => '',
	    'active'      => '',
    ), $atts));
    global $tab_array;
    $tab_array[] = array('active'=>$active,'title' => $title, 'content' => trim(do_shortcode($content)));
    return $tab_array;
}
add_shortcode('ult_tab', 'tab_func');
if(get_ultimatum_option('extras', 'ultimatum_shortcodes_legacy')){
	add_shortcode('tab', 'tab_func');
}


function shortcode_tabs( $atts, $content = null ) {
    global $tab_array;
    $tab_array = array(); // clear the array
    $tabs_nav = '';
    $tabs_nav .= '<div class="tabs-wrapper ult_tabs">';
    $tabs_nav .= '<ul class="nav nav-tabs ult_tablinks">';
    $tabs_content ='<div class="tab-content">';
    do_shortcode($content); 
    foreach ($tab_array as $tab => $tab_attr_array) {
    $tabid= str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $tab_attr_array['title']));
	$tabs_nav .= '<li class="'.$tab_attr_array['active'].'"><a href="#'.$tabid.'" data-toggle="tab">'.$tab_attr_array['title'].'</a></li>';
	$tabs_content .= '<div class="tab-pane '.$tab_attr_array['active'].'" id="'.$tabid.'">'.$tab_attr_array['content'].'</div>';
    }
    $tabs_nav .= '</ul>';
    $tabs_output .= $tabs_nav . $tabs_content;
    $tabs_output .= '</div>';
    $tabs_output .= '</div>';
    $tabs_output .= '<div class="clear"></div>';
    return $tabs_output;
}
add_shortcode('ult_tabs', 'shortcode_tabs');
if(get_ultimatum_option('extras', 'ultimatum_shortcodes_legacy')){
	add_shortcode('tabs', 'shortcode_tabs');
}

function accordion_row( $atts, $content = null ) {
    extract(shortcode_atts(array(
	    'title'      => '',
    ), $atts));
    global $accordion_toggle_array;
    $accordion_toggle_array[] = array('title' => $title, 'content' => trim(do_shortcode($content)));
    return $accordion_toggle_array;
}
add_shortcode('ult_accrow', 'accordion_row');
if(get_ultimatum_option('extras', 'ultimatum_shortcodes_legacy')){
	add_shortcode('accrow', 'accordion_row');
}

function shortcode_accordion( $atts, $content = null ) {
    global $accordion_toggle_array;
    $accordion_toggle_array = array(); // clear the array
	$randomnr=rand(1,1000000);
    $accordion_output = '<div class="clear"></div>';
    $accordion_output .= '<div class="panel-group accordion ult_accordion" id="'.$randomnr.'">';
    do_shortcode($content); // execute the '[accordion_toggle]' shortcode first to get the title and content
    $i=0;
    foreach ($accordion_toggle_array as $tab => $accordion_toggle_attr_array) {
    	$tabid= str_replace(' ','',preg_replace("/[^A-Za-z0-9 ]/", '', $accordion_toggle_attr_array['title']));
    	$in='';
    	$active='';
    	if($i==0){
    		$in=' in';
    		$active =' active';
    	}
	$accordion_output .= '<div class="panel panel-default accordion-group">
							<div class="panel-heading accordion-heading">
								<a href="#'.$randomnr.$tabid.'" class="accordion-toggle'.$active.'" data-toggle="collapse" data-parent="#'.$randomnr.'">'.$accordion_toggle_attr_array['title'].'</a>
							</div>';
     $accordion_output .= '<div id="'.$randomnr.$tabid.'" class="panel-collapse accordion-body collapse'.$in.'">
     						<div class="panel-body accordion-inner">'.$accordion_toggle_attr_array['content'].'</div>
     					  </div></div>';
     $i++;
           }
    $accordion_output .= '</div>';
    $accordion_output .= '<div class="clear"></div>';
    return $accordion_output;
}
add_shortcode('ult_accordion', 'shortcode_accordion');
if(get_ultimatum_option('extras', 'ultimatum_shortcodes_legacy')){
	add_shortcode('accordion', 'shortcode_accordion');
}