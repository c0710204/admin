<?php
//admin :: registration stats
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Users");
echo $admin->printPrivate();

$sql="SELECT COUNT(*) as n, date(date_joined) as `date` FROM edxapp.auth_user GROUP BY date(date_joined);";
$q=$admin->db()->query($sql) or die($admin->db()->errorInfo()[2]);
//$count=$q->fetchColumn();
$DAR=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $DAT[]=$r;
}
//echo json_encode($DAT);
?>

<link href="./template.css" rel="stylesheet">

<section class="content-header">
    <h1><i class="fa fa-users"></i> User registrations <small>With D3js</small></h1>
</section>

<!-- Main content -->
<section class="content">


<div class="row">
<section class="col-lg-12 connectedSortable">
    <!-- Filter -->
    <?php
    $box = new Admin\SolidBox;
    $box->icon("fa fa-search");
    $box->type("primary");
    $box->title("Filter");

    $body=[];
    //Dates
    $body[]='<div class=row>';
        
    // date range
    $body[]='<div class="col-lg-3">';
    $body[]='<div class="form-group">';
    $body[]='<label>Date Range</label>';
    $body[]='<input type="text" class="form-control" id="dateto" value="'.date("Y-m-d", time()-86400*30).' - '.date("Y-m-d").'">';
    $body[]='</div>';
    $body[]='</div>';

    //daterangepicker
    $body[]='<div class="col-lg-2">';
    $body[]='<div class="form-group">';
        $body[]='<label>Picker</label>';
        $body[]='<div class="input-group">';
            $body[]='<button class="btn btn-default pull-right" id="daterange-btn">';
                $body[]='<i class="fa fa-calendar"></i> Date range picker';
                $body[]='<i class="fa fa-caret-down"></i>';
            $body[]='</button>';
        $body[]='</div>';
    $body[]='</div>';
    $body[]='</div>';

    $body[]='</div>';

    $box->body($body);
    echo $box->html();
    ?>
</section>
</div>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-12 connectedSortable">
        <?php
        $box = new Admin\SolidBox;
        $box->id("boxgraph");
        $box->icon("fa fa-bar-chart-o");
        $box->title("Registrations");
        $box->body("<div id='chart'></div>");
        $box->loading(true);
        echo $box->html();
        ?>
        <div id='more'></div>
    </section>

</div>



<script src='d3template.js'></script>
<script>
$(function(){
    //$('#datefrom').datepicker();
    /*
    $('#dateto').daterangepicker({},function(start,end){
        //console.log('ok',start,end);
        $('#dateto').val(start.format('YYYY-MM-DD')+' - '+end.format('YYYY-MM-DD'));
        getData();
    });
    */
   
    //Date range as a button
    $('#daterange-btn').daterangepicker(
        {
            ranges: {
                'Last 7 Days': [moment().subtract('days', 6), moment()],
                'Last 30 Days': [moment().subtract('days', 29), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
            },
            startDate: moment().subtract('days', 29),
            endDate: moment()
        },
        function(start, end) {
            //console.log('check:',start,end);
            //$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            //$('#datefrom').val(start.format('YYYY-DD-MM'));
            $('#dateto').val(start.format('YYYY-MM-DD')+' - '+end.format('YYYY-MM-DD'));
            getData();
        }
    );
});
</script>
