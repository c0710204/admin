<?php
// Home :: New Users

$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-users');
$box->title("Registrations");
$box->body("");
//$box->footer($foot);
echo $box->html();
?>
<div id='bar-chart' style='height: 150px;'></div>

<script>
    var bar_data = {
        data: [["Janaa", 10], ["Febe", 8], ["Mar", 140], ["Apr", 13], ["May", 17]],
        color: "#3c8dbc"
    };

$(function(){
    console.log('ready');

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
    
});
</script>