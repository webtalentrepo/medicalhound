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

/*-----------------------------------------------------------------------------------*/
/* Gallery Images Metabox */
/*-----------------------------------------------------------------------------------*/
if (! function_exists("ultimatum_image_gallery")) {
	function ultimatum_image_gallery($value, $default) {
		global $post;
		?>
	<div id="gallery_actions">
		<a title="Add Media" class="">
			<input type="button" class="upload_image_button button-primary" value="Add Image" id="add-image" name="add">
		</a>
	</div>

	<div id="galleryTableWrapper">
		<table class="widefat galleryTable" cellspacing="0">
			<thead>
				<tr>
					<th width="10" scope="row">&nbsp;</th>
					<th width="70" scope="row">Thumbnail</th>
					<th width="150" scope="row">Info</th>
					<th scope="row">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="4">
						<div>
							<ul id="imagesSortable">
							<?php
							$image_ids_str = get_post_meta($post->ID, '_image_ids', true);
							if(!empty($image_ids_str)){
								$image_ids = explode(',',str_replace('image-','',$image_ids_str));
								foreach($image_ids as $image_id){
									gallery_create_image_item($image_id);
								}
							}?>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<input type="hidden" id="gallery_image_ids" name="_image_ids" value="<?php echo get_post_meta($post->ID, '_image_ids', true);?>">
	</div>
<?php
	}
}
$pages = array();
if(get_ultimatum_option('extras', 'ultimatum_slideshows')){
		$pages[] = 'ult_slideshow';
}

if(get_ultimatum_option('extras', 'ultimatum_postgals')) {
	$checks = get_option('ultimatum_postgals');
	if(isset($checks) && is_array($checks) && count($checks)!=0){
	foreach($checks as $key=>$value){
		if($value==1){
			if(is_admin() && ultimatum_is_post_type($key)){
				ult_post_gallery_add_scripts_and_styles();
			}
			$pages[]=$key;
		}
	}
	}
}
if(count($pages)!=0){
$config = array(
	'title' => __('Gallery','ultimatum'),
	'id' => 'single',
	'pages' => $pages,
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
);

$options = array(
	array(
		"name" => __("Gallery",'ultimatum'),
		"id" => "_image_ids",
		"layout" => false,
		"default" => '',
		"function" => "ultimatum_image_gallery",
		"type" => "custom",
	),
);
new metaboxesGenerator($config,$options);
}
/*-----------------------------------------------------------------------------------*/
/* Gallery image ajax callback
/*-----------------------------------------------------------------------------------*/
//gallery insert image ajax action callback
function gallery_get_image_action_callback() {
	$html = gallery_create_image_item($_POST['id']);
	if (! empty($html)) {
		echo $html;
	} else {
		die(0);
	}
	die();
}
add_action('wp_ajax_theme-gallery-get-image', 'gallery_get_image_action_callback');



// gallery metabox function
function gallery_create_image_item($attachment_id) {
	$image = get_post($attachment_id);
	if ($image) {
		$meta = wp_get_attachment_metadata($attachment_id);
		$date = mysql2date(get_option('date_format'), $image->post_date);
		$size = $meta['width'] . ' x ' . $meta['height'] . 'pixel';
		include (ULTIMATUM_ADMIN_AJAX . '/metabox-image-item.php');
	}
}
	
/*-----------------------------------------------------------------------------------*/
/* Add scripts and styles for gallery */
/*-----------------------------------------------------------------------------------*/
function ult_slidergallery_add_scripts_and_styles() {
	wp_deregister_script('autosave');
	wp_enqueue_media();
	wp_register_script('theme-gallery', ULTIMATUM_ADMIN_ASSETS . '/js/gallery.js', array('jquery-ui-sortable'));
	wp_enqueue_script('theme-gallery');
	wp_register_style('theme-gallery-css', ULTIMATUM_ADMIN_ASSETS . '/css/slideshow-post.css');
	wp_enqueue_style('theme-gallery-css');
	add_thickbox();
}
function ult_post_gallery_add_scripts_and_styles() {
	wp_deregister_script('autosave');
	wp_register_script('theme-gallery', ULTIMATUM_ADMIN_ASSETS . '/js/gallery.js', array('jquery-ui-sortable'));
	wp_enqueue_script('theme-gallery');
	wp_register_style('theme-gallery-css', ULTIMATUM_ADMIN_ASSETS . '/css/slideshow-post.css');
	wp_enqueue_style('theme-gallery-css');
	add_thickbox();
}
if (isset($_GET['gallery_edit_image'])) {
	wp_register_script('theme-gallery-edit-image', ULTIMATUM_ADMIN_ASSETS . '/js/gallery-edit-image.js');
	wp_enqueue_script('theme-gallery-edit-image');
	
	wp_register_style('theme-gallery-edit-image', ULTIMATUM_ADMIN_ASSETS . '/css/slideshow-edit-image.css');
	wp_enqueue_style('theme-gallery-edit-image');
}
if(is_admin() && ultimatum_is_post_type('ult_slideshow')){
	ult_slidergallery_add_scripts_and_styles();
}




