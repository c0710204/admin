<?php
//admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;
use Admin\EdxForum;

$admin = new AdminLte();
$edxapp = new EdxApp();
$edxcourse = new EdxCourse();
$forum = new EdxForum();

echo $admin->printPrivate();
$user=$admin->user;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-home'></i> Home <small><?php echo $user['username']." #".$user['id']?></small></h1>
</section>



<section class="content">

<!-- Tiles -->
<?php include "tiles.php"; ?>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-sm-6 connectedSortable">
    <?php
    include "box_enrollments.php";
    //include "box_registrations.php";//new regs
    include "linechart.php";
    ?>
    </section><!-- /.Left col -->

    <!-- right col (We are only adding the ID to make the widgets sortable)-->
    <section class="col-sm-6 connectedSortable">
    <?php
    include "box_user.php";//new users
    
    //include "box_recentEnrollments.php";
    //include "box_recentActivity.php";
    //include "box_session.php";
    //include "box_tools.php";
    ?>
    </section><!-- right col -->
</div><!-- /.row (main row) -->



        </section><!-- /.content -->
    </aside><!-- /.right-side -->