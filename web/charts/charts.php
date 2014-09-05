<section class="content">
    <div class="row">
        <div class="col-xs-12">
<?php

$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-users');
$box->title("Registrations");
$box->body("<div id='bar-chart' style='height: 150px;'></div>");
//$box->footer($foot);
echo $box->html();
?>
</div>
</div>
</section>

<!-- Main content -->
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <!-- interactive chart -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Interactive Area Chart</h3>
                    <div class="box-tools pull-right">
                        Real time
                        <div class="btn-group" id="realtime" data-toggle="btn-toggle">
                            <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
                            <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <div id="interactive" style="height: 150px;"></div>
                </div><!-- /.box-body-->
            </div><!-- /.box -->

        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
        <div class="col-md-6">
            <!-- Line chart -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Line Chart</h3>
                </div>
                <div class="box-body">
                    <div id="line-chart" style="height: 150px;"></div>
                </div><!-- /.box-body-->
            </div><!-- /.box -->

            <!-- Area chart -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Full Width Area Chart</h3>
                </div>
                <div class="box-body">
                    <div id="area-chart" style="height: 138px;" class="full-width-chart"></div>
                </div><!-- /.box-body-->
            </div><!-- /.box -->

        </div><!-- /.col -->

        <div class="col-md-6">
            <!-- Bar chart -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Bar Chart</h3>
                </div>
                <div class="box-body">
                    <div id="bar-chart" style="height: 100px;"></div>
                </div><!-- /.box-body-->
            </div><!-- /.box -->

            <!-- Donut chart -->
            <div class="box box-primary">
                <div class="box-header">
                    <i class="fa fa-bar-chart-o"></i>
                    <h3 class="box-title">Donut Chart</h3>
                </div>
                <div class="box-body">
                    <div id="donut-chart" style="height: 300px;"></div>
                </div><!-- /.box-body-->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->


</section><!-- /.content -->

<!-- FLOT CHARTS -->
<script src="../js/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="../js/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="../js/plugins/flot/jquery.flot.pie.min.js" type="text/javascript"></script>
<!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
<script src="../js/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>

<!-- Page script -->
<script src="barchart.js"></script>