<?php
/*
 * Based On WP EDITOR WIDGET by David M&aring;rtensson, Odd Alicehttp://www.feedmeastraycat.net/
 */
//avoid direct calls to this file
if ( !defined( 'ABSPATH' ) ) {
    header( 'Status: 403 Forbidden' );
    header( 'HTTP/1.1 403 Forbidden' );
    exit();
}
if(!class_exists('ULT_WYSIWYG_WIDGET')) {
    class ULT_WYSIWYG_WIDGET
    {


        public function __construct()
        {

            add_action('widgets_init', array($this, 'widgets_init'));
            add_action('load-widgets.php', array($this, 'load_admin_assets'));
            add_action('load-admin_page_wonder-layout', array($this, 'load_admin_assets'));
            add_action('load-customize.php', array($this, 'load_admin_assets'));
            add_action('widgets_admin_page', array($this, 'output_ult_wysiwyg_widget_html'), 100);
            add_action('ult_layout_builder_after', array($this, 'output_ult_wysiwyg_widget_html'), 100);
            add_action('customize_controls_print_footer_scripts', array($this, 'output_ult_wysiwyg_widget_html'), 1);
            add_action('customize_controls_print_footer_scripts', array($this, 'customize_controls_print_footer_scripts'), 2);

            add_filter('ult_wysiwyg_widget_content', 'wptexturize');
            add_filter('ult_wysiwyg_widget_content', 'convert_smilies');
            add_filter('ult_wysiwyg_widget_content', 'convert_chars');
            add_filter('ult_wysiwyg_widget_content', 'wpautop');
            add_filter('ult_wysiwyg_widget_content', 'shortcode_unautop');
            add_filter('ult_wysiwyg_widget_content', 'do_shortcode', 11);

        } // END __construct()


        /**
         * Action: load-widgets.php
         * Action: load-customize.php
         */
        public function load_admin_assets()
        {

            wp_register_script('ult-wysiwyg-widget-js', ULTIMATUM_PLUGINS_URL.'/ult-wysiwyg-widget/assets/ult-wysiwyg-widget.js', array('jquery'), false);
            wp_enqueue_script('ult-wysiwyg-widget-js');

            wp_register_style('ult-wysiwyg-widget-css', ULTIMATUM_PLUGINS_URL.'/ult-wysiwyg-widget/assets/ult-wysiwyg-widget.css', array(), false);
            wp_enqueue_style('ult-wysiwyg-widget-css');

        } // END load_admin_assets()


        public function output_ult_wysiwyg_widget_html()
        {

            ?>
            <div id="ult-wysiwyg-widget-container" style="display: none;">
                <a class="close" href="javascript:UltWYSIWYGWidget.hideEditor();" title="<?php esc_attr_e('Close',  'ultimatum'); ?>"><span class="icon"></span></a>

                <div class="editor">
                    <?php
                    $settings = array(
                        'textarea_rows' => 20,
                    );
                    wp_editor('', 'ultwysiwygwidget', $settings);
                    ?>
                    <p>
                        <a href="javascript:UltWYSIWYGWidget.updateWidgetAndCloseEditor(true);"
                           class="button button-primary"><?php _e('Save and close', 'ultimatum'); ?></a>
                    </p>
                </div>
            </div>
            <div id="ult-wysiwyg-widget-backdrop" style="display: none;"></div>
        <?php

        } // END output_ult_wysiwyg_widget_html

        /**
         * Action: customize_controls_print_footer_scripts
         */
        public function customize_controls_print_footer_scripts()
        {

            // Because of https://core.trac.wordpress.org/ticket/27853
            // Which was fixed in 3.9.1 so we only need this on earlier versions
            $wp_version = get_bloginfo('version');
            if (version_compare($wp_version, '3.9.1', '<') && class_exists('_WP_Editors')) {
                _WP_Editors::enqueue_scripts();
            }

        } // END customize_controls_print_footer_scripts

        /**
         * Action: widgets_init
         */
        public function widgets_init()
        {

          //  register_widget('WP_Editor_Widget');

        } // END widgets_init()

    } // END class WPEditorWidget

    global $ult_wysiwyg_widget;
    $ult_wysiwyg_widget = new ULT_WYSIWYG_WIDGET();
}

/* The iFrame preview is here in hook to ult/iframe/front */
add_action('ultimatum/iframe/front',"ult_wysiwyg_widget_preview");
function ult_wysiwyg_widget_preview(){
    if($_GET['ult-front-frame'] == "ult-wysiwyg-widget") {
        global $ultimatumlayout;
        $ultimatumlayout = getDefaultTempLateandLayout();
        echo '<head>';
        wp_head();
        echo '<script type="text/javascript"> var pptheme = "facebook"; </script></head>';
        echo '<body>';
        echo '<div class="wrapper">';
        echo '<div class="container container_12">';
        echo apply_filters('wp_editor_widget_content', urldecode(base64_decode($_GET['data'])));
        wp_footer();
        echo '</div></div></body></html>';
    }
}