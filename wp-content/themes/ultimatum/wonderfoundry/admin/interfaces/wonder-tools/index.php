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
ob_start();
function ultimatum_toolset(){
	if(isset($_REQUEST['task']) && 'reset_toolset'==$_REQUEST['task']){
		$resettab =' nav-tab-active';
		$statustab='';
	} else {
		$statustab =' nav-tab-active';
		$resettab='';
	}
	//
	?>
	<div class="wrap about-wrap ult-wrap">
		<h1><?php  _e( 'Welcome to Ultimatum ToolSet','ultimatum' ); ?></h1>
		<div class="about-text">
			<?php _e('Ultimatum ToolSet is central control Panel for Ultimatum and available Themes/Plugins to extend it.','ultimatum'); ?>
		</div>
		<div class="ut-badge"></div>
		<h2 class="nav-tab-wrapper">
			<a href="./admin.php?page=ultimatum_toolset" class="nav-tab<?php echo $statustab;?>">
				<?php _e( 'Status','ultimatum' ); ?>
			</a>
			<a href="./admin.php?page=ultimatum_toolset&task=reset_toolset" class="nav-tab<?php echo $resettab;?>">
				<?php _e( 'Reset','ultimatum' ); ?>
			</a>
		</h2>
		<?php 
		if(isset($_REQUEST['task']) && 'reset_toolset'==$_REQUEST['task']){
			if(isset($_POST['action']) && 'reset_toolset' ==$_POST['action']){
				delete_site_option('ultimatum_toolset');
				$location = trailingslashit(network_admin_url()).'admin.php?page=ultimatum_toolset_setup';
				wp_safe_redirect(esc_url_raw($location));
			}
			echo '<p>';
			_e('If you have moved the site from another domain Toolset will fail to receive updates as each domain is licensed seperately.', 'ultimatum');
			echo '</p></p>';
			_e(' To overcome the issue please reset toolset reqistry with below button. You will be sent back to toolset login page so you can register the new domain.','ultimatum');
			echo '</p>';
			?>
			<form action="" method="post">
				<input type="hidden" name="action" value="reset_toolset" />
				<input type="submit" value="<?php _e('Reset ToolSet', 'ultimatum');?>" class="button button-primary button-hero" />
			</form>
			<?php 
		} else {
			$ultimatum_ts = get_site_option('ultimatum_toolset');
			$allowed= get_userdata($ultimatum_ts['allowed_user']);
			?>
			<p>
			<strong><?php _e('Ultimatum Toolset User','ultimatum');?></strong> : <?php echo $allowed->user_login;?><br />
			<em><?php _e('Any other user registered to this Site/Network will not be able to reach these screens','ultimatum');?></em>
			</p>
			<?php 
			include_once ULTIMATUM_ADMIN_HELPERS.'/class.options.php';
			$data = ultimatum_get_updates();
			if(!is_multisite()){
				$onur = new optionGenerator($data['options']['single']["name"], $data['options']['single']["options"]);
			} else {
				$onur = new optionGenerator($data['options']['multi']["name"], $data['options']['multi']["options"]);
			}
		}
		?>
	</div>
	<?php 
}