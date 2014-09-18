<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

$edxapp= new Admin\EdxApp();
$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Canvas courses<small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php

$courses=$canvas->courses();

$htm=[];
$htm[]= "<table class='table table-striped'>";
$htm[]= "<thead>";
$htm[]= "<th width=30>#</th>";
$htm[]= "<th>Name</th>";
$htm[]= "<th>Start at</th>";
$htm[]= "<th>Conclude at</th>";
$htm[]= "<th title='restrict_enrollments_to_course_dates'>RestrictEnr.</th>";
$htm[]= "<th title='enrollments'>Enr.</th>";
$htm[]= "<th>Edx Relation</th>";
$htm[]= "</thead>";

foreach ($courses as $course) {
    $htm[]= "<tr>";
    //echo "<td>".print_r($course, true);
    $htm[]= "<td>".$course['id'];
    $htm[]= "<td>".$course['name'];
    $htm[]= "<td>".substr($course['start_at'], 0, 10);
    $htm[]= "<td>".substr($course['conclude_at'], 0, 10);
    $htm[]= "<td>".$course['restrict_enrollments_to_course_dates'];
    $htm[]= "<td style='text-align:right'><a href='canvas_enrollments.php?id=".$course['id']."'>".number_format($canvas->courseEnrollCount($course['id']));
    $htm[]= "<td><a href='../course/?id=".$course['edx_id']."'>".$course['edx_id'];
    $htm[]= "</tr>";
}
$htm[]= "</table>";

$box=new Admin\SolidBox;
$box->type("danger");
$box->title(count($courses) . " canvas courses");
//$box->icon("fa fa-book");
echo $box->html($htm);

//print_r($courses);
//$user_ids=$canvas->userIds();
//die("count:".count($user_ids));
?>
<script>
$(function(){
    $("table").tablesorter();
    console.log("ready");
});
</script>
