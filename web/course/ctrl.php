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

    //course info
    case "saveDesc":
        //echo "<pre>"; print_r($_POST);
        $course = new EdxCourse($_POST['course_id']);

        if (!$course->exist()) {
            die("Course not found");
        }

        $course->updateDisplayName($_POST['displayName']);
        $course->updateShortDescription($_POST['shortDescription']);

        //dates
        $dates=explode(" - ", $_POST['courseStartEnd']);
        $course->updateCourseStartDate($dates[0]);
        $course->updateCourseEndDate($dates[1]);

        $dates=explode(" - ", $_POST['enrollStartEnd']);
        $course->updateEnrollStartDate($dates[0]);
        $course->updateEnrollEndDate($dates[1]);

        die("document.location.href='?course_id=".$_POST['course_id']."';");

        break;


    // the big html desc
    case "saveOverview":
        //print_r($_POST);
        $course = new EdxCourse($_POST['course_id']);
        if ($course->exist()) {
            $course->updateOverview($_POST['html']);
            die("document.location.href='?course_id=".$_POST['course_id']."';");
        } else {
            die("Course not found");
        }
        break;

    case 'updateVideo':

        //print_r($_POST);

        $course = new EdxCourse($_POST['course_id']);
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
        $course = new EdxCourse($_POST['course_id']);
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
        $course = new EdxCourse($_POST['course_id']);
        if ($course->exist()) {
            $course->deleteVideo();
            die("document.location.href='?';");
        } else {
            die("Course not found");
        }
        break;

    case 'drop':
        //print_r($_POST);
        $course = new EdxCourse($_POST['course_id']);
        if ($course->exist($_POST['course_id'])) {
            $course->delete($_POST['course_id']);
            
            $edxApp = new EdxApp();
            $edxApp->deleteCourseData($_POST['course_id']);
            
            die("document.location.href='../courses/';");
        } else {
            die("Course not found");
        }
        break;

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

    default:
        die('Error : unknow action');
}

die("Course Ctrl Error");
