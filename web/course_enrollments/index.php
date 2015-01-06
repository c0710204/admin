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

$course_id='';
if (isset($_GET['course_id'])) {
    $course_id=@$_GET['course_id'];
} elseif (isset($_GET['id'])) {
    $course_id=@$_GET['id'];
}

$edxApp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();
echo "<input type='hidden' id='course_id' value='$course_id'>";
?>

<section class="content-header">
    <h1><i class='fa fa-user'></i> <i class='fa fa-angle-right'></i> <i class='fa fa-book'></i> 
    Enrollments in course : <a href='../course/?id=<?php echo $course_id?>'><?php echo ucfirst(strtolower($edxApp->courseName($course_id)))?></a></h1>
    <ol class="breadcrumb">
        <li class="active"><i class="fa fa-book"></i> <?php echo @explode('/', $course_id)[0]?></li>
        <li class="active"><?php echo @explode('/', $course_id)[1]?></li>
        <li class="active"><a href='../course/?id=<?php echo $course_id?>'><?php echo @explode('/', $course_id)[2]?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
if ($course_id && !$edxCourse->exist($course_id)) {
    echo new Admin\Callout('Danger', 'Course "'.$course_id.'" not found', 'The course was not found or not available');
}



if(!$course_id || !$edxCourse->exist($course_id)){// course selector
    include "box_courses.php";// show list of courses
    exit;
} else {
    $rcu = $edxCourse->releventCourseUnits($course_id);
    $rcunumber = count($rcu);
    echo "<input type=hidden id=rcu value='$rcunumber'>";
    //print_r($rcu);
    //echo "<li>".count($rcu);
}

?>



<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-xs-12 connectedSortable">
        <?php
        //include "box_enroll_info.php";
        include "box_search.php";
        ?>
    </section>
</div>



<!-- Main row -->
<div class="row">
    <!-- Right col -->
    <section class="col-xs-12 connectedSortable">
        <?php
        $box=new Admin\SolidBox;
        $box->id("boxenroll");
        $box->title("List users");
        $box->icon("fa fa-list");
        $box->loading(true);
        $box->body_padding(false);
        echo $box->html("Search");
        ?>
    </section>
</div>

<script src='course_enroll.js'></script>