<?php
//admin :: course enrollments
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
//use Admin\EdxApp;
//use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Course enrollments");
echo $admin->printPrivate();



if (isset($_GET['course_id'])) {
    $course_id=@$_GET['course_id'];
} elseif(isset($_GET['id'])) {
    $course_id=@$_GET['id'];
} else {
    die("Error");
}


$edxapp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse($course_id);

// metadata

//$meta = $edxCourse->metadata($course_id);

// http://edx.readthedocs.org/projects/devdata/en/latest/course_data_formats/course_xml.html
// http://edx.readthedocs.org/projects/devdata/en/latest/course_data_formats/grading.html
echo "<input type='hidden' id='course_id' value='$course_id'>";
?>

<section class="content-header">
    <h1><a href='../courses/'><i class='fa fa-book'></i></a> Enrollments in course : <?php echo $edxapp->courseName($course_id)?></h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-book"></i> <?php echo explode('/', $course_id)[0]?></li>
        <li class="active"><?php echo explode('/', $course_id)[1]?></li>
        <li class="active"><a href='../course/?id=<?php echo $course_id?>'><?php echo explode('/', $course_id)[2]?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
if (!$edxCourse->exist($course_id)) {
    echo new Admin\Callout('Danger', 'Course "'.$course_id.'" not found', 'The course was not found or not available');
    //exit;
}
?>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        //include "course_overview.php";
        ?>
    </section>
</div>
