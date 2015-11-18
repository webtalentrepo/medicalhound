<?php
if(!class_exists('RJ_Quickcharts_Settings'))
{
	class RJ_Quickcharts_Settings
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// register actions
            add_action('admin_init', array(&$this, 'admin_init'));
        	add_action('admin_menu', array(&$this, 'add_menu'));
		} // END public function __construct

        /**
         * hook into WP's admin_init action hook
         */
        public function admin_init()
        {
        	// register your plugin's settings
        	register_setting('rj_quickcharts-group', 'setting_a');
        	register_setting('rj_quickcharts-group', 'setting_b');

        	// add your settings section
        	add_settings_section(
        	    'rj_quickcharts-section',
        	    'WP Plugin Template Settings',
        	    array(&$this, 'settings_section_rj_quickcharts'),
        	    'rj_quickcharts'
        	);

        	// add your setting's fields
            add_settings_field(
                'rj_quickcharts-setting_a',
                'Setting A',
                array(&$this, 'settings_field_input_text'),
                'rj_quickcharts',
                'rj_quickcharts-section',
                array(
                    'field' => 'setting_a'
                )
            );
            add_settings_field(
                'rj_quickcharts-setting_b',
                'Setting B',
                array(&$this, 'settings_field_input_text'),
                'rj_quickcharts',
                'rj_quickcharts-section',
                array(
                    'field' => 'setting_b'
                )
            );
            // Possibly do additional admin_init tasks
        } // END public static function activate

        public function settings_section_rj_quickcharts()
        {
            // Think of this as help text for the section.
            echo 'These settings do things for the WP Plugin Template.';
        }

        /**
         * This function provides text inputs for settings fields
         */
        public function settings_field_input_text($args)
        {
            // Get the field name from the $args array
            $field = $args['field'];
            // Get the value of this setting
            $value = get_option($field);
            // echo a proper input type="text"
            echo sprintf('<input type="text" name="%s" id="%s" value="%s" />', $field, $field, $value);
        } // END public function settings_field_input_text($args)

        /**
         * add a menu
         */
        public function add_menu()
        {
            // Add a page to manage this plugin's settings
        	add_options_page(
        	    'RJ Quickcharts Settings',
        	    'RJ Quickcharts',
        	    'manage_options',
        	    'rj_quickcharts',
        	    array(&$this, 'plugin_settings_page')
        	);
        } // END public function add_menu()

        /**
         * Menu Callback
         */
        public function plugin_settings_page()
        {
        	if(!current_user_can('manage_options'))
        	{
        		wp_die(__('You do not have sufficient permissions to access this page.'));
        	}

        	// Render the settings template
        	//include(sprintf("%s/templates/settings.php", dirname(__FILE__)));
            ?>
            <div class="wrap">
                <h2>RJ Quickcharts</h2>
                <p>Once you've created your first chart from the left
                    hand RJ Quickcharts menu item, you can easily
                    insert it in to a post by clicking the "Add
                    Media" button on your post or page.</p>
                <!--
                <form method="post" action="options.php">
                    <?php @settings_fields('rj_quickcharts-group'); ?>
                    <?php @do_settings_fields('rj_quickcharts-group'); ?>

                    <?php do_settings_sections('rj_quickcharts'); ?>

                    <?php @submit_button(); ?>
                </form>
                -->
            </div>
            <?
        } // END public function plugin_settings_page()
    } // END class WP_Plugin_Template_Settings
} // END if(!class_exists('WP_Plugin_Template_Settings'))
