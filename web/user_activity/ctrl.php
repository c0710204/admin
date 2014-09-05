<?php
// ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->ctrl();//check authentication

$edxapp=new EdxApp();
$edxcourse=new EdxCourse();

/*
TABLE: edxapp.courseware_studentmodule
---------------------------------------
1   id  int(11)
2   module_type varchar(32)
3   module_id   varchar(255)
4   student_id  int(11)
5   state   longtext
6   grade   double
7   created datetime
8   modified    datetime
9   max_grade   double
10  done    varchar(8)
11  course_id   varchar(255)
*/

switch ($_POST['do']) {

    case 'search':
        //print_r($_POST);exit;
        $where=[];

        if ($_POST['module_type']) {
            $where[]="module_type LIKE '".$_POST['module_type']."'";
        }


        if ($_POST['course_id']) {
            $where[]="course_id LIKE '".$_POST['course_id']."'";
        }

        $data=$edxapp->studentCourseActivity($_POST['user_id'], $where, $_POST['limit']);
        foreach ($data as $k => $dat) {
            $data[$k]['module_name']=$edxcourse->unitName($dat['module_id']);
        }
        echo json_encode($data);
        exit;
        break;

    default:
        die("Error: unknow action");
        break;

}
