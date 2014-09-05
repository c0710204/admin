<?php
// recent enroll
/*
$db=$admin->db();
$sql="SELECT *  FROM edxapp.student_courseenrollment ORDER BY created DESC LIMIT 5;";
$q=$db->query($sql) or die("<pre>".print_r($db->errorInfo(), true)."</pre>");
*/

$dat=$edxapp->enrollments(5);

$body=[];
$body[]="<table class='table table-condensed'>";
$body[]="<thead>";
//$body[]="<th>#</th>";
$body[]="<th>Username</th>";
$body[]="<th>Org</th>";
$body[]="<th>Course</th>";
$body[]="<th width=150>Date</th>";
$body[]="</thead>";
$body[]="<tbody>";

//while ($r=$q->fetch()) {
foreach ($dat as $r) {
    //print_r($r);
    $class="";

    if (!$r['is_active']) {
        $class="text-muted";
    }

    $body[]="<tr class=$class>";
    $body[]="<td><a href='../user/?id=".$r['user_id']."'>".$edxapp->username($r['user_id']);
    $body[]="<td>".explode("/", $r['course_id'])[0];
    $body[]="<td><a href='../course/?id=".$r['course_id']."'>".$edxcourse->displayName($r['course_id']);
    //$body[]="<td>".$r['created'];
    $body[]="<td>".$admin->dateRelative($r['created']);
}

$body[]="</tbody>";
$body[]="</table>";


$foot=[];

$box=new Admin\Box;
$box->type("primary");
$box->icon(['fa fa-user', 'fa fa-angle-right', 'fa fa-book']);
$box->title("Recent enrollments");
$box->body($body);
$box->footer($foot);
echo $box->html();//"primary", "<i class='fa fa-file'></i> Recent enrollments", $body, $foot
