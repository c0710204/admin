<?php
//admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->ctrl();
//print_r($_POST);

switch ($_POST['do']) {


    case 'enroll':
        //print_r($_POST);
        $edxApp = new EdxApp();
        if ($edxApp->enroll($_POST['course_id'], $_POST['user_id'])) {
            //$course->enroll($_POST['course_id'], $_POST['user_id']);// todo finish this
            die("document.location.href='../courses/';");
        } else {
            die("Course not found");
        }
        exit;
        break;

    case 'listEnroll':

        $edxApp = new EdxApp();
        $course_id=$_POST['course_id'];
        $limit=5;

        $data=$edxApp->enrollments($_POST['course_id'], $_POST['limit']);
        $dat=[];
        foreach ($data as $r) {
            $r['created']=substr($r['created'], 0, 10);
            $user = $edxApp->user($r['user_id']);
            //print_r($user);exit;
            $r['username']=$edxApp->userName($r['user_id']);
            $r['first_name']=$user['first_name'];
            $r['last_name']=$user['last_name'];
            $r['email']=$user['email'];
            $dat[]=$r;
        }

        echo json_encode($dat);
        exit;
        break;


    default:
        die('Error : unknow action');
}

die("Error");
