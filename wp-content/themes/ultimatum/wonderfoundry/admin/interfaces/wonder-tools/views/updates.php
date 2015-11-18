<?php
//handle forced update
if ( isset($_GET['action']) && $_GET['action'] == 'update' ) {

	$result = ultimatum_refresh_updates();
	if ( is_array($result) ) {
		?><div class="updated fade"><p><?php _e('Update data successfully refreshed from Ultimatum API Server.', 'ultimatum'); ?></p></div><?php
	} else {
		?><div class="error fade"><p><?php _e('There was a problem refreshing data from Ultimatum API Server.', 'ultimatum'); ?></p></div><?php
	}

} else {
	ultimatum_refresh_local_projects();
}

$data = ultimatum_get_updates(); //load up the data
$ultimatum_updates_url = './admin.php?page=ultimatum_toolset_updates';
$allow_auto = true;
if (!ultimatum_allowed_user()) {
	$allow_auto = false;
}
?>
<style>
tr.wdv-update td, tr.wdv-changelog td { background-color: rgba(239,242,245,0.5); }
tr.wdv-changelog td { background:none; background-color: rgb(239, 247, 255); }

a.button-secondary { padding:6px 10px }
div#wpbody a.button-secondary:hover { color:#ffffff; }

div.wdv-changelog-drop > p { padding:10px 20px; }
.wdv-changelog-drop {
  display: none;
}
</style>
<div class="wrap">
<h2 class="nav-tab-wrapper">
<?php
$tab = ( !empty($_GET['tab']) ) ? $_GET['tab'] : 'available';

$tabs = array(
	'available'    => __('Available Updates', 'ultimatum'),
	'installed'    => __('Installed', 'ultimatum')
);
$tabhtml = array();

foreach ( $tabs as $stub => $title ) {
	$class = ( $stub == $tab ) ? ' nav-tab-active' : '';
	$tabhtml[] = '	<a href="' . $ultimatum_updates_url . '&tab=' . $stub . '" class="nav-tab'.$class.'">'.$title.'</a>';
}

echo implode( "\n", $tabhtml );
?>
</h2>
<div class="clear"></div>

<div class="grid_container">

<?php 

