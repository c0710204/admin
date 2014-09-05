<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Courses");

echo $admin->printPrivate();

$edxapp= new Admin\EdxApp();
$edxCourse= new Admin\EdxCourse();
//$edxTest= new Admin\EdxTest();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Courses <small></small></h1>
</section>

<!-- Main content -->
<section class="content">
    <?php
    include "course_filter.php";// list of courses
    include "course_list.php";// list of courses
    ?>
</section>

<script src='courses.js'></script>
