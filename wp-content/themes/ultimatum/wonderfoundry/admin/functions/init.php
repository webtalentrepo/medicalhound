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
 * @version 2.50
 */
global $ultimatum_notifier_count;
$ultimatum_notifier_count=0;
global $pagenow;
//if(is_admin() && isset($_GET['activated']) && $pagenow == "themes.php" ) {

//}

//
add_action('init', 'ultimatum_fontawesome');
function ultimatum_fontawesome(){
	wp_enqueue_style( 'font-awesome',ULTIMATUM_URL.'/assets/css/font-awesome.min.css' );
	wp_enqueue_style( 'inactive-disabler',ULTIMATUM_ADMIN_ASSETS.'/css/inactive-disabler.css' );
}

function ult_array_search($array, $key, $value)
{
	$results = array();

	ult_array_search_r($array, $key, $value, $results);

	return $results;
}

function ult_array_search_r($array, $key, $value, &$results,$skey=null)
{
	if (!is_array($array))
		return;

	if (isset($array[$key]) && $array[$key] == $value)
		$results[$skey] = $array;

	foreach ($array as $skey=>$subarray)
		ult_array_search_r($subarray, $key, $value, $results,$skey);
}

/**
 * Whether the current request is in post type pages
 *
 * @param mixed $post_types
 * @return bool True if inside post type pages
 */
function ultimatum_is_post_type($post_types = ''){
	if(ultimatum_is_post_type_list($post_types) || ultimatum_is_post_type_new($post_types) || ultimatum_is_post_type_edit($post_types) || ultimatum_is_post_type_post($post_types) || ultimatum_is_post_type_taxonomy($post_types)){
		return true;
	}else{
		return false;
	}
}
/**
 * Whether the current request is in post type list page
 *
 * @param mixed $post_types
 * @return bool True if inside post type list page
 */
function ultimatum_is_post_type_list($post_types = '') {
	if ('edit.php' != basename($_SERVER['PHP_SELF'])) {
		return false;
	}
	if ($post_types == '') {
		return true;
	} else {
		$check = isset($_GET['post_type']) ? $_GET['post_type'] : (isset($_POST['post_type']) ? $_POST['post_type'] : 'post');
		if (is_string($post_types) && $check == $post_types) {
			return true;
		} elseif (is_array($post_types) && in_array($check, $post_types)) {
			return true;
		}
		return false;
	}
}

/**
 * Whether the current request is in post type new page
 *
 * @param mixed $post_types
 * @return bool True if inside post type new page
 */
function ultimatum_is_post_type_new($post_types = '') {
	if ('post-new.php' != basename($_SERVER['PHP_SELF'])) {
		return false;
	}
	if ($post_types == '') {
		return true;
	} else {
		$check = isset($_GET['post_type']) ? $_GET['post_type'] : (isset($_POST['post_type']) ? $_POST['post_type'] : 'post');
		if (is_string($post_types) && $check == $post_types) {
			return true;
		} elseif (is_array($post_types) && in_array($check, $post_types)) {
			return true;
		}
		return false;
	}
}
/**
 * Whether the current request is in post type post page
 *
 * @param mixed $post_types
 * @return bool True if inside post type post page
 */
function ultimatum_is_post_type_post($post_types = '') {
	if ('post.php' != basename($_SERVER['PHP_SELF'])) {
		return false;
	}
	if ($post_types == '') {
		return true;
	} else {
		$post = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post']) ? $_POST['post'] : false);
		$check = get_post_type($post);

		if (is_string($post_types) && $check == $post_types) {
			return true;
		} elseif (is_array($post_types) && in_array($check, $post_types)) {
			return true;
		}
		return false;
	}
}
/**
 * Whether the current request is in post type edit page
 *
 * @param mixed $post_types
 * @return bool True if inside post type edit page
 */
