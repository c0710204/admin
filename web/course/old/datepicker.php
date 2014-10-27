<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Course");

$edxapp = new EdxApp("../config.json");


echo $admin->printPrivate();

//06/27/2014 12:00 AM
$d=date("d/m/y H:i");
echo "<li>$d - $d<br />";
?>

<section class="content-header">
    <h1><i class='fa fa-book'></i> Datepicker</h1>
</section>

<!-- Main content -->
<section class="content">



<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title">Date picker</h3>
    </div>
    <div class="box-body">
        <!-- Date range -->
        <div class="form-group">
            <label>Date range:</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="reservation">
            </div><!-- /.input group -->
        </div><!-- /.form group -->

        <!-- Date and time range -->
        <div class="form-group">
            <label>Date and time range:</label>
            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-clock-o"></i>
                </div>
                <input type="text" class="form-control pull-right" id="reservationtime">
            </div><!-- /.input group -->
        </div><!-- /.form group -->

        <!-- Date and time range -->
        <div class="form-group">
            <label>Date range button:</label>
            <div class="input-group">
                <button class="btn btn-default pull-right" id="daterange-btn">
                    <i class="fa fa-calendar"></i> Date range picker
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
        </div><!-- /.form group -->

    </div><!-- /.box-body -->
</div>

<!-- Page script -->
<script type="text/javascript">
$(function() {

    //Datemask dd/mm/yyyy
    //$("#datemask").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    //$("#datemask2").inputmask("mm/dd/yyyy", {"placeholder": "mm/dd/yyyy"});
    //Money Euro
    //$("[data-mask]").inputmask();

    //Date range picker
    $('#reservation').daterangepicker();
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY hh:mm'});

    //Date range as a button
    /*
    $('#daterange-btn').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
                    'Last 7 Days': [moment().subtract('days', 6), moment()],
                    'Last 30 Days': [moment().subtract('days', 29), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
                },
                startDate: moment().subtract('days', 29),
                endDate: moment()
            },
    function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    );
    */

    //Timepicker
    $(".timepicker").timepicker({
        showInputs: false
    });
});
</script>