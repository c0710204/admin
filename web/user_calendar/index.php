<?php
// admin :: Calendar
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Calendar");
echo $admin->printPrivate();

$edxApp = new EdxApp();
$edxCourse = new EdxCourse();

$USERID=@$_GET['id']*1;
if(isset($_GET['user_id']))$USERID=$_GET['user_id']*1;

$usr=$edxApp->user($USERID);
$up =$edxApp->userprofile($USERID);

if (!$usr) {
    echo "Error : user not found";
    exit;
} else {
    echo "<input type='hidden' id=user_id value='$USERID'>";
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-calendar'></i> <i class='fa fa-chevron-right'></i> <i class='fa fa-user'></i> <?php echo $usr['username']?>
        <small> <a href='../users/'><i class='fa fa-search'></i>Search users</a></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> <?php echo $usr['email']?></a></li>
        <li class="active">#<?php echo $usr['id']?></li>
    </ol>
</section>



<!-- Main content -->
<section class="content">


<!-- Main row -->
<div class="row">

    <!-- Left col -->
    <section class="col-sm-3 connectedSortable">
    <!-- Userinfo -->
    <?php
    include "box_userinfo.php";
    //include "box_sessions.php";
    ?>
    </section>

    <section class="col-sm-9 connectedSortable">
    <!-- THE CALENDAR -->
    <?php
    $box = new Admin\SolidBox;
    $box->id("boxcalendar");
    $box->icon("fa fa-calendar");
    $box->title("$username calendar");
    echo $box->html("<div id=calendar></div>");

    //include "user_course_enrollment.php";
    //include "user_course_accessrole.php";
    //include "user_certificates.php";
    //include "user_drop.php";
    ?>
    </section><!-- /.Col -->

</div>




<!-- fullCalendar -->
<script src="../js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<!-- Page specific script -->
<script src='calendar.js' type="text/javascript"></script>