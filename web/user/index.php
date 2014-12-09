<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("User");
echo $admin->printPrivate();

$edxApp = new EdxApp();
$edxCourse = new EdxCourse();


$USERID=$_GET['id']*1;

$usr=$edxApp->user($USERID);
$up =$edxApp->userprofile($USERID);
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-user'></i> <?php echo $usr['username']?>
        <small> <a href='../users/'><i class='fa fa-search'></i>Search users</a></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-user"></i> <?php echo $usr['email']?></a></li>
        <li class="active">#<?php echo $usr['id']?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
//print_r($usr);
if (!$usr || !$up) {
    echo $admin->callout("danger", "<i class='fa fa-ban'></i> Error", "User #$USERID not found or incomplete");
    exit;
} else {
    echo "<input type=hidden id='userid' value='$USERID'>";
}
?>


<!-- Main row -->
<div class="row">

    <!-- Left col -->
    <section class="col-sm-6 connectedSortable">
    <!-- Userinfo -->
    <?php
    //include "user_info.php";
    include "user_profile.php";
    //include "user_activity.php";
    ?>
    </section>

    <section class="col-sm-6 connectedSortable">
    <!-- Userprofile -->
    <?php
    include "user_course_enrolment.php";
    //include "user_course_accessrole.php";
    include "user_certificates.php";
    include "user_drop.php";
    ?>
    </section><!-- /.Col -->

</div>



