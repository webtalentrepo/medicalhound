<?php
ob_start();
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
 
function ultimatum_toolset_setup(){
	if(isset($_REQUEST['api_key'])){
		$apireturn = ultimatum_api_returned_check($_REQUEST['api_key']);	
	} elseif (isset($_REQUEST['e'])){ ?>
		<div class="error fade"><p><?php echo $_REQUEST['e'] ?></p></div>
	<?php 
	}
	
	?>
	<div class="wrap about-wrap">
	<h1 style="width:100%;text-align:center"><?php _e('Login to your Ultimatum Account','ultimatum');?></h1>
	<div class="login" style="width:50%;margin:0 auto;">
	<form name="loginform" id="loginform" action="<?php echo ULTIMATUM_API;?>" method="post" style="background:transparent;box-shadow:none">
	<p>
		<label for="user_login"><?php _e('Username','ultimatum');?><br />
		<input type="text" name="user" id="user_login" class="input" value="" size="20" /></label>
	</p>
	<p>
		<label for="user_pass"><?php _e('Password','ultimatum');?><br />
		<input type="password" name="pass" id="user_pass" class="input" value="" size="20" /></label>
	</p>
	<p style="text-align:center">
		<input type="hidden" name="site" value="<?php echo  network_home_url();?>" />
		<input type="hidden" name="admin" value="<?php echo network_admin_url();?>" />
		<input type="hidden" name="task" value="getapi" />
		<input type="submit" name="wp-submit" id="wp-submit" class="button button-primary button-hero" value="<?php _e('Log In','ultimatum');?>" />
	</p>
	</form>
	</div>
	<h3><?php _e('What is Tool Set and Why you need to register?','ultimatum');?></h3>
	<ol>
	<li><?php _e('Registering your site with ToolSet will grant you automatic Updates on Ultimatum and plugins included with it.','ultimatum');?></li>
	<li><?php _e('ToolSet is the control center and extension center of Ultimatum. You can access to the plugins we have included with Ultimatum via ToolSet.','ultimatum');?></li>
	</ol>
	<table>
	<?php access_check();?>
	</table>
	</div>
	<?php 
}
function access_check(){
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
	$posting['wp_remote_post']['note'] = __('wp_remote_post() was successful - Ultimatum Tool Set / Auto Update is working.', 'ultimatum' );
	$posting['wp_remote_post']['success'] = true;
} elseif ( is_wp_error( $response ) ) {
	$posting['wp_remote_post']['note'] = __( 'wp_remote_post() failed. Ultimatum Tool Set / Auto Updates won\'t work with your server. Contact your hosting provider. Error:', 'ultimatum' ) . ' ' . $response->get_error_message();
	$posting['wp_remote_post']['success'] = false;
	$ultimatum_notifier_count++;
} else {
	$posting['wp_remote_post']['note'] = __( 'wp_remote_post() failed. Ultimatum Tool Set / Auto Updates may not work with your server.', 'ultimatum' );
	$posting['wp_remote_post']['success'] = false;
	$ultimatum_notifier_count++;
}

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

