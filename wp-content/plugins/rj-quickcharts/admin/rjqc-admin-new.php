<?php
$type           = '';
$title          = '';
$sub_title      = '';
$tooltip_suffix = '';
$y_axis_title   = '';
$chart_height   = '300';
$series_colors = array('#40C0CB', '#AEE239', '#CC333F', '#EB6841', '#2A363B','#F9D423','#00DFFC','#FF847C','#F9F2E7','#E84A5F');

$id = $_GET['id'];
if ($id) {
    $sql = "SELECT * FROM $table_name WHERE id=$id";
    $chart = $wpdb->get_results($sql);

    $id             = $chart[0]->id;
    $created        = $chart[0]->created;
    $type           = $chart[0]->type;
    $title          = $chart[0]->title;
    $sub_title      = $chart[0]->subtitle;
    $tooltip_suffix = $chart[0]->tooltipSuffix;
    $y_axis_cats    = $chart[0]->xAxisCats;
    $y_axis_title   = $chart[0]->yAxisTitleText;
    $legend         = $chart[0]->legendOn;
    $series         = $chart[0]->series;
    $hotSeries      = $chart[0]->hotSeries;
    $opts           = json_decode($chart[0]->opts);
    $chart_height   = $opts->height;
    if ($opts->seriesColors) {
        $series_colors = $opts->seriesColors;
    }

    echo '<input id="rjqc-chart-id" type="hidden" value="'.$id.'" />';

    if ($_GET['message']) {
        echo '<div class="updated" style="margin: 15px 20px 0 0;"><p>Chart saved successfully. Now you can go to your Page or Post and choose <b>"Add Media" -&gt; "Insert Quickchart"</b>.</p></div>';
    }
}

echo '<div class="rjqc-area">';
    echo '
    <div class="postbox">
        <h3 class="hndle"><span>Step 1: Chart Info</span></h3>
        <div class="inside">
            <form class="save-rjqc">
                <label id="chart-type"><span>Type of Chart</span><br />
                    <select>
                        <option value="line">Line</option>
                        <option value="bar">Bar</option>
                        <option value="pie">Pie</option>
                    </select>
                </label>
                <label id="chart-legend"><span>Show Legend?</span><br />
                    <select>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </label>
                <div class="cf"></div>
                <br />
                <label id="chart-title"><span>Chart Title</span><br />
                    <input type="text" placeholder="Monthly Average Temperature" value="'.$title.'" />
                </label>
                <!--<label id="chart-subtitle"><span>Chart Sub Title</span><br />
                    <input type="text" placeholder="Source: WorldClimate.com" value="'.$sub_title.'" />
                </label>-->
                <label id="chart-yaxis-title"><span>Y Axis Title</span><br />
                    <input type="text" placeholder="Temperature (&deg;C)" value="'.$y_axis_title.'" />
                </label>
                <label id="chart-tooltip-suffix"><span>Tooltip Suffix</span><br />
                    <input type="text" placeholder="&deg;C" value="'.$tooltip_suffix.'" />
                </label>
                <label id="chart-height"><span>Chart Height (leave empty for default)</span><br />
                    <input type="text" placeholder="300" value="'.$chart_height.'" />px
                </label>
                <div class="cf"></div>
                <p id="change-chart-colors">Change Chart Colors?</p>
                <div id="change-chart-colors-area">
                    <label>1. <input type="text" class="chart-color" id="chart-color-1" data-color="1" value="'.$series_colors[0].'" /></label>
                    <label>2. <input type="text" class="chart-color" id="chart-color-2" data-color="2" value="'.$series_colors[1].'" /></label>
                    <label>3. <input type="text" class="chart-color" id="chart-color-3" data-color="3" value="'.$series_colors[2].'" /></label>
                    <label>4. <input type="text" class="chart-color" id="chart-color-4" data-color="4" value="'.$series_colors[3].'" /></label>
                    <label>5. <input type="text" class="chart-color" id="chart-color-5" data-color="5" value="'.$series_colors[4].'" /></label>
                    <label>6. <input type="text" class="chart-color" id="chart-color-6" data-color="6" value="'.$series_colors[5].'" /></label>
                    <label>7. <input type="text" class="chart-color" id="chart-color-7" data-color="7" value="'.$series_colors[6].'" /></label>
                    <label>8. <input type="text" class="chart-color" id="chart-color-8" data-color="8" value="'.$series_colors[7].'" /></label>
                    <label>9. <input type="text" class="chart-color" id="chart-color-9" data-color="9" value="'.$series_colors[8].'" /></label>
                    <label>10. <input type="text" class="chart-color" id="chart-color-10" data-color="10" value="'.$series_colors[9].'" /></label>
                </div>
            </form>
            <div class="cf"></div>
        </div>
    </div>
    ';

    echo '
    <div class="postbox">
        <h3 class="hndle">
            <span>Step 2: Add Chart Data</span>
            <span id="clear-handsontable" class="clear-handsontable-x">(clear data x)</span>
        </h3>
        <div class="inside">
            <div id="dataTable" style="height:200px;overflow:scroll;margin:2px 0 10px;""></div>
            <div class="cf"></div>
            <!--<input type="submit" name="" class="get-handsontable-data rjqc-button button" value="Test Data Below">
            <div class="cf"></div>-->
        </div>
    </div>
    ';

    echo '
    <div class="postbox" id="rjqc-chart-resize">
        <h3 class="hndle"><span>Step 3: Preview</span></h3>
        <div class="inside">
            <div>
                <div id="rjqc-chart" style="height:'.$chart_height.'px;"></div>
                <div class="cf"></div>
            </div>
        </div>
    </div>
    <div id="rjqc-chart-resize-info"></div>
    ';

    echo '
    <div class="postbox">
        <h3 class="hndle"><span>Step 4: Finish</span></h3>
        <div class="inside">
            <div class="get-shortcode rjqc-button button">Save Chart</div>
            <div class="save-message"></div>
            <div id="screenshot" class="rjqc-button button">Screenshot Chart</div>
            <div class="cf"></div>
        </div>
    </div>
    ';

