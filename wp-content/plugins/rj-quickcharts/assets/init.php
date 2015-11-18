<?php
if(!class_exists('RJ_Quickcharts_Assets'))
{
    class RJ_Quickcharts_Assets
    {

        public function __construct()
        {
            add_action('init', array(&$this, 'init'));
        }

        public function init()
        {
            wp_enqueue_style('quickcharts-script', plugins_url('/css/main.css?v='.rand(), __FILE__ ));
            wp_enqueue_style('quickcharts-script', plugins_url('/handsontable/dist/jquery.handsontable.full.css', __FILE__ ));
            wp_enqueue_script('handsontable-script', plugins_url('/handsontable/dist/jquery.handsontable.full.js?v='.rand(), __FILE__ ));

            wp_enqueue_script('main-script', plugins_url('/js/main.js?v='.rand(), __FILE__), array('jquery'));
        }
    }
}
