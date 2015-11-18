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

function ultimate_dynamic_sidebar($responsive=false,$index = 1,$grid=null) {
    global $wp_registered_sidebars, $wp_registered_widgets;

    if ( is_int($index) ) {
        $index = "sidebar-$index";
        echo $index;
    } else {
        $index = sanitize_title($index);
        foreach ( (array) $wp_registered_sidebars as $key => $value ) {
            if ( sanitize_title($value['name']) == $index ) {
                $index = $key;
                break;
            }
        }
    }
    $ultimatum_sidebars_widgets = ultimatum_get_sidebars_widgets();
    $sidebar["name"] = $index;
    $sidebar["id"] = $index;
    $did_one = false;
    if(isset($ultimatum_sidebars_widgets[$index])):
        foreach ( (array) $ultimatum_sidebars_widgets[$index] as $id ) {
            if ( !isset($wp_registered_widgets[$id]) ) continue;
            $params = array_merge(
                array( array_merge( $sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']) ) ),
                (array) $wp_registered_widgets[$id]['params']
            );
            $classname_ = '';
            foreach ( (array) $wp_registered_widgets[$id]['classname'] as $cn ) {
                if ( is_string($cn) )
                    $classname_ .= '_' . $cn;
                elseif ( is_object($cn) )
                    $classname_ .= '_' . get_class($cn);
            }
            $classname_ = ltrim($classname_, '_');
            $col = str_replace('sidebar', 'col',$index);
            global $wpdb;
            $csstable = $wpdb->prefix.ULTIMATUM_PREFIX.'_css';
            $query = "SELECT * FROM $csstable WHERE `container`='$col' AND `element`='general'";
            $fecth = $wpdb->get_row($query,ARRAY_A);
            if($fecth){
                $properties =unserialize($fecth['properties']);
            }
            $lw=0;
            $rw=0;
            if(isset($properties['padding-left'])){
                $lw = str_replace('px','', $properties['padding-left']);
            }
            if(isset($properties['padding-right'])){
                $rw = str_replace('px','', $properties['padding-right']);
            }
            $tag = (get_ultimatum_option('tags', 'multi_widget') ? get_ultimatum_option('tags', 'multi_widget') : 'h3');
            if(is_singular()){
                $tag = (get_ultimatum_option('tags', 'single_widget') ? get_ultimatum_option('tags', 'single_widget') :'h3');
            }
            $params[0]['grid_width']=$grid-($lw+$rw);
            $params[0]['before_widget']='<div class="widget '.$classname_.' inner-container">';
            $params[0]['after_widget']='</div>';
            $params[0]['before_title']=' <'.$tag.' class="element-title">';
            $params[0]['after_title'] = '</'.$tag.'>';
            $params[0]['responsivetheme']=$responsive;
            $params = apply_filters( 'dynamic_sidebar_params', $params );
            /* We will visit this again in Ultimatum 3.0
            echo '<pre>';
            print_r($wp_registered_widgets[$id]);
            echo '</pre>';
            $wopt =  $wp_registered_widgets[$id]['callback'][0]->option_name;
            $nr =  $wp_registered_widgets[$id]['params'][0]['number'];
            $opt = get_option($wopt);
            echo '<pre>';
            print_r($opt[$nr]);
            echo '</pre>';
            */
            $callback = $wp_registered_widgets[$id]['callback'];
            do_action( 'dynamic_sidebar', $wp_registered_widgets[$id] );
            if ( is_callable($callback) ) {
                call_user_func_array($callback, $params);
                $did_one = true;
            }
            //3954
        }
    endif;
    return $did_one;
}


function ultimate_wp_list_widget_controls( $sidebar ) {
    add_filter( 'dynamic_sidebar_params', 'wp_list_widget_controls_dynamic_sidebar' );
    echo "<div id='$sidebar' class='widgets-sortables ui-sortable'>\n";
    $description = wp_sidebar_description( $sidebar );
    if ( !empty( $description ) ) {
        echo "<div class='sidebar-description'>\n";
        echo "\t<p class='description'>$description</p>";
        echo "</div>\n";
    }
    ultimate_dynamic_sidebar(false, $sidebar );
    echo "</div>\n";
}




function ultimatum_create_row($layout_id,$row_style) {
    global $wpdb;
    $table = $wpdb->prefix.ULTIMATUM_PREFIX.'_rows';
    $insert = "INSERT INTO $table (`layout_id`,`type_id`) VALUES ('$layout_id','$row_style')";
    $wpdb->query($insert);
    $row_id = $wpdb->insert_id;
    $query = "SELECT * FROM $table WHERE id='$row_id'";
    $row=$wpdb->get_row($query,ARRAY_A);
    include (ULTIMATUM_ADMIN.DS.'ajax'.DS.'row-generator.php');
}

function ultimatum_get_sidebars_widgets($deprecated = true) {
    if ( $deprecated !== true )
        _deprecated_argument( __FUNCTION__, '2.8.1' );

    global $wp_registered_widgets, $_wp_sidebars_widgets, $ultimatum_sidebars_widgets;

    // If loading from front page, consult $_wp_sidebars_widgets rather than options
    // to see if wp_convert_widget_settings() has made manipulations in memory.
    if ( !is_admin() ) {

        $ultimatum_sidebars_widgets = get_option('ultimatum_sidebars_widgets', array());
    } else {
        $ultimatum_sidebars_widgets = get_option('ultimatum_sidebars_widgets', array());
    }

    if ( is_array( $ultimatum_sidebars_widgets ) && isset($ultimatum_sidebars_widgets['array_version']) )
        unset($ultimatum_sidebars_widgets['array_version']);

    $ultimatum_sidebars_widgets = apply_filters('ultimatum_sidebars_widgets', $ultimatum_sidebars_widgets);
    return $ultimatum_sidebars_widgets;
}

function ultimatum_set_sidebars_widgets( $ultimatum_sidebars_widgets ) {
    if ( !isset( $ultimatum_sidebars_widgets['array_version'] ) )
        $ultimatum_sidebars_widgets['array_version'] = 3;
    update_option( 'ultimatum_sidebars_widgets', $ultimatum_sidebars_widgets );
}