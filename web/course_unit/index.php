<?php
// course unit
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Course unit");
echo $admin->printPrivate();

$edxapp = new EdxApp();
$edxCourse = new EdxCourse();

//$unit_id='72f458742cce4084b36649a1cb6e93a0';
//$unit_id='i4x://q/q/sequential/2795f34a935447db93bc4362bc84e1d7';
$unit_id=$_GET['id'];

if (!preg_match("/^i4x/", $unit_id)) {
    echo "Invalid unit format : $unit_id";
    exit;
}

$unitName=$edxCourse->unitName($unit_id);
$unit=$edxCourse->unit($unit_id);
//print_r($unit);
$ID=$unit['_id'];
$name=$unit['_id']['name'];
$category=$unit['_id']['category'];
$definition=$unit['definition'];
$metadata=$unit['metadata'];
$course_id = $ID['org'].'/'.$ID['course'].'/permanent';

?>
<section class="content-header">
    <h1><a href='../course/?course_id=<?php echo $course_id?>'><i class='fa fa-book'></i></a> Course unit : <?php echo $unitName?></h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> <?php echo $ID['org']?></a></li>
        <li class="active"><?php echo $ID['course']?></li>
        <li class="active"><?php echo $ID['course']?></li>
        
    </ol>
</section>

<!-- Main content -->
<section class="content">


<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-xs-6 connectedSortable">
        <?php
        //include "box_info.php";
        include "box_location.php";
        /*
        if ($unit['_id']['category']!='course') {
            include "box_location.php";
        }
        */
        include "box_userlog.php";
        include "box_user.php";
        include "box_metadata.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-xs-6 connectedSortable">
        <?php
        switch($unit['_id']['category']){

            case 'video':
                include "box_video.php";
                break;

            case 'html':
                include "box_html.php";
                break;

            case 'course':
            case 'chapter':
            case 'vertical':
            case 'sequential':
                //include "box_childrens.php";
                break;


            case 'problem':
                include "box_problem.php";
                //echo "<pre>".print_r($unit, true)."</pre>";
                break;


            default:
                echo "<pre>".print_r($unit, true)."</pre>";
                break;
        }
        /*
        if ($unit['_id']['category']=='video') {
            include "box_video.php";
        }
        */
        //echo "<pre>$unit_id</pre>";
        //echo "<pre>".print_r($unit, true)."</pre>";

        //echo $admin->box("success", "Results", "<div id='more'></div>");
        ?>
    </section>
</div>




<?php

$unit = $edxCourse->unit($unit_id);
//echo "<pre>"; print_r($unit); echo "</pre>";
/*
$childrens=$unit['definition']['children'];
echo count($childrens)." children(s);<hr />";
foreach ($childrens as $id) {
    echo "<li>".$edxCourse->unitName($id);
}
*/
