<?php
//admin :: groups
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;

$admin = new Admin\AdminLte("../config.json");

echo $admin->printPrivate();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Groups <small>Group info</small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php


//auth_group
//auth_group_permissions
//auth_user_groups


//course_groups_courseusergroup
//course_groups_courseusergroup_users
//paid_group


//student_usertestgroup
//student_usertestgroup_users


//waffle_flag_groups
