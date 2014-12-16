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
        
        $_POST['limit']*=1;

        //print_r($_POST);exit;


        $data=$edxApp->enrollments($_POST['course_id'], $_POST['limit']);
        $dat=[];
        $users=[];
       
        foreach ($data as $r) {
            $r['created']=substr($r['created'], 0, 10);
            $users[]=$r['user_id'];//list of users
        }

        // filter on usernames, emails, etc
        

        if ($_POST['search']) {
                        
            $OR=[];
            $OR[]="username LIKE '%".$_POST['search']."%'";
            $OR[]="email LIKE '%".$_POST['search']."%'";
            $OR[]="first_name LIKE '%".$_POST['search']."%'";
            $OR[]="last_name LIKE '%".$_POST['search']."%'";
            $WHERE[]="(".implode(" OR ", $OR).")";
            
            $sql = "SELECT id FROM edxapp.auth_user WHERE ".implode(" AND ",$WHERE).";";
            $q=$admin->db()->query($sql) or die("<pre>error:$sql</pre>");
            
            $user_filter=[];    
            while($r=$q->fetch(PDO::FETCH_ASSOC))$user_filter[]=$r['id'];

            $tmp=[];
            foreach(array_intersect($users, $user_filter) as $k=>$v)$tmp[]=$v;
            $users=$tmp;
        }

        

        $userData=$edxApp->userData($users);
        $progressData=$edxApp->progressData($course_id, $users);
        //print_r($progressData);exit;
        //print_r($userData);exit;
        foreach($users as $user_id){
            $r=[];
            $r['user_id']=$user_id;
            $r['username']=$userData[$user_id]['username'];
            $r['first_name']=$userData[$user_id]['first_name'];
            $r['last_name']=$userData[$user_id]['last_name'];
            $r['email']=$userData[$user_id]['email'];
            $r['progress']=@count($progressData[$user_id]);
            $dat[]=$r;
        }

        echo json_encode($dat);
        
        exit;
        break;


    default:
        die('Error : unknow action');
}

die("Error");