function ultimatum_is_post_type_edit($post_types = '') {
	if ('post.php' != basename($_SERVER['PHP_SELF'])) {
		return false;
	}
	$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');
	if ('edit' != $action) {
		return false;
	}

	if ($post_types == '') {
		return true;
	} else {
		$post = isset($_GET['post']) ? $_GET['post'] : (isset($_POST['post']) ? $_POST['post'] : false);
		$check = get_post_type($post);

		if (is_string($post_types) && $check == $post_types) {
			return true;
		} elseif (is_array($post_types) && in_array($check, $post_types)) {
			return true;
		}
		return false;
	}
}
/**
 * Whether the current request is in post type taxonomy pages
 *
 * @param mixed $post_types
 * @return bool True if inside post type taxonomy pages
 */
function ultimatum_is_post_type_taxonomy($post_types = '') {
	if ('edit-tags.php' != basename($_SERVER['PHP_SELF'])) {
		return false;
	}
	if ($post_types == '') {
		return true;
	} else {
		$check = isset($_GET['post_type']) ? $_GET['post_type'] : (isset($_POST['post_type']) ? $_POST['post_type'] : 'post');
		if (is_string($post_types) && $check == $post_types) {
			return true;
		} elseif (is_array($post_types) && in_array($check, $post_types)) {
			return true;
		}
		return false;
	}
}

function ultimatum_remote_post_test($echo = false){
	$posting = array();
	global $ultimatum_notifier_count;
	// fsockopen/cURL
	$posting['fsockopen_curl']['name'] = __( 'fsockopen/cURL','ultimatum');
	if ( function_exists( 'fsockopen' ) || function_exists( 'curl_init' ) ) {
		if ( function_exists( 'fsockopen' ) && function_exists( 'curl_init' )) {
			$posting['fsockopen_curl']['note'] = __('Your server has fsockopen and cURL enabled.', 'ultimatum' );
		} elseif ( function_exists( 'fsockopen' )) {
			$posting['fsockopen_curl']['note'] = __( 'Your server has fsockopen enabled, cURL is disabled.', 'ultimatum' );
		} else {
			$posting['fsockopen_curl']['note'] = __( 'Your server has cURL enabled, fsockopen is disabled.', 'ultimatum' );
		}
		$posting['fsockopen_curl']['success'] = true;
	} else {
		$posting['fsockopen_curl']['note'] = __( 'Your server does not have fsockopen or cURL enabled - Ultimatum and other scripts which communicate with other servers will not work. Contact your hosting provider.', 'ultimatum' ). '</mark>';
		$posting['fsockopen_curl']['success'] = false;
		$ultimatum_notifier_count++;
	}
	
	
	// WP Remote Post Check
	$posting['wp_remote_post']['name'] = __( 'WP Remote Post','ultimatum');
	$request['cmd'] = '_notify-validate';
	global $wp_version;
	$params = array(
			'sslverify' 	=> false,
			'timeout' 		=> 60,
			'user-agent'	=> 'WordPress/' . $wp_version,
			'body'			=> $request
	);
	$response = wp_remote_post( 'https://api.ultimatumtheme.com', $params );
	
	if ( ! is_wp_error( $response ) && $response['response']['code'] >= 200 && $response['response']['code'] < 300 ) {
		$posting['wp_remote_post']['note'] = __('wp_remote_post() was successful - Ultimatum Auto Update is working.', 'ultimatum' );
		$posting['wp_remote_post']['success'] = true;
	} elseif ( is_wp_error( $response ) ) {
		$posting['wp_remote_post']['note'] = __( 'wp_remote_post() failed. Ultimatum Auto Updates won\'t work with your server. Contact your hosting provider. Error:', 'ultimatum' ) . ' ' . $response->get_error_message();
		$posting['wp_remote_post']['success'] = false;
		$ultimatum_notifier_count++;
	} else {
		$posting['wp_remote_post']['note'] = __( 'wp_remote_post() failed. Ultimatum Auto Updates may not work with your server.', 'ultimatum' );
		$posting['wp_remote_post']['success'] = false;
		$ultimatum_notifier_count++;
	}
	
	if($echo){
	foreach( $posting as $post ) { $mark = ( isset( $post['success'] ) && $post['success'] == true ) ? 'yes' : 'error';
	?>
						<tr>
			                <td><?php echo esc_html( $post['name'] ); ?>:</td>
			                <td>
			                	<mark class="<?php echo $mark; ?>">
			                    	<?php echo wp_kses_data( $post['note'] ); ?>
			                	</mark>
			                </td>
			            </tr>
			            <?php
		            }
}
}

