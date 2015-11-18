<?php
if(!class_exists('RJ_Quickcharts_Media'))
{
    class RJ_Quickcharts_Media
    {

        public function __construct()
        {
            add_action('init', array(&$this, 'init'));
        }

        public function init()
        {
            // Add media upload tabs
            add_filter('media_upload_tabs', array( &$this, 'media_add_rjquickcharts_tab' ));
            add_action('media_upload_rjquickcharts', array( &$this, 'media_include_rjquickcharts_iframe'));
            // Enqueue scripts on front end
            add_action('wp_enqueue_scripts', array( &$this, 'load_media_rjquickcharts_scripts'));
        }

        public function media_add_rjquickcharts_tab( $tabs )
        {
            $tab = array('rjquickcharts' => __('Insert Quickcharts', 'rjquickcharts'));
            return array_merge($tabs, $tab);
        }

        public function media_include_rjquickcharts_iframe()
        {
            return wp_iframe( array( &$this, 'media_render_rjquickcharts_tab'));
        }

        public function media_render_rjquickcharts_tab()
        {
            media_upload_header();

            echo "<div class='rjqc-area rjqc-area-media'>";

            global $wpdb;
            global $table_name;

            $sql="SELECT * FROM $table_name ORDER BY id DESC";
            $charts = $wpdb->get_results($sql);

            $chart_list = '';

            $chart_list .= '
            <style>.insert-chart-to-post{cursor:pointer;}</style>
            <div id="wpbody-content" aria-label="Main content" tabindex="0">
                <div class="wrap" style="padding:10px 0 10px 10px;">
                    <table class="widefat fixed" cellspacing="0" style="width:100%;">
                        <thead>
                            <tr>
                                <th scope="col" id="id" class="manage-column" width="50">Id</th>
                                <th scope="col" id="title" class="manage-column column-title" width="300">Title</th>
                                <th scope="col" id="subtitle" class="manage-column column-subtitle" style="">Y Axis Title</th>
                                <th scope="col" id="type" class="manage-column column-type" style="">Type</th>
                                <th scope="col" id="created" class="manage-column column-created" style="">Created</th>
                                <th scope="col" id="insert" class="manage-column column-insert" style="">Insert</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th scope="col" id="id" class="manage-column" width="50">Id</th>
                                <th scope="col" id="title" class="manage-column column-title" width="300">Title</th>
                                <th scope="col" id="subtitle" class="manage-column column-subtitle" style="">Y Axis Title</th>
                                <th scope="col" id="type" class="manage-column column-type" style="">Type</th>
                                <th scope="col" id="created" class="manage-column column-created" style="">Created</th>
                                <th scope="col" id="insert" class="manage-column column-insert" style="">Insert</th>
                            </tr>
                        </tfoot>
                        <tbody class="list:user user-list">';

                        if ($charts) {
                            foreach ($charts as $chart) {
                                $chart_list .= '
                                <tr class="author-self status-inherit" valign="top">
                                    <td class="column-id">'.$chart->id.'</td>
                                    <td class="column-title">
                                        <strong>
                                            <a class="insert-chart-to-post" data-id="'.$chart->id.'">
                                                '.$chart->title.'
                                            </a>
                                        </strong>
                                    </td>
                                    <td class="column-subtitle">
                                        '.$chart->yAxisTitleText.'
                                    </td>
                                    <td class="column-type" style="text-transform: capitalize;">
                                        '.$chart->type.'
                                    </td>
                                    <td class="column-created">
                                        '.date("F d, Y", strtotime($chart->created)).'
                                    </td>
                                    <td class="column-insert">
                                        <input type="submit" name="" class="button action insert-chart-to-post" data-id="'.$chart->id.'" value="Insert" style="margin-bottom:3px">
                                    </td>
                                </tr>';
                            }
                        } else {
                            $chart_list .= '
                                <tr>
                                    <td style="padding:9px 10px 10px;" colspan="5">You don\'t have any charts yet. <a href="admin.php?page=rj-quickcharts/admin/rjqc-admin-new.php">Create one now</a>!</td>
                                </tr>
                            ';
                        }

            $chart_list .= '</tbody>
                    </table>
                </div>
            </div>';

            echo $chart_list;

            echo '</div>';

            // Load styles
            echo '<script type="text/javascript" src="'.plugins_url("/js/main.js", dirname(__FILE__)).'"></script>';
        }

        public function load_media_rjquickcharts_scripts()
        {
            wp_enqueue_style('rjqc-jqplot', plugins_url('/rj-quickcharts/css/jquery.jqplot.min.css'));

            if(preg_match('/(?i)msie [1-8]/',$_SERVER['HTTP_USER_AGENT']))
            {
                wp_enqueue_script('quickcharts-script', plugins_url('/js/excanvas.min.js', dirname(__FILE__)), array('jquery'));
            }

            wp_enqueue_script('rjqc_jqplot_min', plugins_url('/js/min/rjqc-frontend-full.min.js', dirname(__FILE__)), array('jquery'));
        }
    }
}
