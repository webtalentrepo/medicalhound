<?php
add_action('admin_enqueue_scripts','udefaultscreen_scripts');
add_action('admin_enqueue_scripts','udefaultscreen_styles');

function udefaultscreen_scripts(){
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script( 'ultimatum-bootstrap',ULTIMATUM_ADMIN_ASSETS.'/js/admin.bootstrap.min.js' );
}
function udefaultscreen_styles(){
	wp_enqueue_style('thickbox');
}
function about_screen(){
	?>
	<div class="wrap about-wrap ult-wrap">
	<h1><?php printf( __( 'Welcome to Ultimatum %s', 'ultimatum' ), ULTIMATUM_VERSION ); ?></h1>
				<div class="about-text">
						<?php printf( __( 'Ultimatum %s is only the beginning for you to get the most of WordPress.', 'ultimatum' ), ULTIMATUM_VERSION ); ?>
				</div>
				<div class="ut-badge">version <?php echo ULTIMATUM_VERSION; ?></div>
				
				<h2 class="nav-tab-wrapper">
					<a class="nav-tab nav-tab-active" href="">
						<?php _e( 'What&#8217;s New', 'ultimatum' ); ?>
					</a>
					
				</h2>
				<div class="changelog">
					<h3><?php _e( 'Register with Ultimatum Toolset!', 'ultimatum' ); ?></h3>
					<div class="feature-section">
						<h4><?php _e( 'Register your copy and get Updates, Themes and Plugins', 'ultimatum' ); ?></h4>
						<?php
						$ultimatum_toolset = get_site_option('ultimatum_toolset');
						if(is_array($ultimatum_toolset)){
							$link = rtrim(network_admin_url(),'/').'/admin.php?page=ultimatum_toolset'; 
						} else {
							 $link = rtrim(network_admin_url(),'/').'/admin.php?page=ultimatum_toolset_setup'; 
						}
						?>
						<p><?php _e( 'Ultimatum Toolset is your dashboard to extend the abilities of Ultimatum with its in-stock plugins and more.</p><p><strong><u>If you have been using the Premium Plugins included within Ultimatum you\'ll need to visit Ultimatum Toolset and install those plugins</u></strong>. If for some reason the Toolset Solution is not working, you can always download and install them manually via our <a href="//download.ultimatumtheme.com">Downloads Archive</a>.</p><p>PS: Toolset for multisites can be found in NetWork admin. (you need to have Ultimatum enabled as main sites theme)</p>', 'ultimatum' ); ?></p>
						<p><a href="<?php echo $link; ?>" class="button button-hero button-primary">Ultimatum Toolset</a></p>
					</div>
				</div>
				<div class="changelog">
                    <div class="feature-section col two-col about-updates">
                        <div class="col-1">
                            <h3><?php _e( 'Finally Bootstrap 3', 'ultimatum' ); ?></h3>
                            <p><?php _e('After long wait its here! Twitter Bootstrap3 and all ist Bootswatches are there for you to use.','ultimatum' );?></p>
                        </div>
                        <div class="col-2 last-feature">
                            <img src="http://ultimatumtheme.com/wp-content/uploads/2014/10/twitter-bootstrap-3-download-themes.jpg"  />
                        </div>
                    </div>
                    <div class="feature-section col two-col about-updates">
                        <div class="col-1">
                            <h3><?php _e( 'Mega? Mobile? No problem ;)', 'ultimatum' ); ?></h3>
                            <p><?php _e('3 new menu scripts included in core. Ultimatum Menu, Side menu and mobile Dropdown menu.','ultimatum' );?></p>
                            <p><?php _e('Your websites will be he best navigated sites!','ultimatum')?></p>
                        </div>
                        <div class="col-2 last-feature">
                            <img src="http://ultimatumtheme.com/wp-content/uploads/2014/10/mega-menu-show.jpg"  />
                        </div>
                    </div>
					<div class="feature-section col two-col about-updates">
						<div class="col-1">
						<h3><?php _e( 'Let\'s Socialize!', 'ultimatum' ); ?></h3>
						<p><?php _e('Another long wait is over. Ultimatum Connect for BuddyPress is now available.','ultimatum' );?></p>
						<p><?php _e('Fully responsive and great looking communities are clicks away!','ultimatum')?></p>
						</div>
						<div class="col-2 last-feature">
						<img src="http://ultimatumtheme.com/wp-content/uploads/2014/10/ultimatum-connect-buddypress.jpg"  />
						</div>
					</div>
				</div>
				
				<div class="changelog">
					<h3><?php _e( 'Under the Hood', 'ultimatum' ); ?></h3>
	
					<div class="feature-section col two-col">
						<div>
							<h4><?php _e( 'Improved Speed', 'ultimatum' ); ?></h4>
							<p><?php _e( 'Ultimatum is now faster as it minimizes all CSS also has globals css and js which we combined and minified all js and css used globally.', 'ultimatum' ); ?></p>
						</div>
						<div class="last-feature">
							<h4><?php _e( 'Many bugs were killed!', 'ultimatum' ); ?></h4>
							<p><?php _e( 'Our team with help of powerful spray killed most of the bugs in system', 'ultimatum' ); ?></p>
						</div>
				</div>
				<div class="return-to-dashboard">
				</div>
	
			</div>
		</div>
		<?php
	
}

function install_ultimatum(){
	
	?>
	<div class="wrap about-wrap ult-wrap">
		<h1><?php printf( __( 'Welcome to Ultimatum %s Installer', 'ultimatum' ), 2.50 ); ?></h1>
		<div class="ut-badge">version 2.50</div>
		<p><?php _e('You are just a few steps behind using Ultimatum.','ultimatum');?></p>
		<div id="installer">
		<label>API KEY</label><input type="password" name="api_key" class="api_key">
		<button class="btn-info btn" id="api_submitter"><?php _e('Submit','ultimatum');?></button> 
		</div>
	</div>
	<?php 
	
}



