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
        /*
        $sql= "SELECT id, user_id, created FROM edxapp.student_courseenrollment ";
        $sql.="WHERE course_id LIKE '$course_id' LIMIT $limit;";
        
        $q=$admin->db()->query($sql) or die("<pre>".print_r($admin->db()->errorInfo(), true)."</pre>");
        */
        $data=$edxApp->enrollments($_POST['course_id'], $_POST['limit']);
        $dat=[];
        foreach ($data as $r) {
            $r['created']=substr($r['created'], 0, 10);
            $r['username']=$edxApp->userName($r['user_id']);
            $dat[]=$r;
        }

        echo json_encode($dat);
        exit;
        break;


    default:
        die('Error : unknow action');
}

die("Error");
