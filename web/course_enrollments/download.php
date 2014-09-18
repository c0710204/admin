<?php
// admin :: couse enrollment download
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;
use Admin\XLSXWriter;

$admin = new AdminLte();
$admin->ctrl();

$edxApp=new EdxApp();
$edxCourse=new EdxCourse();

//print_r($_GET);

$course_id=$_GET['course_id'];

if (!$edxCourse->exist($course_id)) {
    die("Course not found");
}


$header = array(
    'user_id'=>'string',
    'email'=>'string',
    'first_name'=>'string',
    'last_name'=>'string',
    'active'=>'string',
    //'email'=>'string',
    //'month'=>'string',
    //'amount'=>'money',
    //'first_event'=>'datetime',
    'enrolled'=>'date',
);


$data=$edxApp->enrollments($course_id);
//echo "<pre>";
$data1=[];
foreach ($data as $r) {
    $row=[];
    //print_r($r);
    $user=$edxApp->user($r['user_id']);
    //print_r($user);
    $data1[]=[$r['user_id'],$user['email'],$user['first_name'], $user['last_name'], $r['is_active'], $r['created']];
}

//print_r($data1);
//user_id, email, first_name, last_name, joined

$filename = "enrollments.xlsx";

header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$writer = new XLSXWriter();
$writer->setAuthor('FBM');
$writer->writeSheet($data1, "$course_id", $header);
$writer->writeSheet([], 'Course info');
$writer->writeToFile($filename);
$writer->writeToStdOut();

//die("ok");