echo '</div>';

echo "<link rel='stylesheet' href='".plugins_url('/main.css?v='.rand(), dirname(__FILE__))."' type='text/css' media='all' />";
echo "<link rel='stylesheet' href='".plugins_url('/handsontable/dist/jquery.handsontable.full.css', dirname(__FILE__))."' type='text/css' media='all' />";
echo "<link rel='stylesheet' href='".plugins_url('/css/jquery.jqplot.min.css', dirname(__FILE__))."' type='text/css' media='all' />";
echo "<link rel='stylesheet' href='".plugins_url('/css/spectrum.css', dirname(__FILE__))."' type='text/css' media='all' />";
echo '<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="'.plugins_url("/js/excanvas.min.js", dirname(__FILE__)).'"></script><![endif]-->';
echo "<script type='text/javascript' src='".plugins_url('/js/min/rjqc-frontend-full.min.js', dirname(__FILE__))."'></script>";
echo "<link rel='stylesheet' href='http://code.jquery.com/ui/1.8.20/themes/base/jquery-ui.css' type='text/css' media='all' />";

echo "<script src='//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js'></script>";
echo "<script type='text/javascript' src='".plugins_url('/handsontable/dist/jquery.handsontable.js', dirname(__FILE__))."'></script>";
echo "<script type='text/javascript' src='".plugins_url('/js/spectrum.js', dirname(__FILE__))."'></script>";
echo "<script type='text/javascript' src='".plugins_url('/js/main.js', dirname(__FILE__))."'></script>";
?>

<script>
chartOpts = {},
theYData = [],
series = [],
handsontable = jQuery('#dataTable');
</script>

<?php if (!$_GET['id']) { ?>
<script>
(function ($) {

    tooltipSuffix = '',
    curChartType = 'line';

    theYData = [
        [
            ['Jan', 7.0], ['Feb', 6.9], ['Mar', 9.5], ['Apr', 14.5],
            ['May', 18.2], ['Jun', 21.5], ['Jul', 25.2], ['Aug', 26.5],
            ['Sep', 23.3], ['Oct', 18.3], ['Nov', 13.9], ['Dec', 9.6]
        ],
        [
            ['Jan', -0.2], ['Feb', 0.8], ['Mar', 5.7], ['Apr', 11.3],
            ['May', 17.0], ['Jun', 22.0], ['Jul', 24.8], ['Aug', 24.1],
            ['Sep', 20.1], ['Oct', 14.1], ['Nov', 8.6], ['Dec', 2.5]
        ],
        [
            ['Jan', -0.9], ['Feb', 0.6], ['Mar', 3.5], ['Apr', 8.4],
            ['May', 13.5], ['Jun', 17.0], ['Jul', 18.6], ['Aug', 17.9],
            ['Sep', 14.3], ['Oct', 9.0], ['Nov', 3.9], ['Dec', 1.0]
        ],
        [
            ['Jan', 3.9], ['Feb', 4.2], ['Mar', 5.7], ['Apr', 8.5],
            ['May', 11.9], ['Jun', 15.2], ['Jul', 17.0], ['Aug', 16.6],
            ['Sep', 14.2], ['Oct', 10.3], ['Nov', 6.6], ['Dec', 4.8]
        ]
    ];

    series = [
        {label: 'Tokyo'},
        {label: 'New York'},
        {label: 'Berlin'},
        {label: 'London'}
    ];

    // Build out initial chart
    rjqc.buildChart(chartOpts, theYData, series);

    // Set up handsontable
    rjqc.setUpHandsontable();
})(jQuery);
</script>
<?php } ?>

