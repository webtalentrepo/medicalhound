<?php
if(!class_exists('RJ_Quickcharts_Menu'))
{
    class RJ_Quickcharts_Menu
    {

        public function __construct()
        {
            add_action('init', array(&$this, 'init'));
        }

        public function init()
        {
            if ( current_user_can('edit_others_posts') ) {
                add_action('admin_menu', array(&$this, 'register_my_custom_menu_page'));
                add_action('admin_footer', array(&$this, 'css_for_rjqc_admin_menu'));
            }
        }

        public function register_my_custom_menu_page()
        {
            add_menu_page(
                'RJ Quickcharts',
                'RJ Quickcharts',
                'read',
                'rj-quickcharts/admin/rjqc-admin.php',
                '',
                '',
                '26.1'
            );
            add_submenu_page(
                'rj-quickcharts/admin/rjqc-admin.php',
                'My Charts',
                'My Charts',
                'read',
                'rj-quickcharts/admin/rjqc-admin.php'
            );
            add_submenu_page(
                'rj-quickcharts/admin/rjqc-admin.php',
                'New Chart',
                'New Chart',
                'read',
                'rj-quickcharts/admin/rjqc-admin-new.php'
            );
        }

        public function css_for_rjqc_admin_menu() {
            echo '
            <style type="text/css" media="screen">';
            if (get_bloginfo('version') >= 2.8) {
                echo
                '#toplevel_page_rj-quickcharts-admin-rjqc-admin div.wp-menu-image {
                    background: url('.plugins_url().'/rj-quickcharts/img/nav-chart.png) no-repeat 10px -15px !important;
                }
                #toplevel_page_rj-quickcharts-admin-rjqc-admin:hover div.wp-menu-image,
                #toplevel_page_rj-quickcharts-admin-rjqc-admin.wp-has-current-submenu div.wp-menu-image {
                    background-position: 10px 9px!important;
                }
                #adminmenu  #toplevel_page_rj-quickcharts-admin-rjqc-admin div.wp-menu-image:before {
                    content: "";
                }';
            } else {
                echo
                '#toplevel_page_rj-quickcharts-admin-rjqc-admin div.wp-menu-image {
                    background: url('.plugins_url().'/rj-quickcharts/img/nav-chart.png) no-repeat 6px -17px !important;
                }
                #toplevel_page_rj-quickcharts-admin-rjqc-admin:hover div.wp-menu-image,
                #toplevel_page_rj-quickcharts-admin-rjqc-admin.wp-has-current-submenu div.wp-menu-image {
                    background-position:6px 7px!important;
                }';
            }
            echo '</style>';
        }
    }
}
