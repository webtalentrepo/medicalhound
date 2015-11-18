<?php
wp_enqueue_style('rjqc-styles', plugins_url('/rj-quickcharts/main.css'));
wp_enqueue_script('jquery-effects-core');

global $wpdb;
global $table_name;

$sql = "SELECT * FROM $table_name ORDER BY id DESC";
$charts = $wpdb->get_results($sql);

$chart_list = '';

$chart_list .= '
<div id="wpbody-content" class="rjqc-admin" aria-label="Main content" tabindex="0">
    <div class="wrap">
        <div id="icon-themes" class="icon32" style="float:left; margin:15px 7px 0 0; background-image: url(images/icons32-2x.png?ver=20121105);"><br></div>
        <h2>
            Edit Charts <a class="button add-new-h2" href="admin.php?page=rj-quickcharts/admin/rjqc-admin-new.php">Add New</a>
        </h2><br />
        <table class="widefat fixed" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col" id="id" class="manage-column" width="50">Id</th>
                    <th scope="col" id="title" class="manage-column column-title" width="300">Title</th>
                    <th scope="col" id="subtitle" class="manage-column column-subtitle" style="">Y Axis Title</th>
                    <th scope="col" id="type" class="manage-column column-type" style="">Type</th>
                    <th scope="col" id="created" class="manage-column column-created" style="">Created</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th scope="col" id="id" class="manage-column" width="50">Id</th>
                    <th scope="col" id="title" class="manage-column column-title" width="300">Title</th>
                    <th scope="col" id="subtitle" class="manage-column column-subtitle" style="">Y Axis Title</th>
                    <th scope="col" id="type" class="manage-column column-type" style="">Type</th>
                    <th scope="col" id="created" class="manage-column column-created" style="">Created</th>
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
                                <a class="row-title" href="admin.php?page=rj-quickcharts/admin/rjqc-admin-new.php&amp;id='.$chart->id.'" title="Edit">'.$chart->title.'</a>
                            </strong>
                            <div class="row-actions">
                                <span class="edit">
                                    <a title="Edit this chart" href="admin.php?page=rj-quickcharts/admin/rjqc-admin-new.php&amp;id='.$chart->id.'">Edit</a> |
                                </span>
                                <span class="duplicate">
                                    <a title="Duplicate this chart" class="duplicate-chart" data-id="'.$chart->id.'">Duplicate</a> |
                                </span>
                                <span class="delete">
                                    <a title="Delete" class="delete-chart" data-id="'.$chart->id.'">Delete</a>
                                </span>
                            </div>
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