<?php if ($_GET['id']) { ?>
<script>
(function ($) {
    <?php if ($_GET['message']) { ?>
    var path = window.location.pathname + window.location.search;
    path = path.slice(0,-13);
    window.history.pushState("", "", path);
    setTimeout(function() {
        jQuery('.updated').fadeOut();
    }, 5000);
    <?php } ?>

    tooltipSuffix = '<?php echo $tooltip_suffix ?>',
    curChartType = '<?php echo $type ?>';

    jQuery('#chart-type select').val('<?php echo $type ?>');
    jQuery('#chart-legend select').val(<?php echo $legend ?>);

    chartOpts.chartLegend = <?php echo $legend ?>;
    chartOpts.chartTitle = '<?php echo $title ?>';
    chartOpts.chartYAxis = '<?php echo $y_axis_title ?>';
    chartOpts.chartType = '<?php echo $type ?>';
    chartOpts.seriesColors = <?php echo json_encode($series_colors) ?>;

    var hotSeries = <?php echo $hotSeries ?>;

    jQuery('#dataTable').handsontable({data: hotSeries});

    var totRows = handsontable.handsontable('countRows'),
        totCols = handsontable.handsontable('countCols'),
        theData = handsontable.data('handsontable').getData();

    var theXCats = $.extend(true, [], theData[0]);
        theXCats = theXCats.splice(1,theXCats.length-2);

    var theNewData = [];

    var buildNewData = $.map(theData, function(item, i) {
        if (i > 0 && i < theData.length-1) {
            theNewData.push(item);
        }
    });

    var theYCats = [];

    var buildYCats = $.map(theNewData, function(item, i) {
        theYCats.push(item[0]);
    });

    var theYLabels = [];

    var buildYData = $.map(theNewData, function(item, i) {
        theYLabels.push(item[0]);
        $.each(item, function(x, xitem) {
            if (chartOpts.chartType === 'pie') {
            } else {
                if (x === 0) newArr = [];

                if (x > 0 && x < theNewData[0].length-1) {
                    newArr.push([theXCats[x-1],xitem]);
                }

                if (x === theNewData[0].length-1) theYData.push(newArr);
            }
        });
    });

    $.each(theYLabels, function(i, item) {
        series.push({label:item});
    });

    // Pie Chart?
    if (chartOpts.chartType === 'pie') {
        var theNewData = [];
        for (var i = 0; i < theData.length; i++) {
            if (i !== 0 && i !== theData.length-1) {
                theNewData.push([theData[i][0], parseFloat(theData[i][1])]);
            }
        }
        theYData = [theNewData];
    }

    rjqc.buildChart(chartOpts, theYData, series);

    rjqc.setUpHandsontable(hotSeries);

    // Bind tooltip handler
    jQuery("#rjqc-chart").bind('jqplotDataMouseOver', function (ev, seriesIndex, pointIndex, data) {
        jQuery(".jqplot-highlighter-tooltip").html('' + data[1] + tooltipSuffix);
    });

    jQuery('.get-shortcode').text('Save Chart')
                            .removeClass('get-shortcode')
                            .addClass('rjqc-save-chart');

})(jQuery);
</script>
<?php } ?>

