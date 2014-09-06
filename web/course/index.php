<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;
use Admin\EdxForum;

$admin = new AdminLte();
$admin->title("Course");
echo $admin->printPrivate();


$course_id=@$_GET['id'];

if (isset($_GET['course_id'])) {
    $course_id=@$_GET['course_id'];
}

$edxapp = new EdxApp();
$edxCourse = new EdxCourse($course_id);
$edxForum = new EdxForum();


// metadata
//$meta = $edxapp->course_metadata($_GET['org'], $_GET['course']);
$meta = $edxCourse->metadata($course_id);


// http://edx.readthedocs.org/projects/devdata/en/latest/course_data_formats/course_xml.html
// http://edx.readthedocs.org/projects/devdata/en/latest/course_data_formats/grading.html
echo "<input type='hidden' id='course_id' value='$course_id'>";
?>

<section class="content-header">
    <h1><a href='../courses/'><i class='fa fa-book'></i></a> Course : <?php echo $edxapp->courseName($course_id)?><small><a href='../courses/'><i class='fa fa-search'></i> Search courses</a></small></h1>
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
        include "course_info.php";
        include "course_chapters.php";
        
        include "course_video.php";
        include "course_image.php";
        //include "course_tabs.php";
        //include "course_outline.php";
        //include "course_textbooks.php";
        //include "course_updates.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        //include "course_overview.php";

        //include "course_grading.php";//grading policy
        include "course_enroll.php";
        include "course_forum.php";
        //include "course_debug.php";
        include "course_drop.php";
        ?>
    </section>
</div>



<script src='course.js'></script>
