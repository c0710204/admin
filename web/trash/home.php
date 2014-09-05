<?php
//admin home
header('Content-Type: text/html; charset=utf-8');

require __DIR__."/../vendor/autoload.php";

include "head.php";
include "header.php";
?>

<div class="wrapper row-offcanvas row-offcanvas-left">

    <!-- Left side column. contains the logo and sidebar -->
    <?php
    include "left_side.php";
    ?>


    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Control panel</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <?php
            //include "box_statboxes.php";
            ?>

            <!-- top row -->
            <div class="row">
                <div class="col-xs-12 connectedSortable">

                </div><!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-6 connectedSortable">

                <?php
                //include "box_serverload.php";
                //include "box_charts.php";
                //include "box_calendar.php";
                //include "box_email.php";
                ?>

                </section><!-- /.Left col -->

                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">

                <?php
                //include "box_map.php";
                //include "box_chat.php";
                //include "box_todolist.php";
                ?>

                </section><!-- right col -->
            </div><!-- /.row (main row) -->

        </section><!-- /.content -->
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->


<?php
include "scripts.php";
?>
</body>
</html>