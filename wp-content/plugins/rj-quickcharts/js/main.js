(function ($) {
    var $wpbody         = $('#wpbody'),
        handsontable    = $('#dataTable'),
        tooltipSuffx    = '',
        curChartType    = $('#chart-type select').val();

    rjqc = {
        insertShortcodeToPost: function() {
            $('.insert-chart-to-post').live('click', function() {
                var id  = $(this).data('id'),
                    win = window.dialogArguments
                            || opener || parent || top;

                win.send_to_editor('[show-rjqc id="'+id+'"]');

                return false;
            });
        },

        getColorArray: function() {
            var colors = [];
            $.each($('.chart-color'), function() {
                colors.push($(this).val());
            });
            return colors;
        },

        setUpHandsontable: function(data, settings) {
            if (!data) {
                var data = [
                    ['', 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    ['Tokyo', 7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
                    ['New York', -0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5],
                    ['Berlin', -0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0],
                    ['London', 3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
                ];
            }

            if (!settings) {
                var settings = {
                    minRows: 2,
                    minCols: 2,
                    startRows: 10,
                    startCols: 10,
                    minSpareRows: 1,
                    minSpareCols: 1
                }
            }

            var readOnlyCell = function (instance, td, row, col, prop, value, cellProperties) {
              Handsontable.TextCell.renderer.apply(this, arguments);
              $(td).css({
                background: '#e8e8e8'
              });
            };

            handsontable.handsontable({
                data: data,
                cells: function(r,c, prop) {
                    var cellProperties = {};
                    if (r === 0 && c === 0) {
                        cellProperties.readOnly = true;
                        cellProperties.type = {renderer: readOnlyCell};
                    }
                    return cellProperties;
                },
                onChange: function (changes, source) {
                    rjqc.buildOutQuickchartLive(jQuery('#chart-type select').val(), chart, chartOpts);
                }
            });

            handsontable.handsontable('updateSettings', settings);

            handsontable.handsontable('render');
        },

        getHandsontableData: function() {
            return handsontable.data('handsontable').getData();
        },

        loadingScreen: function() {
            $wpbody.before('<div id="rjqc-loading">' +
                            '<h1 style="top:' +
                            ($(document).scrollTop()+100)+'px">' +
                            'Working...</h1></div>');
        },

        buildOutQuickchartLive: function(type, chart, opts) {
            type = type || 'line';
            //rjqc.loadingScreen();

            var totRows = handsontable.handsontable('countRows'),
                totCols = handsontable.handsontable('countCols'),
                theData = handsontable.data('handsontable').getData();

            if (theData[0][0] === '' && theData[0][1] === '' || (theData[1][0] === '' && theData[1][1] === '')) {
                $('#rjqc-loading').remove();
                return;
            }

            setTimeout(function(){
                chart.destroy();

                var seriesArr = [];

                if (type === 'pie') {
                    var theNewData = [];
                    for (var i = 0; i < theData.length; i++) {
                        if (i !== 0 && i !== theData.length-1) {
                            theNewData.push([theData[i][0], parseFloat(theData[i][1])]);
                        }
                    }

                    theYData = [theNewData];
                } else {
                    // Get the xAxis Categories
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

                    var theYLabels = [],
                        theYData = [];

                    var buildYData = $.map(theNewData, function(item, i) {
                        theYLabels.push(item[0]);
                        $.each(item, function(x, xitem) {

                            if (x === 0) newArr = [];

                            if (x > 0 && x < theNewData[0].length-1) {
                                newArr.push([theXCats[x-1],parseFloat(xitem)]);
                            }

                            if (x === theNewData[0].length-1) theYData.push(newArr);
                        });
                    });

                    $.each(theYLabels, function(i, item) {
                        seriesArr.push({label:item});
                    });
                }

                rjqc.buildChart(opts, theYData, seriesArr);

                //$('#rjqc-loading').remove();
            }, 80);
        },

        buildChart: function(opts, data, series) {
            chartLegend     = (opts.chartLegend === 0) ? 0 : 1;
            chartTitle      = opts.chartTitle || 'Monthly Average Temperature';
            chartYAxis      = opts.chartYAxis || 'Temperature (°C)';
            chartFill       = opts.chartFill || false;
            chartType       = opts.chartType || 'line';
            chartColors     = opts.seriesColors || ['#40C0CB', '#AEE239', '#CC333F', '#EB6841', '#2A363B','#F9D423','#00DFFC','#FF847C','#F9F2E7','#E84A5F'];
            showHighlighter = (opts.showHighlighter === false) ? false : true;
            xAxis           = {
                                label: '',
                                renderer: jQuery.jqplot.CategoryAxisRenderer,
                                labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer,
                                tickOptions: {
                                    mark: false
                                },
                                labelOptions: {
                                    show: true,
                                    fontSize: '14px'
                                }
                            };
            legend          = {
                                margin: 0,
                                padding: 0,
                                background: 'transparent',
                                textColor: '#666',
                                fontFamily: "Arial, Verdana, Helvetica",
                                fontSize: '11px',
                                border: 'none',
                                show: true,
                                location: 'n',
                                showSwatch: true,
                                placement: 'outsideGrid',
                                renderer: jQuery.jqplot.EnhancedLegendRenderer,
                                rendererOptions: {
                                    numberRows: 1,
                                    disableIEFading: true
                                }
                            };

            switch (chartType) {
                case 'bar':
                    r = jQuery.jqplot.BarRenderer;
                    break;
                case 'pie':
                    r = jQuery.jqplot.PieRenderer;
                    xAxis = {};
                    legend = {
                                margin: 0,
                                padding: 0,
                                background: 'transparent',
                                textColor: '#666',
                                fontFamily: "Arial, Verdana, Helvetica",
                                fontSize: '11px',
                                border: 'none',
                                show: true,
                                location: 'n',
                                showSwatch: true,
                                placement: 'outsideGrid',
                                renderer: jQuery.jqplot.EnhancedLegendRenderer,
                                rendererOptions: {
                                    numberRows: 1,
                                    disableIEFading: true
                                }
                            };
                    break;
                case 'donut':
                    r = jQuery.jqplot.DonutRenderer;
                    break;
                default:
                    r = jQuery.jqplot.LineRenderer;
                    break;
            }
            chartLegend = (chartLegend === 1) ? true : false;

            chart = $.jqplot('rjqc-chart', data, {
                seriesDefaults:{
                    renderer: r,
                    fill: chartFill,
                    shadow: false,
                    rendererOptions: {
                        showDataLabels: true,
                        textColor: '#white'
                    }
                },
                title: {
                    text: chartTitle,
                    fontSize: '20px',
                    fontFamily: 'Arial',
                    textColor: '#666'
                },
                grid: {
                    drawGridlines: true,
                    background: 'white',
                    drawBorder: false,
                    backgroundColor: 'white',
                    borderWidth: 0,
                    gridLineColor: '#ccc',
                    gridLineWidth: 1.01,
                    shadow: false
                },
                highlighter: {
                    //show: showHighlighter,
                    show: true,
                    formatString:'%s',
                    tooltipLocation:'n',
                    useAxesFormatters:false,
                    tooltipAxes: 'y',
                    showMarker: false,
                    showTooltip: true,
                    fadeTooltip: false,
                    tooltipFadeSpeed: '1',
                    bringSeriesToFront: false
                },
                legend: legend,
                cursor: {
                    show: false
                },
                series: series,
                seriesColors: chartColors,
                axesDefaults: {
                    tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
                    tickOptions: {
                        angle: 0,
                        fontSize: '11px',
                        fontWeight: 'normal',
                        _styles: {
                            'padding': '4px 0px 8px',
                            'font-weight': 'light'
                        }
                    }
                },
                axesStyles: {
                    borderWidth: 0,
                    label: {
                       fontFamily: 'Arial',
                       textColor: '#666'
                    }
                },
                axes: {
                    xaxis: xAxis,
                    yaxis:{
                        renderer: jQuery.jqplot.LogAxisRenderer,
                        tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer,
                        labelRenderer: jQuery.jqplot.CanvasAxisLabelRenderer,
                        label: chartYAxis,
                        labelOptions: {
                            show: true,
                            fontSize: '14px'
                        },
                        tickOptions: {
                            mark: false,
                            labelPosition: 'middle',
                            angle: -90
                        }
                    }
                }
            });

            chart.replot();

            // Handle legend hiding on the client
            if(chartLegend === false) {
                jQuery('.jqplot-table-legend').remove();
            } else {
                jQuery('.jqplot-table-legend').show();
            }
        },

        init: function() {
            this.insertShortcodeToPost();
        }
    };

    rjqc.init();

})(jQuery);
