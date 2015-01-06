<?php
// user info ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;


$admin = new AdminLte("../config.json");
$admin->ctrl();

$edxApp=new Admin\EdxApp();
$edxCourse=new Admin\EdxCourse();


switch($_POST['do']){


    case 'enroll':
        //print_r($_POST);
        $id=$edxApp->enroll($_POST['course_id'], $_POST['user_id']);
        if ($id) {
            die("getEnrolls();");
        }
        exit;
        break;

    case 'disenroll':
        //print_r($_POST);
        $id=$edxApp->disenroll($_POST['course_id'], $_POST['user_id']);
        if ($id) {
            die("getEnrolls();");
        }
        exit;
        break;

    case 'enrollList'://return the list of enrollments
        $courses=$edxApp->studentCourseEnrollment($_POST['user_id']);
        $dat=[];
        foreach ($courses as $course) {
            $course['name']=ucfirst(strtolower($edxApp->courseName($course['course_id'])));
            $course['created']=substr($course['created'],0,10);
            
            $unitCount=$edxCourse->unitCount($course['course_id']);
            
            $progress=0;
            if ($unitCount > 0) {
                $progress=($edxApp->courseUnitSeen($course['course_id'], $_POST['user_id'])/$unitCount)*100;
            }
            
            $course['progress']=round($progress);
            $dat[]=$course;
        }
        echo json_encode($dat);
        exit;
        break;

    case 'sessionList'://return the list of sessions
        //print_r($_POST);
        $USERID=$_POST['user_id']*1;
        $user_sessions=@$edxApp->sessions([$USERID])[$USERID];
        $dat=[];
        foreach ($user_sessions as $session) {            
            //$body[]="<a href='../session/?id=$session_id'>";
            //$body[]=date("D d M Y ",strtotime($session['date_from'])) . "</a>";
            //$body[]="<td>".substr($session['date_from'],0,16);
            $session['length']=strtotime($session['date_to']) - strtotime($session['date_from']);
            
            //$minutes=round($length/60);
            //$body[]="<td>".$minutes." min";
            $dat[]=$session;
        }
        echo json_encode($dat);
        exit;
        break;

    case 'resetPassword':
        
        if(strlen($_POST['pass'])<6) {
            die('alert("Error : Password is too short !");');
        }

        $password=$admin->django->djangopassword($_POST['pass']);
        
        if ($password) {
            $edxApp->updatePassword($_POST['user_id'], $password);
            die("document.location.href='?id=".$_POST['user_id']."'");
        }
        die("error");
        break;

    case 'saveUserInfo':
        //print_r($_POST);
        $edxApp->updateUserProfile($_POST['user_id'], $_POST);
        die("document.location.href='?id=".$_POST['user_id']."';");
        break;

    default:
        die("Error : unknow action ".$_POST['do']);
        break;

}

die("Ctrl error");