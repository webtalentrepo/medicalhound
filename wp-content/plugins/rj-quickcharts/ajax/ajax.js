jQuery(document).ready(function($) {
    var handsontable    = $('#dataTable'),
        $wpbody         = $('#wpbody');

    var loadingScreen = function() {
        $wpbody.before('<div id="rjqc-loading">' +
                        '<h1 style="top:' +
                        ($(document).scrollTop()+100) +
                        'px">Working...</h1></div>');
    };

    var getDataForChart = function(action) {

        var totRows = handsontable.handsontable('countRows'),
            totCols = handsontable.handsontable('countCols'),
            theData = handsontable.data('handsontable').getData();

        var type = $('#chart-type option:selected').val();

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

        if  (type === 'pie') {
            var theNewData = [];
            for (var i = 0; i < theData.length; i++) {
                if (i !== 0 && i !== theData.length-1) {
                    theNewData.push([theData[i][0], parseFloat(theData[i][1])]);
                }
            }

            theYData = [theNewData];
        } else {
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

            seriesArr = [];
            $.each(theYLabels, function(i, item) {
                seriesArr.push({label:item});
            });
        }

        var colors = [];
        $.each($('.chart-color'), function() {
            colors.push($(this).val());
        });

        // Serialize all the variables
        var legend          = $('#chart-legend option:selected').val(),
            title           = $('#chart-title input').val(),
            tooltip_suffix  = $('#chart-tooltip-suffix input').val(),
            y_axis_title    = $('#chart-yaxis-title input').val(),
            height          = $('#chart-height input').val(),
            y_axis_cats     = theYCats,
            series          = theYData,
            hotSeries       = theData,
            seriesColors    = colors;

        if (height === '') {
            height = 300;
        }

        var data = {
            action: action,
            type: type,
            legend: legend,
            title: title,
            tooltip_suffix: tooltip_suffix,
            y_axis_title: y_axis_title,
            y_axis_cats: y_axis_cats,
            series: series,
            hotSeries: theData,
            opts: {
                height: height,
                seriesColors: seriesColors
            }
        };

        return data;
    };

    $('.get-shortcode').click(function() {
        loadingScreen();

        setTimeout(function(){
            var data = getDataForChart('save_rjqc');

            $.ajax(ajax_object.ajax_url, {
                type: "POST",
                data: data,
                cache: false,
                success: function (response) {
                    var res = $.parseJSON(response);

                    window.location.href = location.href + '&id=' + res.id + '&message=true';
                    $('.save-message').html('Chart Saved!').delay(3000).queue(function() {
                        $(this).html('');
                    });
                },
                error: function (error) {
                    if (typeof console === "object") {
                        console.log(error);
                    }
                },
                complete: function () {
                    $('#rjqc-loading').remove();
                }
            });

        }, 100);
    });

    $('.rjqc-save-chart').live('click', function() {
        loadingScreen();

        var id = $('#rjqc-chart-id').val();

        setTimeout(function(){
            var data = getDataForChart('update_rjqc');

            data.id = id;

            $.ajax(ajax_object.ajax_url, {
                type: "POST",
                data: data,
                cache: false,
                success: function (response) {
                    $('.save-message').html('Chart Saved!').stop().delay(4000).queue(function() {
                        $(this).html('');
                    });
                },
                error: function (error) {
                    if (typeof console === "object") {
                        console.log(error);
                    }
                },
                complete: function () {
                    $('#rjqc-loading').remove();
                }
            });

        }, 100);
    });

    $('.delete-chart').live('click', function() {
        var id  = $(this).data('id'),
            t   = $(this).parents('tr');

        var data = {
            action: 'delete_rjqc',
            id: id
        };

        $.ajax(ajax_object.ajax_url, {
            type: "POST",
            data: data,
            cache: false,
            success: function (response) {
                $(t).fadeOut();
            },
            error: function (error) {
                if (typeof console === "object") {
                    console.log(error);
                }
            },
            complete: function () {
            }
        });
    });

    $('.duplicate-chart').live('click', function() {
        var id      = $(this).data('id'),
            t       = $(this).parents('tr');

        var data = {
            action: 'duplicate_rjqc',
            id: id
        };

        $.ajax(ajax_object.ajax_url, {
            type: "POST",
            data: data,
            cache: false,
            success: function (response) {
                var res = $.parseJSON(response),
                    d = new Date(res.created),
                    day = d.getDate().length === 1 ? d.getDate() : '0'+d.getDate();
                    newId = res.id,
                    monthNames = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];

                var newRow =
                '<tr class="author-self status-inherit new-row" valign="top">'+
                    '<td class="column-id">'+newId+'</td>'+
                    '<td class="column-title">'+
                        '<strong>'+
                            '<a class="row-title" href="admin.php?page=rj-quickcharts/admin/rjqc-admin-new.php&amp;id='+newId+'" title="Edit">'+res.title+'</a>'+
                        '</strong>'+
                        '<div class="row-actions">'+
                            '<span class="edit">'+
                                '<a title="Edit this chart" href="admin.php?page=rj-quickcharts/admin/rjqc-admin-new.php&amp;id='+newId+'">Edit</a> | '+
                            '</span>'+
                            '<span class="duplicate">'+
                                '<a title="Duplicate this chart" class="duplicate-chart" data-id="'+newId+'">Duplicate</a> | '+
                            '</span>'+
                            '<span class="delete">'+
                                '<a title="Delete" class="delete-chart" data-id="'+newId+'">Delete</a>'+
                            '</span>'+
                        '</div>'+
                    '</td>'+
                    '<td class="column-subtitle">'+
                        res.yAxisTitleText+
                    '</td>'+
                    '<td class="column-type" style="text-transform: capitalize;">'+
                        res.type+
                    '</td>'+
                    '<td class="column-created">'+
                        monthNames[d.getMonth()] + ' ' +
                        day + ', ' +
                        d.getFullYear()+
                    '</td>'+
                '</tr>';

                $(t).before(newRow);

                $('.new-row').animate({backgroundColor: '#fff'}, 800);
            },
            error: function (error) {
                if (typeof console === "object") {
                    console.log(error);
                }
            },
            complete: function () {
            }
        });
    });
});
