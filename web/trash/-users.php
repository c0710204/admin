<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../vendor/autoload.php";

use Admin\AdminLte;
use Admin\UserDjango;

$admin = new AdminLte("config.json");

echo $admin->printPrivate();
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
            <small>Complete list of Django Users</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- top row -->
        <div class="row">
            <div class="col-xs-12 connectedSortable">
            Bla bla users, could be a mini search form
            </div><!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-6 connectedSortable">

            <h1>Users</h1>
            <?php
            $list = $admin->django->getUsers();
            //print_r($list);exit;
            echo "<table class='table table-condensed table-striped'>";
            echo "<thead>";
            echo "<th>#</th>";
            echo "<th>username</th>";
            echo "<th>email</th>";
            echo "<th>active</th>";
            echo "<th>staff</th>";
            echo "</thead>";
            echo "<tbody>";
            foreach ($list as $k => $v) {
                echo "<tr>";
                echo "<td><a href=user.php?id=".$v['id'].">".$v['id']."</a></td>";
                echo "<td><a href=#>".$v['username'] . "</a>";
                echo "<td>".$v['email'];
                echo "<td>".$v['is_active'];
                echo "<td>".$v['is_staff'];
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
            ?>

            </section><!-- /.Left col -->



            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-6 connectedSortable">
            <h1>Test col.2</h1>


<div class="box box-primary">
    <div class="box-header" style="cursor: move;">
        <!-- tools box -->
        <div class="pull-right box-tools">
            <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="" data-original-title="Date range"><i class="fa fa-calendar"></i></button>
            <button class="btn btn-primary btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="" style="margin-right: 5px;" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
        </div><!-- /. tools -->

        <i class="fa fa-map-marker"></i>
        <h3 class="box-title"> Users</h3>
    </div>

    <div class="box-body no-padding">

        <div class="table-responsive">
            <!-- .table - Uses sparkline charts-->
            <table class="table table-striped table-condensed">
                <tbody><tr>
                    <th>Country</th>
                    <th>Visitors</th>
                    <th>Online</th>
                    <th>Page Views</th>
                </tr>
                <tr>
                    <td><a href="#">USA</a></td>
                    <td><div id="sparkline-1"><canvas width="54" height="20" style="display: inline-block; width: 54px; height: 20px; vertical-align: top;"></canvas></div></td>
                    <td>209</td>
                    <td>239</td>
                </tr>
                <tr>
                    <td><a href="#">India</a></td>
                    <td><div id="sparkline-2"><canvas width="54" height="20" style="display: inline-block; width: 54px; height: 20px; vertical-align: top;"></canvas></div></td>
                    <td>131</td>
                    <td>958</td>
                </tr>
                <tr>
                    <td><a href="#">Britain</a></td>
                    <td><div id="sparkline-3"><canvas width="54" height="20" style="display: inline-block; width: 54px; height: 20px; vertical-align: top;"></canvas></div></td>
                    <td>19</td>
                    <td>417</td>
                </tr>
                <tr>
                    <td><a href="#">Brazil</a></td>
                    <td><div id="sparkline-4"><canvas width="54" height="20" style="display: inline-block; width: 54px; height: 20px; vertical-align: top;"></canvas></div></td>
                    <td>109</td>
                    <td>476</td>
                </tr>
                <tr>
                    <td><a href="#">China</a></td>
                    <td><div id="sparkline-5"><canvas width="54" height="20" style="display: inline-block; width: 54px; height: 20px; vertical-align: top;"></canvas></div></td>
                    <td>192</td>
                    <td>437</td>
                </tr>
                <tr>
                    <td><a href="#">Australia</a></td>
                    <td><div id="sparkline-6"><canvas width="54" height="20" style="display: inline-block; width: 54px; height: 20px; vertical-align: top;"></canvas></div></td>
                    <td>1709</td>
                    <td>947</td>
                </tr>
            </tbody></table><!-- /.table -->
        </div>
    </div><!-- /.box-body-->
    <div class="box-footer">
        <button class="btn btn-info"><i class="fa fa-download"></i> Generate PDF</button>
        <button class="btn btn-warning"><i class="fa fa-bug"></i> Report Bug</button>
    </div>
    </div>


    </section><!-- right col -->
    </div><!-- /.row (main row) -->



</section><!-- /.content -->
</aside><!-- /.right-side -->