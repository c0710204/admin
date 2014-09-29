<?php
// admin :: group

header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

// use Admin\AdminLte;

$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();

echo $admin->printPrivate();
// print_r($GC);
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Groups <small>Group info</small></h1>
</section>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    print_r($_GET);
    ?>
    </section>

    <!-- col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    print_r($_GET);
    ?>
    </section>


</div>

<script>
$(function(){
    $("table").tablesorter();
});
</script>


<?php



// auth_group_permissions
// auth_user_groups


// course_groups_courseusergroup
// course_groups_courseusergroup_users
// paid_group


// student_usertestgroup
// student_usertestgroup_users


// waffle_flag_groups
