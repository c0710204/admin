<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\Canvas;
use Admin\XLSXWriter;

$edxapp= new Admin\EdxApp();
$canvas= new Admin\Canvas();

$course_id=$_GET['id'];
$course_id=5;


$sql= "SELECT workflow_state, count(workflow_state) as count FROM enrollments ";
$sql.="WHERE course_id=$course_id GROUP BY workflow_state ORDER BY count DESC;";
$q = $canvas->db()->query($sql) or die("Error: $sql");

/*
// workflow state (active|completed|deleted|invited)
$html[]="<table class='table table-condensed'>";
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $dat[]=$r;
    $html[]="<tr>";
    $html[]="<td><a href='canvas_userlist.php?course_id=$course_id&type=".$r['workflow_state']."'>".$r['workflow_state']."</a>";
    $html[]="<td>".$r['count'];
}
$html[]="</table>";
echo $box->html($html);
*/




// data
$enrs=$canvas->courseEnrollments($_GET['id']);

$htm=[];
$htm[]= "<table class='table table-striped table-condensed'>";
$htm[]= "<thead>";
//$htm[]= "<th width=30>#</th>";
$htm[]= "<th>User</th>";
$htm[]= "<th>Username</th>";
$htm[]= "<th>Email</th>";
$htm[]= "<th>Type</th>";
$htm[]= "<th>Workflow st.</th>";
$htm[]= "<th>Created</th>";
$htm[]= "<th>Last activity</th>";
//$htm[]= "<th title='enrollments'>Enr.</th>";
//$htm[]= "<th>Edx Relation</th>";
$htm[]= "</thead>";

$data1=[];
foreach ($enrs as $enr) {
    $row=[];
    $row[]= $enr['user_id'];
    $row[]= $canvas->user($enr['user_id'])['name'];
    $row[]= $canvas->userEmail($enr['user_id']);
    $row[]= $enr['type'];
    $row[]= $enr['workflow_state'];
    $row[]= substr($enr['created_at'], 0, 10);
    $row[]= substr($enr['last_activity_at'], 0, 10);
    $data1[]=$row;
}


$filename = "enrolls.xlsx";

header('Content-disposition: attachment; filename="'.XLSXWriter::sanitize_filename($filename).'"');
header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header('Content-Transfer-Encoding: binary');
header('Cache-Control: must-revalidate');
header('Pragma: public');

$header = array(
    'user_id'=>'string',
    'user_name'=>'string',
    'email'=>'string',
    'type'=>'string',
    'workflow_state'=>'string',
    'created_at'=>'date',
    'last_activity_at'=>'date',
);

/*
$data1 = array(
    array('2003','1','-50.5','2010-01-01 23:00:00','2012-12-31 23:00:00'),
    array('2003','=B2', '23.5','2010-01-01 00:00:00','2012-12-31 00:00:00'),
);
$data2 = array(
    array('2003','01','343.12'),
    array('2003','02','345.12'),
);
*/

$writer = new XLSXWriter();
$writer->setAuthor('FBM');
$writer->writeSheet($data1, 'Sheet1', $header);

//$writer->writeSheet($data2, 'Sheet2');
//$writer->writeToFile('example.xlsx');
$writer->writeToStdOut();
