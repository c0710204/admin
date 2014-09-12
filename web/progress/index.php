<?php
// User progression
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxapp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

echo $admin->printPrivate();
//$user=$admin->user;
$course_id=$_GET['course_id'];
$user_id=$_GET['user_id']*1;
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-user'></i> Course progress <small></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i> <?php echo explode('/', $course_id)[0]?></a></li>
        <li class="active"> <?php echo explode('/', $course_id)[1]?></li>
        <li class="active"><a href='../course/?id=<?php echo $course_id?>'><?php echo explode('/', $course_id)[2]?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
//echo "<pre>"; print_r($_GET); echo "</pre>";

$body=[];
// user name
$body[]='<div class="form-group">';
$body[]='<label><i class="fa fa-user"></i></label> <a href="../user/?id='.$user_id.'">'.ucfirst($edxapp->username($user_id)).' ('.$user_id.')</a>';
$body[]='</div>';


$box=new Admin\SolidBox;
$box->icon("fa fa-user");
$box->title("User progress");
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
    <?php //echo $box->html();?>
    </section>

</div>
<?php
//include "progress_data.php";

// User data
// $sql = "SELECT * FROM edxapp.courseware.studentmodule WHERE student_id=$student_id AND course_id LIKE '$course_id';";
// $progress=($edxapp->courseUnitSeen($course_id, $r['user_id'])/$unitCount)*100;

include "problems.php";
