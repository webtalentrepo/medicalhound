<?php
/*
 WARNING: This file is part of the core Ultimatum framework. DO NOT edit
 this file under any circumstances.
 */

/**
 * This file includes the native WP image resizing Function
 *
 * This file is a core Ultimatum file and should not be edited.
 *
 * @category Ultimatum
 * @package  Templates
 * @author   Wonder Foundry http://www.wonderfoundry.com
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     http://ultimatumtheme.com
 * @version 2.4
 */


function UltimatumImageResizer( $attach_id = null, $img_src = null,$width, $height, $crop = false ) {

	if ( $attach_id ) {
		$image_src = wp_get_attachment_image_src( $attach_id, 'full' );
		$file_path = get_attached_file( $attach_id );
		
	} elseif ( $img_src ) {
		if(is_array($img_src)){
			$file_path = $img_src['fpath'];
			$orig_size = getimagesize( $file_path );
			$image_src[0] = $img_src['url'];
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		} else {
			$domain = get_bloginfo('wpurl');
			$file_path= str_replace($domain,'',$img_src);
			$file_path = rtrim( ABSPATH, '/' ).$file_path;
			$orig_size = getimagesize( $file_path );
			$image_src[0] = $img_src;
			$image_src[1] = $orig_size[0];
			$image_src[2] = $orig_size[1];
		}
	} else {
		return ULTIMATUM_URL.'/assets/js/library/holder.js/'.round($width).'x'.round($height).'/auto/text:'.get_bloginfo().'__';
	}
	$file_info = pathinfo( $file_path );
	$extension = '.'. $file_info['extension'];
	$no_ext_path = $file_info['dirname'].'/'.$file_info['filename'];
	$cropped_img_path = $no_ext_path.'-'.$width.'x'.$height.$extension;
	if ( $image_src[1] > $width || $image_src[2] > $height ) {
		if ( file_exists( $cropped_img_path ) ) {
			$cropped_img_url = str_replace( basename( $image_src[0] ), basename( $cropped_img_path ), $image_src[0] );
			$ultimatumImage =  $cropped_img_url;
			if(class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'photon', Jetpack::get_active_modules() )) {
				$static_counter = rand( 0, 2 );
				$ultimatumImage = 'http://i'.$static_counter.'.wp.com/'.str_replace("http://","",$ultimatumImage);
			}
			return $ultimatumImage;
		}
		if ( $crop == false ) {
			$proportional_size = wp_constrain_dimensions( $image_src[1], $image_src[2], $width, $height );
			$resized_img_path = $no_ext_path.'-'.$proportional_size[0].'x'.$proportional_size[1].$extension;
			if ( file_exists( $resized_img_path ) ) {
				$new_img_size = getimagesize( $resized_img_path );
				$resized_img_url = str_replace( basename( $image_src[0] ), basename( $resized_img_path ), $image_src[0] );
				$ultimatumImage = $resized_img_url;
				if(class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'photon', Jetpack::get_active_modules() )) {
					$static_counter = rand( 0, 2 );
					$ultimatumImage = 'http://i'.$static_counter.'.wp.com/'.str_replace("http://","",$ultimatumImage);
				}
				return $ultimatumImage;
			}
		}
		if(function_exists('wp_get_image_editor')) {
		
			$editor = wp_get_image_editor($file_path);
		
			if ( is_wp_error( $editor ) || is_wp_error( $editor->resize( $width, $height, $crop ) ) )
				return false;
		
			$resized_file = $editor->save();
		
			if(!is_wp_error($resized_file)) {
				$new_img_path = $resized_file['path'];
			} else {
				return false;
			}
		
		} else {
			$new_img_path = ultimatum_image_resize( $file_path, $width, $height, $crop );
		}
		$new_img_size = getimagesize( $new_img_path );
		$new_img = str_replace( basename( $image_src[0] ), basename( $new_img_path ), $image_src[0] );
		$ultimatumImage = $new_img;
		if(class_exists( 'Jetpack' ) && method_exists( 'Jetpack', 'get_active_modules' ) && in_array( 'photon', Jetpack::get_active_modules() )) {
				$static_counter = rand( 0, 2 );
				$ultimatumImage = 'http://i'.$static_counter.'.wp.com/'.str_replace("http://","",$ultimatumImage);
			}
		return $ultimatumImage;
		
		
	}
	$ultimatumImage = $image_src[0];
	if(preg_match('/0.wp.com/i',$ultimatumImage) || preg_match('/1.wp.com/i',$ultimatumImage) || preg_match('/2.wp.com/i',$ultimatumImage) ){
		$ultimatumImage = modify_url($ultimatumImage,array('resize'=>$width.','.$height));
	}
	
	return $ultimatumImage;
}
function modify_url($url,$mod) 
{ 
    
    $query = explode("&", parse_url($url,PHP_URL_QUERY));
    if (!$query) {$queryStart = "?";} else {$queryStart = "&";}
    // modify/delete data 
    foreach($query as $q) 
    { 
        list($key, $value) = explode("=", $q); 
        if(array_key_exists($key, $mod)) 
        { 
            if($mod[$key]) 
            { 
                $url = preg_replace('/'.$key.'='.$value.'/', $key.'='.$mod[$key], $url); 
            } 
            else 
            { 
                $url = preg_replace('/&?'.$key.'='.$value.'/', '', $url); 
            } 
        } 
    } 
    // add new data 
    foreach($mod as $key => $value) 
    { 
        if($value && !preg_match('/'.$key.'=/', $url)) 
        { 
            $url .= $queryStart.$key.'='.$value; 
        } 
    } 
    return $url; 
}
function ultimatum_image_resize( $file, $max_w, $max_h, $crop = false, $suffix = null, $dest_path = null, $jpeg_quality = 90 ) {

    $editor = wp_get_image_editor( $file );
    if ( is_wp_error( $editor ) )
        return $editor;
    $editor->set_quality( $jpeg_quality );

    $resized = $editor->resize( $max_w, $max_h, $crop );
    if ( is_wp_error( $resized ) )
        return $resized;

    $dest_file = $editor->generate_filename( $suffix, $dest_path );
    $saved = $editor->save( $dest_file );

    if ( is_wp_error( $saved ) )
        return $saved;

    return $dest_file;
}