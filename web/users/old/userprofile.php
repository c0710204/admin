<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../vendor/autoload.php";

//use Admin\Curl;
use Admin\AdminLte;
use Admin\UserDjango;

$admin = new AdminLte();
$UD = new UserDjango();

echo $admin->printe();
//echo $admin->body();
//echo $admin->page();
//echo $admin->scripts();
?>
<aside class="right-side">

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

                <h1>Test col.1</h1>
                <?php
                $list = $UD->getUsers();
                print_r($list);
                ?>

                </section><!-- /.Left col -->

                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">
                <h1>Test col.2</h1>
                <?php
                print_r($_SESSION);
                ?>
                </section><!-- right col -->
            </div><!-- /.row (main row) -->



        </section><!-- /.content -->
    </aside><!-- /.right-side -->