<?php
// Enrollments numbers //

$db=$admin->db();
$sql="SELECT course_id, COUNT(id) as n FROM edxapp.student_courseenrollment GROUP BY course_id ORDER BY n DESC LIMIT 10;";
$q=$db->query($sql) or die("<pre>".print_r($db->errorInfo(), true)."</pre>");

$dat=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $dat[]=$r;
}

$body=[];
$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
$body[]="<th>Org</th>";
$body[]="<th>Course</th>";
$body[]="<th width=80>Enrollments</th>";
$body[]="</thead>";
$body[]="<tbody>";

//while ($r=$q->fetch()) {
foreach ($dat as $r) {
    //print_r($r);
    $class="";
    /*
    if (!$r['is_active']) {
        $class="text-muted";
    }
    */
    $body[]="<tr class=$class>";
    $body[]="<td>".explode("/", $r['course_id'])[0];
    $body[]="<td><a href='../course/?id=".$r['course_id']."'>".$edxcourse->displayName($r['course_id']);
    $body[]="<td style='text-align:right'>".number_format($r['n']);
    //$body[]="<td>".$admin->dateRelative($r['created']);
}

$body[]="</tbody>";
$body[]="</table>";


$foot=[];

$box=new Admin\SolidBox;
$box->type("danger");
$box->icon(['fa fa-user', 'fa fa-angle-right', 'fa fa-book']);
$box->title("Course enrollments");

echo $box->html($body, $foot);//"primary", "<i class='fa fa-file'></i> Recent enrollments", $body, $foot