switch( $tab ) {
	//---------------------------------------------------//
	case "available":
		?>
		<h2><?php _e('Ultimatum Updates Available', 'ultimatum') ?></h2>
		<?php
		$last_run = get_site_option('utoolset_last_run');
		$projects = array();
		if ( is_array( $data ) ) {
			$remote_projects = isset($data['toolset']) ? $data['toolset'] : array();
			$local_projects = ultimatum_get_local_projects();
			if ( is_array( $local_projects ) ) {
				foreach ( $local_projects as $local_id => $local_project ) {
					//skip if not in remote results
					if (!isset($remote_projects[$local_id]))
						continue;

					$type = $remote_projects[$local_id]['type'];

					$projects[$type][$local_id]['thumbnail'] = $remote_projects[$local_id]['thumbnail'];
					$projects[$type][$local_id]['name'] = $remote_projects[$local_id]['name'];
					$projects[$type][$local_id]['description'] = $remote_projects[$local_id]['short_description'];
					$projects[$type][$local_id]['url'] = $remote_projects[$local_id]['url'];
					$projects[$type][$local_id]['wp_config_url'] = $remote_projects[$local_id]['wp_config_url'];
					$projects[$type][$local_id]['ms_config_url'] = $remote_projects[$local_id]['ms_config_url'];
					$projects[$type][$local_id]['instructions_url'] = $remote_projects[$local_id]['instructions_url'];
					$projects[$type][$local_id]['support_url'] = $remote_projects[$local_id]['support_url'];
					$projects[$type][$local_id]['changelog'] = $remote_projects[$local_id]['changelog'];
					$projects[$type][$local_id]['autoupdate'] = true;
					
						if ($local_project['type'] == 'plugin') {
							$update_plugins = get_site_transient('update_plugins');
							if (isset($update_plugins->response[$local_project['filename']]->new_version))
								$projects[$type][$local_id]['remote_version'] = $update_plugins->response[$local_project['filename']]->new_version;
							else
								$projects[$type][$local_id]['remote_version'] = $local_project['version'];
						} else if ($local_project['type'] == 'theme') {
							$update_themes = get_site_transient('update_themes');
							if (isset($update_themes->response[$local_project['filename']]['new_version']))
								$projects[$type][$local_id]['remote_version'] = $update_themes->response[$local_project['filename']]['new_version'];
							else
								$projects[$type][$local_id]['remote_version'] = $local_project['version'];
						} else {
							$projects[$type][$local_id]['remote_version'] = $remote_projects[$local_id]['version'];
						}

					$projects[$type][$local_id]['local_version'] = $local_project['version'];
					$projects[$type][$local_id]['filename'] = $local_project['filename'];
					$projects[$type][$local_id]['type'] = $local_project['type'];

					if ( !version_compare($projects[$type][$local_id]['remote_version'], $local_project['version'], '>') ) {
						unset($projects[$type][$local_id]);
						continue;
					}
				}
			}
		}
		?>
		<p><?php _e('Here you can find information about any available updates for your installed Ultimatum child themes and plugins. Note that it is important to keep your themes and plugins updated for security, performance, and to maintain compatibility with the latest versions of WordPress. Most plugins and themes are able to be auto-updated depending on where they are installed.', 'ultimatum') ?></p>

		<form class="upgrade" name="upgrade-plugins" action="update-core.php?action=do-plugin-upgrade" method="post">


		<?php
		$form_fields = array();
		$rows = '';
		if (isset($projects['plugin']) && is_array($projects['plugin']) && count($projects['plugin']) > 0) {
			$class = (isset($class) && 'alternate' == $class) ? '' : 'alternate';
			foreach ($projects['plugin'] as $project_id => $project) {
				$local_version = $project['local_version'];
				$remote_version = $project['remote_version'];

				if ( $project['autoupdate'] && $project['type'] == 'plugin' ) {
					$upgrade_button_code = "<a href='" . wp_nonce_url( network_admin_url('update.php?action=upgrade-plugin&plugin=') . $project['filename'], 'upgrade-plugin_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum').'</a>';
					$form_fields[] = '<input type="hidden" value="'.$project['filename'].'" name="checked[]">';
				} else if ( $project['autoupdate'] && $project['type'] == 'theme') {
					$upgrade_button_code = "<a href='" . wp_nonce_url( network_admin_url('update.php?action=upgrade-theme&theme=') . $project['filename'], 'upgrade-theme_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum').'</a>';
					$form_fields[] = '<input type="hidden" value="'.$project['filename'].'" name="checked[]">';
				} 

				$upgrade_button = (version_compare($remote_version, $local_version, '>')) ? $upgrade_button_code : '';

			

				//=========================================================//
				$rows .= "<tr class='wdv-update " . $class . "'>";
				$rows .= "<td style='vertical-align:middle'><strong>{$project['name']}</strong></td>";
				$rows .= "<td style='vertical-align:middle'><strong>" . $local_version . "</strong></td>";
				$rows .= "<td style='vertical-align:middle'><strong><a href=".ULTIMATUM_API."?action=details&id={$project_id}&TB_iframe=true&width=640&height=800' class='thickbox' title='" . sprintf( __('View version %s details', 'ultimatum'), $remote_version ) . "'>{$remote_version}</a></strong></td>";
				$rows .= "<td style='vertical-align:middle'>" . $upgrade_button . "</td>";
				$rows .= "</tr>";
				$rows .= "<tr class='wdv-changelog'><td colspan='5'>";
				$rows .= "<div class='wdv-view-link'><a href='#'>" . __('View Changes', 'ultimatum') . " <i class='icon-chevron-down'></i></a></div>";
				$rows .= "<div class='wdv-changelog-drop'>" . $project['changelog'];
				$rows .= "<div class='wdv-close-link'><a href='#'>" . __('Close', 'ultimatum') . " <i class='icon-chevron-up'></a></div>";
				$rows .= "</div></td></tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
			}
		} else {
			$rows .= '<tr><td colspan="5">' . __('No Ultimatum plugin updates required', 'ultimatum') . '</td></tr>';
		}

		echo '<h3>' . __('Ultimatum Plugin Updates', 'ultimatum');
		if (count($form_fields) >= 2) {
			echo implode("\n", $form_fields);
			wp_nonce_field('upgrade-core');
			echo "<a href='#' class='button-secondary upgrade-all'><i class='icon-upload-alt'></i> ".__('Update All Plugins', 'ultimatum')."</a>";
		}
		echo '</h3>';

		echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'>
			<thead><tr>
			<th scope='col'>".__('Name', 'ultimatum')."</th>
			<th scope='col'>".__('Installed Version', 'ultimatum')."</th>
			<th scope='col'>".__('Latest Version', 'ultimatum')."</th>
			<th scope='col'>".__('Actions', 'ultimatum')."</th>
			</tr></thead>
			<tbody id='the-list'>
			";

			echo $rows;
		?>
		</tbody></table>
		</form>

		<form class="upgrade" name="upgrade-themes" action="update-core.php?action=do-theme-upgrade" method="post">
		<?php
		$form_fields = array();
		$rows = '';
		if (isset($projects['theme']) && is_array($projects['theme']) && count($projects['theme']) > 0) {
			$class = (isset($class) && 'alternate' == $class) ? '' : 'alternate';
			foreach ($projects['theme'] as $project_id => $project) {
				$local_version = $project['local_version'];
				$remote_version = $project['remote_version'];

				if ( $project['autoupdate'] && $project['type'] == 'plugin' ) {
					$upgrade_button_code = "<a href='" . wp_nonce_url( admin_url('update.php?action=upgrade-plugin&plugin=') . $project['filename'], 'upgrade-plugin_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum').'</a>';
					$form_fields[] = '<input type="hidden" value="'.$project['filename'].'" name="checked[]">';
				} else if ( $project['autoupdate'] && $project['type'] == 'theme'  ) {
					$upgrade_button_code = "<a href='" . wp_nonce_url( admin_url('update.php?action=upgrade-theme&theme=') . $project['filename'], 'upgrade-theme_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum').'</a>';
					$form_fields[] = '<input type="hidden" value="'.$project['filename'].'" name="checked[]">';
				} 

				$upgrade_button = (version_compare($remote_version, $local_version, '>')) ? $upgrade_button_code : '';

				$screenshot = $project['thumbnail'];

				//=========================================================//
				$rows .= "<tr class='wdv-update " . $class . "'>";
				$rows .= "<td style='vertical-align:middle'><strong>{$project['name']}</strong></td>";
				$rows .= "<td style='vertical-align:middle'><strong>" . $local_version . "</strong></td>";
				$rows .= "<td style='vertical-align:middle'><strong><a href='".ULTIMATUM_API."?action=details&id={$project_id}&TB_iframe=true&width=640&height=800' class='thickbox' title='" . sprintf( __('View version %s details', 'ultimatum'), $remote_version ) . "'>{$remote_version}</a></strong></td>";
				$rows .= "<td style='vertical-align:middle'>" . $upgrade_button . "</td>";
				$rows .= "</tr>";
				$rows .= "<tr class='wdv-changelog'><td colspan='5'>";
				$rows .= "<div class='wdv-view-link'><a href='#'>" . __('View Changes', 'ultimatum') . " <i class='icon-chevron-down'></i></a></div>";
				$rows .= "<div class='wdv-changelog-drop'>" . $project['changelog'];
				$rows .= "<div class='wdv-close-link'><a href='#'>" . __('Close', 'ultimatum') . " <i class='icon-chevron-up'></a></div>";
				$rows .= "</div></td></tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
			}
		} else {
			$rows .= '<tr><td colspan="5">' . __('No Ultimatum Child Theme updates required', 'ultimatum') . '</td></tr>';
		}

		echo '<h3>' . __('Ultimatum & Child Theme Updates', 'ultimatum');
		if (count($form_fields) >= 2) {
			echo implode("\n", $form_fields);
			wp_nonce_field('upgrade-core');
			echo "<a href='#' class='button-secondary upgrade-all'><i class='icon-upload-alt'></i> ".__('Update All Themes', 'ultimatum')."</a>";
		}
		echo '</h3>';

		echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'>
			<thead><tr>
			<th scope='col'>".__('Name', 'ultimatum')."</th>
			<th scope='col'>".__('Installed Version', 'ultimatum')."</th>
			<th scope='col'>".__('Latest Version', 'ultimatum')."</th>
			<th scope='col'>".__('Actions', 'ultimatum')."</th>
			</tr></thead>
			<tbody id='the-list'>
			";

			echo $rows;
		?>
		</tbody></table>
		</form>

		<p><?php _e('Please note that all data is updated every 12 hours.', 'ultimatum') ?> <?php _e('Last updated:', 'ultimatum'); ?> <?php echo get_date_from_gmt(date('Y-m-d H:i:s', $last_run), get_option('date_format') . ' ' . get_option('time_format')); ?> - <a id="refresh-link" href="<?php echo $ultimatum_updates_url; ?>&action=update"><i class='icon-refresh'></i> <?php _e('Update Now', 'ultimatum'); ?></a></p>
		<?php
		break;

	case "installed":
		?>
		<h2><?php _e('Ultimatum & Installed Extras', 'ultimatum') ?></h2>
		<?php
		$projects = array();
		if ( is_array( $data ) ) {
			$remote_projects = isset($data['toolset']) ? $data['toolset'] : array();
			$local_projects = ultimatum_get_local_projects();
			if ( is_array( $local_projects ) ) {
				foreach ( $local_projects as $local_id => $local_project ) {
					//skip if not in remote results
					if (!isset($remote_projects[$local_id]))
						continue;

					$type = $remote_projects[$local_id]['type'];

					$projects[$type][$local_id]['thumbnail'] = $remote_projects[$local_id]['thumbnail'];
					$projects[$type][$local_id]['name'] = $remote_projects[$local_id]['name'];
					$projects[$type][$local_id]['description'] = $remote_projects[$local_id]['short_description'];
					$projects[$type][$local_id]['url'] = $remote_projects[$local_id]['url'];
					$projects[$type][$local_id]['wp_config_url'] = $remote_projects[$local_id]['wp_config_url'];
					$projects[$type][$local_id]['ms_config_url'] = $remote_projects[$local_id]['ms_config_url'];
					$projects[$type][$local_id]['instructions_url'] = $remote_projects[$local_id]['instructions_url'];
					$projects[$type][$local_id]['support_url'] = $remote_projects[$local_id]['support_url'];
					$projects[$type][$local_id]['autoupdate'] = true;
					
						if ($local_project['type'] == 'plugin') {
							$update_plugins = get_site_transient('update_plugins');
							if (isset($update_plugins->response[$local_project['filename']]->new_version))
								$projects[$type][$local_id]['remote_version'] = $update_plugins->response[$local_project['filename']]->new_version;
							else
								$projects[$type][$local_id]['remote_version'] = $local_project['version'];
						} else if ($local_project['type'] == 'theme') {
							$update_themes = get_site_transient('update_themes');
							if (isset($update_themes->response[$local_project['filename']]['new_version']))
								$projects[$type][$local_id]['remote_version'] = $update_themes->response[$local_project['filename']]['new_version'];
							else
								$projects[$type][$local_id]['remote_version'] = $local_project['version'];
						} else {
							$projects[$type][$local_id]['remote_version'] = $remote_projects[$local_id]['version'];
						}

					$projects[$type][$local_id]['local_version'] = $local_project['version'];
					$projects[$type][$local_id]['filename'] = $local_project['filename'];
					$projects[$type][$local_id]['type'] = $local_project['type'];
				}
			}
		}
		?>
		<p><?php _e('Here you can find a list of the Ultimatum plugins and themes installed on this server, along with quick links to documentation and support for each.', 'ultimatum') ?></p>

		<h3><?php _e('Installed Ultimatum Plugins', 'ultimatum') ?></h3>
		<?php
		echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'>
			<thead><tr>
			<th scope='col'>".__('Name', 'ultimatum')."</th>
			<th scope='col'>".__('Installed Version', 'ultimatum')."</th>
			<th scope='col'>".__('Latest Version', 'ultimatum')."</th>
			<th scope='col'>".__('Actions', 'ultimatum')."</th>
			</tr></thead>
			<tbody id='the-list'>
			";

		if (isset($projects['plugin']) && is_array($projects['plugin']) && count($projects['plugin']) > 0) {
			$class = (isset($class) && 'alternate' == $class) ? '' : 'alternate';
			foreach ($projects['plugin'] as $project_id => $project) {
				$local_version = $project['local_version'];
				$remote_version = $project['remote_version'];

				$check = (version_compare($remote_version, $local_version, '>')) ? "style='background-color:#EFF7FF;'" : '';

				if ( $project['autoupdate'] && $project['type'] == 'plugin') {
					$upgrade_button_code = "<a href='" . wp_nonce_url( admin_url('update.php?action=upgrade-plugin&plugin=') . $project['filename'], 'upgrade-plugin_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum')."</a>";
				} else if ( $project['autoupdate'] && $project['type'] == 'theme' ) {
					$upgrade_button_code = "<a href='" . wp_nonce_url( admin_url('update.php?action=upgrade-theme&theme=') . $project['filename'], 'upgrade-theme_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum')."</a>";
				} 

				$upgrade_button = (version_compare($remote_version, $local_version, '>')) ? $upgrade_button_code : '';

				//get configure link
				$config_url = $active = false;
				if (is_multisite() && is_network_admin())
					$active = is_plugin_active_for_network($local_projects[$project_id]['filename']);
				else
					$active = is_plugin_active($local_projects[$project_id]['filename']);

				if ($active) {
					if (is_multisite() && is_network_admin())
						$config_url = empty($project['ms_config_url']) ? false : network_admin_url($project['ms_config_url']);
					else
						$config_url = empty($project['wp_config_url']) ? false : admin_url($project['wp_config_url']);
				}
				if ($config_url) $config_url = '<br /><a href="' . esc_url($config_url) . '"><i class="fa fa-cog"></i> ' . __('Configure', 'ultimatum') . '</a>';

				$screenshot = $project['thumbnail'];

				//=========================================================//
				echo "<tr class='wdv-installed " . $class . "' " . $check . " >";
				echo "<td style='vertical-align:middle'><strong>{$project['name']}</td>";
				echo "<td style='vertical-align:middle'><strong>" . $local_version . "</strong></td>";
				echo "<td style='vertical-align:middle'><strong><a href='".ULTIMATUM_API."?action=details&id={$project_id}&TB_iframe=true&width=640&height=800' class='thickbox' title='" . sprintf( __('View version %s details', 'ultimatum'), $remote_version ) . "'>{$remote_version}</a></strong></td>";
				echo "<td style='vertical-align:middle'>" . $upgrade_button . "</td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
			}
		} else {
			?><tr><td colspan="5"><?php _e('No installed Ultimatum plugins', 'ultimatum') ?></td></tr><?php
		}
		?>
		</tbody></table>

		<h3><?php _e('Ultimatum & Child Themes', 'ultimatum') ?></h3>
		
		<?php
		//echo '<pre>';print_r($projects);echo'</pre>';
		echo "
			<table cellpadding='3' cellspacing='3' width='100%' class='widefat'>
			<thead><tr>
			<th scope='col'>".__('Name', 'ultimatum')."</th>
			<th scope='col'>".__('Installed Version', 'ultimatum')."</th>
			<th scope='col'>".__('Latest Version', 'ultimatum')."</th>
			<th scope='col'>".__('Actions', 'ultimatum')."</th>
			</tr></thead>
			<tbody id='the-list'>
			";

		if (isset($projects['theme']) && is_array($projects['theme']) && count($projects['theme']) > 0) {
			$class = (isset($class) && 'alternate' == $class) ? '' : 'alternate';
			foreach ($projects['theme'] as $project_id => $project) {
				$local_version = $project['local_version'];
				$remote_version = $project['remote_version'];

				$check = (version_compare($remote_version, $local_version, '>')) ? "style='background-color:#EFF7FF;'" : '';

				if ( $project['autoupdate'] && $project['type'] == 'plugin' ) {
					$upgrade_button_code = "<a href='" . wp_nonce_url( admin_url('update.php?action=upgrade-plugin&plugin=') . $project['filename'], 'upgrade-plugin_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum')."</a>";
				} else if ( $project['autoupdate'] && $project['type'] == 'theme' ) {
					$upgrade_button_code = "<a href='" . wp_nonce_url( admin_url('update.php?action=upgrade-theme&theme=') . $project['filename'], 'upgrade-theme_' . $project['filename']) . "' class='button-secondary'><i class='icon-upload-alt'></i> ".__('Auto Update', 'ultimatum')."</a>";
				} 

				$upgrade_button = (version_compare($remote_version, $local_version, '>')) ? $upgrade_button_code : '';

				$screenshot = $project['image'];

				//=========================================================//
				echo "<tr class='wdv-installed " . $class . "' " . $check . " >";
				echo "<td style='vertical-align:middle'><strong>{$project['name']}</strong></td>";
				echo "<td style='vertical-align:middle'><strong>" . $local_version . "</strong></td>";
				echo "<td style='vertical-align:middle'><strong><a href='".ULTIMATUM_API."?action=details&id={$project_id}&TB_iframe=true&width=640&height=800' class='thickbox' title='" . sprintf( __('View version %s details', 'ultimatum'), $remote_version ) . "'>{$remote_version}</a></strong></td>";
				echo "<td style='vertical-align:middle'>" . $upgrade_button . "</td>";
				echo "</tr>";
				$class = ('alternate' == $class) ? '' : 'alternate';
				//=========================================================//
			}
		} else {
			?><tr><td colspan="5"><?php _e('No installed Ultimatum child themes', 'ultimatum') ?></td></tr><?php
		}
		?>
		</tbody></table>

		<?php
		break;
}
?>
</div>
</div>
<script>
jQuery(document).ready(function($) {
	//handle changelog slidedowns
	$('.wdv-view-link').click(function() {
		$(this).next('.wdv-changelog-drop').slideDown();
		$(this).hide();
		return false;
	});
	$('.wdv-close-link').click(function() {
		$(this).parent('.wdv-changelog-drop').hide();
		$(this).parent().prev('.wdv-view-link').show();
		return false;
	});
	$('a.upgrade-all').click(function() {
		$(this).parents("form").submit();
		return false;
	});
	// handle container heights
	function processHeight() {
		var browserHeight = document.body.offsetHeight,
		        wpcontent = document.getElementById('wpcontent'),
		  wpcontentHeight = wpcontent.offsetHeight;
		
		if ( wpcontentHeight < browserHeight ) {
			wpcontent.style.height = browserHeight + 'px';
		}
	}
	
	processHeight();
	window.onresize = function(){
		processHeight();
	}
});
</script>