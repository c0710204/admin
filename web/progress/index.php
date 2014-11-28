<?php
// User progression
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxApp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

$admin->title("Progress");
echo $admin->printPrivate();
//$user=$admin->user;
$course_id=@$_GET['course_id'];
$user_id=@$_GET['user_id']*1;
if($user=$edxApp->user($user_id)){
    //print_r($user);
    $name="<a href=../user/?id=$user_id>".$user['username']." - ".$user['email']."</a>";
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-user'></i> User course progress <small><?php echo $name?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> <?php echo explode('/', $course_id)[0]?></a></li>
        <li class="active"> <?php echo @explode('/', $course_id)[1]?></li>
        <li class="active"><a href='../course/?id=<?php echo @$course_id?>'><?php echo @explode('/', $course_id)[2]?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
//echo "<pre>"; print_r($_GET); echo "</pre>";

if (!$user_id) {

    echo "<div class=row><section class='col-lg-6 connectedSortable'>";
    /*
    $box=new Admin\SolidBox;
    $box->type("danger");
    $box->icon("fa fa-book");
    $box->title("Select user");
    echo $box->html($html);
    */
    echo new Admin\Callout("danger","error: no user selected");
    echo "</section></div>";
    exit;
}



// list of courses //
if (!$course_id) {

    echo "<a href=../user/?id=$user_id>$user_id</a>";
    
    //$ids=$edxapp->courseids();// get the complete list of courses
    $ids=$edxApp->studentCourseEnrollment($user_id);//get the list of courses the user is registered in
    //print_r($ids);
    $html=[];
    $html[]="<select id=courses class='form-control'>";
    foreach($ids as $r){
        $course_id=$r['course_id'];
        $html[]="<option value='".$r['course_id']."'>".$r['course_id']."</option>";
    }
    $html[]="</select>";

    $box=new Admin\SolidBox;
    $box->type("danger");
    $box->icon("fa fa-book");
    $box->title("Select course");
    
    echo "<div class=row><section class='col-lg-6 connectedSortable'>";
    echo $box->html($html);
    echo "</section></div>";
    //exit;
}




?>

<!-- Main row -->
<div class="row">
    
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php 
    include "course_info.php";
    ?>
    </section>
    
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    include "user_info.php";
    ?>
    </section>

</div>
<?php

if(!$user_id)die("Select a User from");

//include "progress_data.php";

// User data
// $sql = "SELECT * FROM edxapp.courseware.studentmodule WHERE student_id=$student_id AND course_id LIKE '$course_id';";
// $progress=($edxapp->courseUnitSeen($course_id, $r['user_id'])/$unitCount)*100;

include "debug.php";exit;
include "problems.php";
