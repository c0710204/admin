<?php
// User progression
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxapp = new Admin\EdxApp();
//$edxcourse = new EdxCourse();

echo $admin->printPrivate();
//$user=$admin->user;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-user'></i> Progress <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php
$course_id=$_GET['course_id'];
$user_id=$_GET['user_id']*1;
//echo "<pre>"; print_r($_GET); echo "</pre>";

$body=[];
// user name
$body[]='<div class="form-group">';
$body[]='<label><i class="fa fa-user"></i></label> <a href="../user/?id='.$user_id.'">'.ucfirst($edxapp->username($user_id)).'</a>';
$body[]='</div>';

// course name
$body[]='<div class="form-group">';
$body[]='<label><i class="fa fa-book"></i></label> <a href="../course/?id='.$course_id.'">'.$edxapp->courseName($course_id).'</a>';
$body[]='</div>';

$box=new Admin\SolidBox;
$box->icon("fa fa-line-chart");
$box->title("User/Course progression");
$box->body($body);
?>

<!-- Main row -->
<div class="row">
    
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php echo $box->html();?>
    </section>
    
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php echo $box->html();?>
    </section>

</div>

<?php

//User data
//$sql = "SELECT * FROM edxapp.courseware.studentmodule WHERE student_id=$student_id AND course_id LIKE '$course_id';";

//$progress=($edxapp->courseUnitSeen($course_id, $r['user_id'])/$unitCount)*100;
$progressData=$edxapp->courseUnitData($course_id, $user_id);
$DAT=[];

foreach ($progressData as $r) {
    $DAT[$r['module_id']]=$r['state'];   
    //echo "<pre>";print_r($r);echo "</pre>";
}
echo "<pre>";
print_r($DAT);
