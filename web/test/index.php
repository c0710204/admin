<?php
//admin test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;
//use Admin\Box;
//use Admin\SmallBox;
//use Admin\Tile;

$admin = new Admin\AdminLte();
$box = new Admin\Box;
//$solidbox = new Admin\SolidBox;
$smallbox= new Admin\SmallBox;

echo $admin->printPrivate();
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php //echo __FILE__ ?>
        Test page
        <small>Test</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">


    <!-- Solid boxes -->
    <div class="row">
        <div class="col-xs-12 connectedSortable">
        <?php
        include "solid_boxes.php";
        ?>
        </div><!-- /.col -->
    </div>


    <!-- top row -->
    <div class="row">
        <div class="col-xs-12 connectedSortable">
        <?php
        include "small_boxes.php";
        ?>
        </div><!-- /.col -->
    </div>


    <!-- Tiles -->
    <div class='row'>
        <div class="col-xs-12 connectedSortable">
        <?php
        include "tiles.php";
        ?>
        </div>
    </div>

    <div class='row'>
    <?php include "box_loading.php";?>
    </div>

    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable"></section><!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable"></section><!-- right col -->
    </div><!-- /.row (main row) -->



</section><!-- /.content -->
</aside><!-- /.right-side -->