<script>
(function ($) {
    //
    // Event Handlers
    //

    // Build QuickChart from Handsontable
    jQuery('.get-handsontable-data').click(function() {
        rjqc.buildOutQuickchartLive(jQuery('#chart-type select').val(), chart, chartOpts);
    });

    // Clear Handsontable Data
    jQuery('#clear-handsontable').click(function() {
        handsontable.handsontable('clear');
    });

    // Change the type of chart
    jQuery('#chart-type select').change(function() {
        var val = this.value;
        chartOpts.chartType = val;

        series = [];
        if (val === 'pie') {
            chartOpts.showHighlighter = false;

            var hotData = [
                ['', 'Data'],
                ['Android', '74.4'],
                ['iOS', '18.2'],
                ['BlackBerry', '3.0'],
                ['Microsoft', '2.9'],
                ['Bada', '0.7'],
                ['Symbian', '0.6']
            ];

            var hotSettings = {
                minRows: 2,
                maxCols: 2,
                minSpareRows: 1,
                minSpareCols: 0,
                startRows: 10,
                startCols: 2
            };

            rjqc.setUpHandsontable(hotData, hotSettings);
        } else {
            if (curChartType === 'pie') {
                chartOpts.showHighlighter = true;

                var hotData = [
                    ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    ['Tokyo', 7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                    ['New York', -0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5],
                    ['Berlin', -0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0],
                    ['London', 3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                ];

                var hotSettings = {
                    minRows: 2,
                    minCols: 2,
                    startRows: 10,
                    startCols: 10,
                    minSpareRows: 1,
                    minSpareCols: 1
                }

                rjqc.setUpHandsontable(hotData, hotSettings);
            } else {
                var ser = handsontable.handsontable('getDataAtCol', 0);
                for (var i = 0; i < ser.length; i++) {
                    if (ser[i] !== '') {
                        series.push({label:ser[i]});
                    }
                }
                rjqc.buildChart(chartOpts, theYData, series);
            }
        }

        curChartType = val;
    });

    // Hide/Show the legend
    jQuery('#chart-legend select').change(function() {
        if (jQuery(this).val() === '0') {
            jQuery('.jqplot-table-legend').hide();
        } else {
            jQuery('.jqplot-table-legend').show();
        }

        chartOpts.chartLegend = jQuery(this).val();
    });

    // Change the title
    jQuery('#chart-title input').keyup(function() {
        chart.title.text = jQuery(this).val();
        chart.replot();

        chartOpts.chartTitle = jQuery(this).val();
    });

    // Change Y Axis
    jQuery('#chart-yaxis-title input').keyup(function() {
        chart.axes.yaxis.labelOptions.label = jQuery(this).val();
        chart.replot();

        chartOpts.chartYAxis = jQuery(this).val();
    });

    // Change tooltip suffix
    jQuery('#chart-tooltip-suffix input').keyup(function() {
        tooltipSuffix = jQuery(this).val();
    });

    // Bind tooltip handler
    jQuery("#rjqc-chart").bind('jqplotDataMouseOver', function (ev, seriesIndex, pointIndex, data) {
        jQuery(".jqplot-highlighter-tooltip").html('' + data[1] + tooltipSuffix);
    });

    // Change the chart Height
    jQuery('#chart-height input').keyup(function() {
        chartHeight = jQuery(this).val();
        if (chartHeight === '') {
            chartHeight = '300'
        }

        jQuery('#rjqc-chart').height(chartHeight+'px');

        $('#rjqc-chart-resize').resizable({
            minHeight: parseInt(chartHeight)+60,
            maxHeight: parseInt(chartHeight)+60,
            minWidth: 400,
        });

        chart.replot();
    });

    <?php if ($_GET['id']) { ?>
    if (<?php echo $legend ?> === 0) {
        setTimeout(function(){
            jQuery('.jqplot-table-legend').remove();
        }, 150);
    }
    <?php } ?>

    //
    // Color Pallete
    //
    var spectrumObj = function(theColor, theClass) {
        return {
            color: theColor,
            flat: false,
            showInput: true,
            showAlpha: false,
            clickoutFiresChange: true,
            cancelText: "Cancel",
            chooseText: "Select",
            className: "choose-color-"+theClass,
            preferredFormat: "hex",
            change: function(color) {
                //color.toHexString();
                var colors = rjqc.getColorArray();
                chartOpts.seriesColors = colors;
                rjqc.buildChart(chartOpts, theYData, series);
            }
        }
    };
    jQuery.each(jQuery(".chart-color"), function(i, item) {
        jQuery("#"+item.id).spectrum(spectrumObj(jQuery(item).val(), jQuery(item).data('color')));
    });
    jQuery('#change-chart-colors').click(function() {
        var area = document.getElementById('change-chart-colors-area');
        if (jQuery(area).is(':hidden')) {
            area.style.display = 'block';
        } else {
            area.style.display = 'none';
        }
    });

    // Handle ability to resize chart
    var handleResizer = function() {
        jQuery('#rjqc-chart-resize-info')
            .css({
                'padding':'5px 0 0 5px',
                'color':'#e42217'
            })
            .text('* Please note that resizing the chart is only for \
                    taking screenshots and will not reflect the acutal \
                    size of the chart in your posts.');
        rjqc.buildOutQuickchartLive(jQuery('#chart-type select').val(), chart, chartOpts);
    }
    $('#rjqc-chart-resize').resizable({
        minHeight: parseInt(<?php echo $chart_height ?>)+60,
        maxHeight: parseInt(<?php echo $chart_height ?>)+60,
        minWidth: 400,
    });
    $('#rjqc-chart-resize').resize(handleResizer);

    // Handle screenshot button
    $('#screenshot').click(function() {
        jQuery('#rjqc-chart-resize-info')
            .css({
                'padding':'5px 0 0 5px',
                'color':'#e42217'
            })
            .text('* Change the size of the chart for your screenshot \
                    with the draggable handle above.');
        var imgData = $('#rjqc-chart').jqplotToImageStr({});
        var imgElem = $('<img/>').attr('src',imgData);
        window.open(imgData);
    });
})(jQuery);
</script>
