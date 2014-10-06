<?php
//admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;
//use Admin\EdxApp;
//use Admin\EdxCourse;

$admin = new Admin\AdminLte();
$admin->ctrl();

$edxApp = new Admin\EdxApp();
//print_r($_POST);

switch ($_POST['do']) {

    //course info
    case "saveDesc":
        
        //echo "<pre>"; print_r($_POST);echo "</pre>";exit;
        
        $course = new Admin\EdxCourse($_POST['course_id']);

        if (!$course->exist()) {
            die("Course not found");
        }

        $course->updateDisplayName($_POST['displayName']);
        $course->updateShortDescription($_POST['shortDescription']);

        //dates
        //$dates=explode(" - ", $_POST['courseStartEnd']);
        $course->updateCourseStartDate($_POST['courseStart']);
        $course->updateCourseEndDate($_POST['courseEnd']);
        
        //$dates=explode(" - ", $_POST['enrollStartEnd']);
        $course->updateEnrollStartDate($_POST['enrollStart']);
        $course->updateEnrollEndDate($_POST['enrollEnd']);
        
        die("document.location.href='?course_id=".$_POST['course_id']."';");

        break;


    // the big html desc
    case "saveOverview":
        //print_r($_POST);
        $course = new Admin\EdxCourse($_POST['course_id']);
        if ($course->exist()) {
            $course->updateOverview($_POST['html']);
            die("document.location.href='?course_id=".$_POST['course_id']."';");
        } else {
            die("Course not found");
        }
        break;

    case 'updateVideo':

        //print_r($_POST);

        $course = new Admin\EdxCourse($_POST['course_id']);
        if ($course->exist()) {
            $course->updateVideo($_POST['youtubeid']);
            echo "console.log('Video updated');\n";
            die("document.location.href='?course_id=".$_POST['course_id']."';");
        } else {
            die("Course not found");
        }
        break;


    case 'updateImage':
        //print_r($_POST);
        $course = new Admin\EdxCourse($_POST['course_id']);
        if ($course->exist()) {
            // todo :: check if file exist
            $course->updateImage($_POST['filename']);
            die("document.location.href='?course_id=".$_POST['course_id']."';");
        } else {
            die("Course not found");
        }
        exit;
        break;


    case 'dropVideo':
        //print_r($_POST);
        $course = new Admin\EdxCourse($_POST['course_id']);
        if ($course->exist()) {
            $course->deleteVideo();
            die("document.location.href='?';");
        } else {
            die("Course not found");
        }
        break;



    case 'drop':
        //print_r($_POST);
        $edxCourse = new Admin\EdxCourse();
        if ($edxCourse->exist($_POST['course_id'])) {
            
            $edxApp = new Admin\EdxApp();
            $delete=$edxApp->deleteCourseData($_POST['course_id']);
            if (!$delete) {
                echo "<li>Error1:deleteCourseData";
            }

            
            $delete=$edxCourse->delete($_POST['course_id']);
            
            if (!$delete) {
                echo "<li>Error2:edxCourse->delete";
            }
            
            if ($edxCourse->exist($_POST['course_id'])) {
                die("Error deleting course ".$_POST['course_id']);
            }

            die("document.location.href='../courses/';");
        
        } else {
            die("Course not found");
        }
        break;


    // remove a user from a group
    // the record id has to be given
    case 'removeGroupUser':
        //print_r($_POST);
        if ($edxApp->userGroupDel($_POST['id'])) {
            die("document.location.href='?id=".$_POST['course_id']."';");
        }
        exit;
    
    // add a user to a given group
    case 'addGroupUser':
        //print_r($_POST);
        if ($edxApp->userGroupAddUser($_POST['group_id'], $_POST['user_id'])) {
            die("document.location.href='?id=".$_POST['course_id']."';");
        }
        break;
    


    case 'addRole'://add a user to a role group (forum user group)
        //print_r($_POST);
        if ($edxApp->clientRoleUserAdd($_POST['role_id'], $_POST['user_id'])) {
            die("document.location.href='?id=".$_POST['course_id']."';");
        }
        break;

    case 'delRole'://
        //print_r($_POST);
        if ($edxApp->clientRoleDelete($_POST['id'])) {
            die("document.location.href='?id=".$_POST['course_id']."';");
        }
        break;


    // course enroll
    case 'enroll':
        //print_r($_POST);
        $edxApp = new Admin\EdxApp();
        if ($edxApp->enroll($_POST['course_id'], $_POST['user_id'])) {
            //$course->enroll($_POST['course_id'], $_POST['user_id']);// todo finish this
            die("document.location.href='../courses/';");
        } else {
            die("Course not found");
        }
        exit;
        break;


    case 'listEnroll':
        //print_r($_POST);
        //echo json_encode($_POST);
        $edxApp = new Admin\EdxApp();
        $course_id=$_POST['course_id'];
        $limit=5;
        
        $sql= "SELECT id, user_id, created FROM edxapp.student_courseenrollment ";
        $sql.="WHERE course_id LIKE '$course_id' LIMIT $limit;";
        
        $q=$admin->db()->query($sql) or die("<pre>".print_r($admin->db()->errorInfo(), true)."</pre>");
        $dat=[];
        
        while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
            $r['created']=substr($r['created'], 0, 10);
            $r['username']=$edxApp->userName($r['user_id']);
            $dat[]=$r;
        }
        echo json_encode($dat);
        exit;
        break;


    default:
        die('Error : unknow action '.$_POST['do']);
}

die("Course Ctrl Error");
