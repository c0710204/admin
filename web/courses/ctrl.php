<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\Curl;
//use Admin\AdminLte;

use Admin\EdxApp;
use Admin\EdxCourse;

$edxapp = new EdxApp();
$edxCourse = new EdxCourse();


//print_r($_POST);

switch($_POST['do']){

    case "list":
        //print_r($_POST);
        $ids=$edxapp->courseids($_POST['org']);// get the lst of courses
        //print_r($ids);
        $DATA=[];
        foreach ($ids as $course_id) {
            $R=[];
            $o=explode("/", $course_id);
            $edxCourse->org($o[0]);//set
            $edxCourse->course($o[1]);//set
            $edxCourse->name($o[2]);//get
            $meta=$edxCourse->metadata();
            
            $R['id']=$course_id;
            $R['org']=$o[0];
            $R['course']=$o[1];
            $R['name']=$o[2];
            $R['display_name']=$meta['display_name'];
            $R['short_desc']=substr($edxCourse->shortDescription(), 0, 32);
            
            $R['start']=date('Y-m-d', $edxCourse->start_date());
            $R['end']=date('Y-m-d', $edxCourse->end_date());
            //$R['end']=0;

            $R['youtube']=$edxCourse->youtubeid();
            $R['chapters']=count($edxCourse->chapters());

            $R['units']=$edxCourse->unitCount();
            $R['enroll']=$edxapp->enrollCount($course_id);// start date
            
            $DATA[]=$R;
        }
        die(json_encode($DATA));
        break;

    case "delete":
        print_r($_POST);
        break;

    case "newCourse":
        print_r($_POST);
        $new = $edxapp->createCourse($_POST['org'], $_POST['course'], $_POST['name']);
        if ($new) {
            die("Course $new created\n");
        } else {
            die("error");
        }
        break;

    default:
        die("Error : Unknow action : " . $_POST['do']);
        break;
}
//echo $admin->box("danger", "Details", "<div class=''></div>");
