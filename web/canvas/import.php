<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

$edxapp= new Admin\EdxApp();
//$edxCourse= new Admin\EdxCourse();
//$edxTest= new Admin\EdxTest();
$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Canvas <small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<pre>
<?php


//$user_ids=[];
//$user_ids[]=36;//jean baptiste camus

foreach ($user_ids as $user_id) {

    //
    $usr=$canvas->user($user_id);
    echo $usr['email']."\n";
    //print_r($usr);
    
    // register user
    $edx_user_id=$edxapp->userCreate($usr['email'], $usr['first_name'], $usr['last_name'], $usr['created_at']);
    
    echo "edx_user_id=$edx_user_id\n";

    //enrollments
    $enrolls=$canvas->userEnrollments($usr['id']);
    
    //echo count($enrolls)." enrollments\n";
    foreach ($enrolls as $enr) {
        //print_r($enr);
        $edxapp->enroll($enr['edx_id'], $edx_user_id, $enr['created_at']);
    }

    //$edxapp->enroll($course_id = '', $user_id = 0);
    //
}
die("done\n");
?>
</section>
