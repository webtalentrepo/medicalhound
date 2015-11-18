<?php
/*
Plugin Name: RJ Quickcharts
Plugin URI: http://www.randyjensen.com
Description: Easily create charts for your WordPress site. Line charts, bar charts and pie charts currently supported.
Version: 0.5.9
Author: Randy Jensen
Author URI: http://www.randyjensen.com
*/

if(!class_exists('RJ_Quickcharts'))
{
    global $wpdb;
    global $rjqc_db_version;
    global $table_name;

    $rjqc_db_version = '0.5.9';
    $table_name = $wpdb->prefix . 'rj_quickcharts';

	class RJ_Quickcharts
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
        	// Initialize Settings
            //require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            //$RJ_Quickcharts_Settings = new RJ_Quickcharts_Settings();

            // Menu
            require_once(sprintf('%s/menu/init.php', dirname(__FILE__)));
            $RJ_Quickcharts_Menu = new RJ_Quickcharts_Menu();

            // Media Init
            require_once(sprintf('%s/media/init.php', dirname(__FILE__)));
            $RJ_Quickcharts_Media = new RJ_Quickcharts_Media();

            // Ajax
            require_once(sprintf('%s/ajax/init.php', dirname(__FILE__)));
            $RJ_Quickcharts_Ajax = new RJ_Quickcharts_Ajax();

            // Shortcode
            require_once(sprintf('%s/shortcode/init.php', dirname(__FILE__)));
            $RJ_Quickcharts_Shortcode = new RJ_Quickcharts_Shortcode();

            if (!get_option('rjqc_db_version')) {
                add_action('admin_notices', array($this, 'plugin_activation' ));
            }
		}

		public static function activate()
		{
            global $table_name;
            global $rjqc_db_version;

            $sql = "CREATE TABLE $table_name (
                id int(16) NOT NULL AUTO_INCREMENT,
                created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                type char(50) NOT NULL DEFAULT 'line',
                title varchar(200) NOT NULL,
                subtitle varchar(200) NOT NULL,
                tooltipSuffix varchar(200) NOT NULL,
                yAxisTitleText varchar(200) NOT NULL,
                xAxisCats longtext NOT NULL,
                legendOn int(0) NOT NULL,
                series longtext NOT NULL,
                hotSeries longtext NOT NULL,
                opts longtext NOT NULL,
                UNIQUE KEY id (id)
            );";

            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
            dbDelta( $sql );

            // Is there an upgrade? Make sure they have the latest database
            $installed_ver = get_option("rjqc_db_version");

            if($installed_ver != $rjqc_db_version) {

                $sql = "CREATE TABLE $table_name (
                    id int(16) NOT NULL AUTO_INCREMENT,
                    created datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
                    type char(50) NOT NULL DEFAULT 'line',
                    title varchar(200) NOT NULL,
                    subtitle varchar(200) NOT NULL,
                    tooltipSuffix varchar(200) NOT NULL,
                    yAxisTitleText varchar(200) NOT NULL,
                    xAxisCats longtext NOT NULL,
                    legendOn int(0) NOT NULL,
                    series longtext NOT NULL,
                    hotSeries longtext NOT NULL,
                    opts longtext NOT NULL,
                    UNIQUE KEY id (id)
                );";

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                dbDelta($sql);

                update_option("rjqc_db_version", $rjqc_db_version);
            }
		}

        public function plugin_activation() {
            global $rjqc_db_version;

            /*$html = '<div class="updated">';
            $html .= '<p>RJ Quickcharts has been activated <b>successfully</b>.</p>';
            $html .= '</div>';
            echo $html;*/

            add_option( "rjqc_db_version", $rjqc_db_version );
        }

		public static function deactivate()
		{
            delete_option("rjqc_db_version");
		}
	}
}

if(class_exists('RJ_Quickcharts'))
{
	register_activation_hook(__FILE__, array('RJ_Quickcharts', 'activate'));
	register_deactivation_hook(__FILE__, array('RJ_Quickcharts', 'deactivate'));

    function rjqc_update_db_check() {
        global $rjqc_db_version;
        if (get_site_option( 'rjqc_db_version' ) != $rjqc_db_version) {
            RJ_Quickcharts::activate();
        }
    }
    add_action( 'plugins_loaded', 'rjqc_update_db_check' );

    $rj_quickcharts = new RJ_Quickcharts();

    // Add a link to the settings page onto the plugin page
    /*if(isset($wp_plugin_template))
    {
        function plugin_settings_link($links)
        {
            $settings_link = '<a href="options-general.php?page=rj_quickcharts">Settings</a>';
            array_unshift($links, $settings_link);
            return $links;
        }

        $plugin = plugin_basename(__FILE__);
        add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
    }*/
}
