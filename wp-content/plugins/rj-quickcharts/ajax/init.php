<?php
if(!class_exists('RJ_Quickcharts_Ajax'))
{
    class RJ_Quickcharts_Ajax
    {

        public function __construct()
        {
            add_action('init', array(&$this, 'init'));
        }

        public function init()
        {
            add_action( 'admin_enqueue_scripts', 'enqueue_ajax' );
            function enqueue_ajax($hook) {
                wp_enqueue_script('ajax-script', plugins_url( '/ajax.js?v='.rand(), __FILE__ ), array('jquery'));

                wp_localize_script('ajax-script', 'ajax_object',
                        array(
                            'ajax_url' => admin_url('admin-ajax.php')
                            )
                        );
            }

            // Save Chart
            add_action('wp_ajax_save_rjqc', 'save_rjqc_callback');
            function save_rjqc_callback() {
                global $wpdb;
                global $table_name;

                $full_series = $_POST['series'];
                foreach ($full_series as $index => $serie) {
                    foreach ($serie as $i => $s) {
                        $newInt = floatval($s[1]);
                        $full_series[$index][$i][1] = $newInt;
                    }
                }

                $full_hot_series = $_POST['hotSeries'];
                foreach ($full_hot_series as $index => $serie) {
                    if ($index != 0 && $index != count($full_hot_series)-1) {
                        foreach ($serie as $i => $s) {
                            if ($i != 0 && $i != count($serie)-1) {
                                $newInt = floatval($s);
                                $full_hot_series[$index][$i] = $newInt;
                            }
                        }
                    }
                }

                $type           = $_POST['type'];
                $legend         = (int)$_POST['legend'];
                $title          = $_POST['title'];
                $sub_title      = $_POST['sub_title'];
                $tooltip_suffix = $_POST['tooltip_suffix'];
                $y_axis_title   = $_POST['y_axis_title'];
                $y_axis_cats    = json_encode($_POST['y_axis_cats']);
                $series         = json_encode($full_series);
                $hotSeries      = json_encode($full_hot_series);
                $opts           = json_encode($_POST['opts']);

                $rows = $wpdb->insert(
                                $table_name, array(
                                    'created' => current_time('mysql'),
                                    'type' => $type,
                                    'title' => $title,
                                    'subtitle' => $sub_title,
                                    'tooltipSuffix' => $tooltip_suffix,
                                    'xAxisCats' => $y_axis_cats,
                                    'yAxisTitleText' => $y_axis_title,
                                    'legendOn' => $legend,
                                    'series' => $series,
                                    'hotSeries' => $hotSeries,
                                    'opts' => $opts )
                                );

                $new_id = mysql_insert_id();

                echo '{"id": "'.$new_id.'"}';

                die;
            }

            // Duplicate Chart
            add_action('wp_ajax_duplicate_rjqc', 'duplicate_rjqc_callback');
            function duplicate_rjqc_callback() {
                global $wpdb;
                global $table_name;

                $id = $_POST['id'];

                $sql = "SELECT * FROM $table_name WHERE id = $id";
                $chart = $wpdb->get_results($sql);

                $id             = $chart[0]->id;
                $type           = $chart[0]->type;
                $title          = $chart[0]->title;
                $sub_title      = $chart[0]->subtitle;
                $tooltip_suffix = $chart[0]->tooltipSuffix;
                $y_axis_cats    = $chart[0]->xAxisCats;
                $y_axis_title   = $chart[0]->yAxisTitleText;
                $legend         = $chart[0]->legendOn;
                $series         = $chart[0]->series;
                $hotSeries      = $chart[0]->hotSeries;
                $opts           = $chart[0]->opts;

                $wpdb->insert(
                    $table_name, array(
                        'created' => current_time('mysql'),
                        'type' => $type,
                        'title' => $title,
                        'subtitle' => $subtitle,
                        'tooltipSuffix' => $tooltip_suffix,
                        'xAxisCats' => $y_axis_cats,
                        'yAxisTitleText' => $y_axis_title,
                        'legendOn' => $legend,
                        'series' => $series,
                        'hotSeries' => $hotSeries,
                        'opts' => $opts
                    )
                );

                echo '{"success":1,
                        "message":"Chart duplicated successfully.",
                        "id": "'.mysql_insert_id().'",
                        "created":"'.current_time("mysql").'",
                        "title":'.json_encode($title).',
                        "subtitle":'.json_encode($subtitle).',
                        "type":'.json_encode($type).',
                        "tooltipSuffix":'.json_encode($tooltip_suffix).',
                        "xAxisCats":'.json_encode($y_axis_cats).',
                        "yAxisTitleText":'.json_encode($y_axis_title).',
                        "legendOn":'.json_encode($legend).',
                        "series":'.json_encode($series).',
                        "hotSeries":'.json_encode($hotSeries).',
                        "opts":'.json_encode($opts).'
                    }';
                die;
            }

            // Update Chart
            add_action('wp_ajax_update_rjqc', 'update_rjqc_callback');
            function update_rjqc_callback() {
                global $wpdb;
                global $table_name;

                $id = $_POST['id'];

                $full_series = $_POST['series'];

                foreach ($full_series as $index => $serie) {
                    foreach ($serie as $i => $s) {
                        $newInt = floatval($s[1]);
                        $full_series[$index][$i][1] = $newInt;
                    }
                }

                $full_hot_series = $_POST['hotSeries'];
                foreach ($full_hot_series as $index => $serie) {
                    if ($index != 0 && $index != count($full_hot_series)-1) {
                        foreach ($serie as $i => $s) {
                            if ($i != 0 && $i != count($serie)-1) {
                                $newInt = floatval($s);
                                $full_hot_series[$index][$i] = $newInt;
                            }
                        }
                    }
                }

                $wpdb->update(
                    $table_name,
                    array(
                        'id'            => $id,
                        'created'       => current_time('mysql'),
                        'type'          => $_POST['type'],
                        'title'         => $_POST['title'],
                        'subtitle'      => $_POST['sub_title'],
                        'tooltipSuffix' => $_POST['tooltip_suffix'],
                        'yAxisTitleText'=> $_POST['y_axis_title'],
                        'xAxisCats'     => json_encode($_POST['y_axis_cats']),
                        'legendOn'      => (int)$_POST['legend'],
                        'series'        => json_encode($full_series),
                        'hotSeries'     => json_encode($full_hot_series),
                        'opts'          => json_encode($_POST['opts'])
                    ),
                    array('id'=>$id)
                );

                echo '{"success":1,"message":"Chart updated successfully."}';
                die;
            }

            // Delete Chart
            add_action('wp_ajax_delete_rjqc', 'delete_rjqc_callback');
            function delete_rjqc_callback() {
                global $wpdb;
                global $table_name;

                $id = $_POST['id'];

                $wpdb->query(
                    $wpdb->prepare(
                        "DELETE FROM $table_name
                        WHERE id = %d",
                        $id
                    )
                );

                echo '{"success":1,"message":"Chart deleted successfully."}';
                die;
            }
        }
    }
}
