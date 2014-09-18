<?php
// admin :: couse enrollment download
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->ctrl();

$edxApp=new EdxApp();
$edxCourse=new EdxCourse();

//print_r($_GET);

$course_id=$_GET['course_id'];

if (!$edxCourse->exist($course_id)) {
    die("Course not found");
}

$data=$edxApp->enrollments($course_id, 1);

foreach ($data as $r) {
    print_r($r);
}

die("ok");
