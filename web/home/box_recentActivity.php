<?php
// recent activity
$db=$admin->db();

$sql="SELECT DISTINCT student_id, course_id, module_id, modified  FROM edxapp.courseware_studentmodule ORDER BY modified DESC LIMIT 8";
$q=$db->query($sql) or die("<pre>".print_r($db->errorInfo(), true)."</pre>");


$body=[];
//$body[]="<pre>$sql</pre>";

$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
//$body[]="<th>#</th>";
$body[]="<th>User</th>";
//$body[]="<th>Org</th>";
$body[]="<th>Course</th>";
//$body[]="<th>Module</th>";
$body[]="<th width=150>Date</th>";
$body[]="</thead>";
$body[]="<tbody>";

while ($r=$q->fetch()) {
    $body[]="<tr>";
    $body[]="<td><a href='../user/?id=".$r['student_id']."'>".$edxapp->username($r['student_id']);
    //$body[]="<td>".explode("/", $r['course_id'])[0];//org
    $body[]="<td><a href='../course/?id=".$r['course_id']."'>".$edxcourse->displayName($r['course_id']);//course
    //$body[]="<td><a href=../course_unit/?id=".$r['module_id'].">".$edxcourse->unitName($r['module_id']);
    $body[]="<td>".$admin->dateRelative($r['modified']);
}

$body[]="</tbody>";
$body[]="</table>";



$foot=[];

$box=new Admin\Box;
$box->type("primary");
$box->icon('fa fa-file');
$box->title('Recent activity');
$box->body($body);
//$box->foot($foot);
echo $box->html();
