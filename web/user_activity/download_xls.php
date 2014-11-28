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

/*
if (isset($_GET['course_id'])) {
    $course_id=$_GET['course_id'];
} else {
    die("Error: no course id");
}

if (!$edxCourse->exist($course_id)) {
    die("Course not found");
}
*/

$WHERE=[];
$WHERE[]='1=1';// jambonbill

if($_GET['user_id']>1)$WHERE[]='student_id='.$_GET['user_id'];// jambonbill
if($_GET['course_id'])$WHERE[]="course_id LIKE ".$admin->db()->quote($_GET['course_id']);
if($_GET['module_type']>1)$WHERE[]="module_type LIKE ".$admin->db()->quote($_GET['module_type']);
if($_GET['limit']>1){
    $limit=$_GET['limit']*1;
}else{
    $limit=100;
}

$WHERE = implode(" AND ",$WHERE);

$sql = "SELECT * FROM edxapp.courseware_studentmodule WHERE $WHERE ORDER BY modified DESC LIMIT $limit;";// ORDER BY id DESC
$q=$admin->db()->query($sql) or die("<pre>".print_r($admin->db()->errorInfo(), true)."</pre>");

//echo "<pre>";

/*
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

$data1=[];
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    //echo "<pre>";print_r($r);exit;
    //$row=[];
    //print_r($r);
    //$user=$edxApp->user($r['user_id']);
    //print_r($user);
    $data1[]=[$r['id'],$r['module_type'],$r['student_id'], $r['state'], $r['grade'], $r['created'],$r['modified'],$r['max_grade'],$r['done'],$r['course_id']];
    //$data1[]=$r;
}


$header = array(
    'id'=>'string',
    'module_type'=>'string',
    'student_id'=>'string',
    'state'=>'string',
    'grade'=>'string',
    'created'=>'datetime',
    'modified'=>'datetime',
    'max_grade'=>'string',
    'done'=>'string',
    'course_id'=>'string'
);



//print_r($data1);
//user_id, email, first_name, last_name, joined

$filename = "user_activity.xlsx";

header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$writer = new XLSXWriter();
$writer->setAuthor('FBM');
$writer->writeSheet($data1, "course_id", $header);
//$writer->writeSheet([], 'Course info');
$writer->writeToFile($filename);
$writer->writeToStdOut();