function ultimatum_folder_permissions_check($echo = false){
global $ultimatum_notifier_count; 
$theme_root =  get_theme_root();
$upload_dir = wp_upload_dir();
$folders = array(
		array(
				'name'=>__('Themes Folder','ultimatum'),
				'folder'=>$theme_root
		),
		array(
				'name'=>__('Uploads Folder','ultimatum'),
				'folder'=>$upload_dir["basedir"]
		),
		array(
				'name'=>__('Font-Face Folder','ultimatum'),
				'folder'=>THEME_FONTFACE_DIR,
				'msg'=>true
		),
		array(
				'name'=>__('Cufon Folder','ultimatum'),
				'folder'=>THEME_CUFON_DIR,
				'msg'=>true
		)
);
foreach($folders as $folder){
	if(is_writable($folder["folder"])){
		if($echo){
			?>
				<tr>
         		<td><?php echo $folder["name"]; ?>:</td>
	         	<td>
	         	<mark class="yes">
	         	<?php	_e('Writable','ultimatum'); ?>
	         	</mark>
	         	</td>
         		</tr>
				<?php 
				}
			} else {
				$ultimatum_notifier_count++;
				if($echo){
				?>
				<tr>
				<td><?php echo $folder["name"]; ?>:</td>
	         	<td>
	         	<mark class="error">
	         	<?php 
	         	echo ' '.$folder["folder"].' ';
	         	_e('is not writable Ultimatum would not work fine please correct your file permissions.','ultimatum');
	         	if($folder['msg']){
				_e('<p>DO YOU HAVE ULTIMATUM LIBRARY INSTALLED?</p>','ultimatum');
				} 
	         	?>
				</mark>
	         	</td>
         		</tr>
         		<?php 
				}
			}
		}
}
function ultimatum_let_to_num( $size ) {
	$l 		= substr( $size, -1 );
	$ret 	= substr( $size, 0, -1 );
	switch( strtoupper( $l ) ) {
		case 'P':
			$ret *= 1024;
		case 'T':
			$ret *= 1024;
		case 'G':
			$ret *= 1024;
		case 'M':
			$ret *= 1024;
		case 'K':
			$ret *= 1024;
	}
	return $ret;
}
function ultimatum_mem_check($echo=false){
global $ultimatum_notifier_count;
$memory = ultimatum_let_to_num( WP_MEMORY_LIMIT );

if ( $memory < 67108864 ) {
 	$ultimatum_notifier_count++;
 	if($echo){ 
		echo '<mark class="error">' . sprintf( __( '%s - We recommend setting memory to at least 64MB. See: <a href="%s">Increasing memory allocated to PHP</a>', 'ultimatum' ), size_format( $memory ), 'http://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP' ) . '</mark>';
		}
} else {
	if($echo){
	echo '<mark class="yes">' . size_format( $memory ) . '</mark>';
	}
}
}
$notifications = get_site_transient( 'ultimatum_notifications_data' );

if(!$notifications){
//echo $notifications;
ultimatum_mem_check();
ultimatum_folder_permissions_check();
ultimatum_remote_post_test();
global $ultimatum_notifier_count;
set_site_transient('ultimatum_notifications_data', $ultimatum_notifier_count,60*60*12);
}

function ultimatum_get_loop_files($loopfile) {
	return get_file_data( $loopfile, array('name' => 'Loop Name', 'file' => 'Loop File', 'generator' => 'Loop Generator') );
}
