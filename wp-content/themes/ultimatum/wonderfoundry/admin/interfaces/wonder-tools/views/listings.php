<style>

div.listings-container {
  width:100%;
  margin-right:0;
  float:left;
  height:auto;
  margin-top:0;
}

div.listings {
  width:100%;
  padding:0;
  float: left;
  position: relative;
}
div.listings ul { width:100%; display:inline-block; margin:0; padding:0; text-align:left; }
div.listings ul li {
  display: inline;

}
div.listings ul li{
  display:inline-block;
  width:33%;
  padding-bottom: 14px;
  padding-top: 14px;
  margin:0;
  /*text-align:center;*/
  vertical-align: top;
  position:relative;
  opacity:1;
}
div.listings ul li div{padding:0 2%;}
div.listings ul li.non-ultimatum{background:#fab9bc;padding-bottom:0}
.non-ultimatum-info{background:red;width:100%;position:absolute;top:0;left:0;text-align:center;line-height:2em;color:#fff}
</style>
<div class="wrap">
	<h1 class="section-header"><?php echo $page_title; ?></h1>
	<div id="filters">
		<?php 
			$tagsid = $page_type.'_tags';
			$tags = $data["$tagsid"];
			if(count($tags)>=2){
			echo '<a class="button button-primary button-small" href="#" data-filter="*">All</a> ';
				foreach($tags as $tag){
					$taglink = str_replace(' ', '-',strtolower($tag));
					echo '<a class="button button-primary button-small" href="#" data-filter=".'.$taglink.'">'.$tag.'</a> ';
				}
			}
		?>
	</div>
	<p></p>
</div>
<div class="listings-container">
	<div class="listings">
		<div class="listing-divider"></div>
		<div class="listing-divider2"></div>
		
		<ul data-page_type="<?php echo $page_type; ?>" id="ult-listing-container">
		<?php 
			if (isset($data['projects']) && is_array($data['projects'])) 
			foreach ($data['projects'] as $project) { ?>
			<?php
			if($data['access']>=$project['access']){
			$incompatible = false;
			if ($page_type != $project['type']) continue;
			//skip multisite only products if not compatible
			if ($project['requires'] == 'ms' && !is_multisite())
				$incompatible = __('Requires Multisite', 'ultimatum');
			//skip buddypress only products if not active
			if ($project['requires'] == 'bp' && !defined( 'BP_VERSION' ))
				$incompatible = __('Requires BuddyPress', 'ultimatum');

			//installed?
			$installed = (isset($local_projects[$project['id']])) ? true : false;
			//activated?
			$active = $activate_url = $deactivate_url = false;
			if ($installed) {
				if ($page_type == 'plugin') {
					if (is_multisite() && is_network_admin())
						$active = is_plugin_active_for_network($local_projects[$project['id']]['filename']);
					else
						$active = is_plugin_active($local_projects[$project['id']]['filename']);

					if ($active) {
						if ( !is_multisite() || current_user_can( 'manage_network_plugins' ) ) //only can activate if not multisite or have permissions in multisite
							$deactivate_url = wp_nonce_url( 'plugins.php?action=deactivate&amp;plugin=' . urlencode($local_projects[$project['id']]['filename']), 'deactivate-plugin_' . $local_projects[$project['id']]['filename'] );
					} else {
						if ( !is_multisite() || current_user_can( 'manage_network_plugins' ) ) //only can activate if not multisite or have permissions in multisite
							$activate_url = wp_nonce_url( 'plugins.php?action=activate&amp;plugin=' . urlencode($local_projects[$project['id']]['filename']), 'activate-plugin_' . $local_projects[$project['id']]['filename'] );
					}
				} else { //themes list
					if ( !is_multisite() ) { //only do theme config/activate stuff in single site
						$active = $local_projects[$project['id']]['filename'] == $current_theme;

						if ( !$active && current_user_can('switch_themes') ) {
							//$activate_url = wp_nonce_url( "themes.php?action=activate&amp;template=" . urlencode( $local_projects[$project['id']]['filename'] ) . "&amp;stylesheet=" . urlencode( $local_projects[$project['id']]['filename'] ), 'switch-theme_' . $local_projects[$project['id']]['filename'] );
						}
					}
				}
			}

			$config_url = false;
			if ($active) {
				if (is_multisite() && is_network_admin())
					$config_url = empty($project['ms_config_url']) ? false : network_admin_url($project['ms_config_url']);
				else
					$config_url = empty($project['wp_config_url']) ? false : admin_url($project['wp_config_url']);
			}

			// Alright, if we came up short up there ^ , try to find a settings link hooked into the plugin action links
			if ($active && !$config_url && $page_type == 'plugin') {
				$all_links = apply_filters('plugin_action_links_' . plugin_basename($local_projects[$project['id']]['filename']), array(), $local_projects[$project['id']]['filename']);
				if (!empty($all_links) && 1 === count($all_links)) { // We have some links, and we have one link - which is hopefully the settings link
					$href = preg_replace('/^.*(https?:\/\/[^\'"]+)[\'"].*/', '\1', $all_links[0]);
					if (!empty($href)) $config_url = $href;
				}
			}

			$action_class = '';
			if ('plugin' == $project['type']) {
				$action_class = ultimatum_can_auto_download_project($project['type'])
					? ((is_multisite() && is_network_admin()) ? 'install_plugin' : 'install_and_activate_plugin')
					:  'install_setup'
				;
			} else {
				$action_class = ultimatum_can_auto_download_project($project['type'])
					? 'install_theme'
					: 'install_setup'
				;
			}
			$installed_foreigner = (file_exists(WP_PLUGIN_DIR.'/'.$data['toolset'][$project_id]['standalone'])) ? true : false;
			$listing_class = '';
			if ($installed) $listing_class .= ' installed';
			if ($incompatible) $listing_class .= ' incompatible';
			$listing_class .=' '.str_replace(';',' ',str_replace(' ', '-',strtolower($project['tags'])));
			if(ultimatum_foreigner_project($project['id'])){ $listing_class .= ' non-ultimatum';}
			//for free members, add free class to free projects for styling
			?>
			<li class="listing-item<?php echo $listing_class; ?>">
				<div class="listing">
					<img src="<?php echo $project['image']; ?>" alt="<?php echo esc_attr($project['name']); ?>" width="100%">
					<h3><?php echo $project['name']; ?></h3>
					<!--  <p><?php echo substr($project['description'], 0, 120); ?>&hellip;  <a href="<?php echo $project['url']; ?>"><?php _e('Learn more', 'ultimatum'); ?></a></p>-->
					
				</div>
				<div class="install_wrap">
					<span class="target">
					<?php
					if ($installed) {
						/* ?><span class="wpmu-button icon installed"><i class="fa fa-ok icon-large"></i><?php _e('INSTALLED', 'ultimatum'); ?></span><?php */
					} else  if ($url = ultimatum_auto_install_url($project['id'])) {
						?><a href="<?php echo $url; ?>" data-downloading="<?php esc_attr_e(__('DOWNLOADING...', 'ultimatum')); ?>" data-installing="<?php esc_attr_e(__('INSTALLING...', 'ultimatum')); ?>" class="ultimatum-button button button-primary icon <?php echo $action_class; ?>"><i class="fa fa-download-alt icon-large"></i> <?php _e('INSTALL', 'ultimatum'); ?></a><?php
					}
					?>
					</span>
					<?php if ($installed) { ?>
					<div class="action_links">
						<?php if ($deactivate_url) { ?>
						<a href="<?php echo $deactivate_url; ?>" class="button button-primary"><i class="fa fa-off"></i> <?php echo is_network_admin() ? __('Network Deactivate', 'ultimatum') : __('Deactivate', 'ultimatum'); ?></a>
						<?php } else if ($activate_url) { ?>
						<a href="<?php echo $activate_url; ?>" class="button button-primary"><i class="fa fa-off"></i> <?php echo is_network_admin() ? __('Network Activate', 'ultimatum') : __('Activate', 'ultimatum'); ?></a>
						<?php } ?>
					</div>
					<?php } //end if installed ?>
					<?php if(ultimatum_foreigner_project($project['id'])){ ?>
						<span class="non-ultimatum-info"><?php _e('Non-ToolSet version is INSTALLED','ultimatum')?></span>
					<?php }	?>
					<div class="listing-hr"></div>
				</div>
			</li>
		<?php 
			}
			}
			?>
		</ul>
	</div>
</div>
<script type="text/javascript">
<!--
jQuery(document).ready(function(){
var container = jQuery('#ult-listing-container');
//initialize isotope
container.isotope({
	layoutMode : 'fitRows'
});

//filter items when filter link is clicked
jQuery('#filters a').click(function(){
var selector = jQuery(this).attr('data-filter');
container.isotope({ filter: selector });
return false;
});
});
//-->
</script>