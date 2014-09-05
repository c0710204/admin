// http://almsaeedstudio.com/AdminLTE/pages/charts/flot.html
$(function() {
    /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
        data: [["Jan", 10], ["Feb", 8], ["Mar", 40], ["Apr", 13], ["May", 17], ["Jun", 9], ["Jan2", 10], ["Feb2", 8], ["Mar2", 4], ["Apr3", 13], ["May2", 17], ["Jun33", 9]],
        color: "#3c8dbc"
    };

    $.plot("#bar-chart", [bar_data], {
        grid: {
            borderWidth: 1,
            borderColor: "#f3f3f3",
            tickColor: "#f3f3f3"
        },
        series: {
            bars: {
                show: true,
                barWidth: 0.9,
                align: "center"
            }
        },
        xaxis: {
            mode: "categories",
            tickLength: 0
        }
    });
    /* END BAR CHART */


});

