<?php
function shortcode_column($atts, $content = null, $code) {
	return '<div class="'.$code.'">' . do_shortcode(trim($content)) . '</div>';
}

function shortcode_column_last($atts, $content = null, $code) {
	return '<div class="'.str_replace('_last','',$code).' last">' . do_shortcode(trim($content)) . '</div><div class="clearfix clear"></div>';
}

 

add_shortcode('one_half', 'shortcode_column');
add_shortcode('one_third', 'shortcode_column');
add_shortcode('one_fourth', 'shortcode_column');
add_shortcode('two_third', 'shortcode_column');
add_shortcode('three_fourth', 'shortcode_column');
add_shortcode('one_half_last', 'shortcode_column_last');
add_shortcode('one_third_last', 'shortcode_column_last');
add_shortcode('one_fourth_last', 'shortcode_column_last');
add_shortcode('two_third_last', 'shortcode_column_last');
add_shortcode('three_fourth_last', 'shortcode_column_last');