<?php
// course unit - user log

$body=$foot=[];
//$body[]=$unit_id;


$db=$admin->db();
$sql="SELECT id, student_id, state, modified, grade, max_grade FROM edxapp.courseware_studentmodule WHERE module_id='$unit_id' ORDER BY modified DESC;";
$q=$db->query($sql) or die("<pre>$sql</pre>");

$dat=[];
while ($r=$q->fetch()) {
    $dat[]=$r;
}

//$body[]="<pre>$sql</pre>";
//$body[]=count($dat)." records";

if (count($dat)) {

    $body[]="<table class='table table-condensed table-striped'>";
    $body[]="<thead>";
    $body[]="<th>#</th>";
    $body[]="<th>Student</th>";
    $body[]="<th>State</th>";
    $body[]="<th>Grade</th>";
    $body[]="<th width=130>Modified</th>";
    $body[]="</thead>";
    $body[]="<tbody>";
    foreach ($dat as $r) {
        //print_r($r);
        $user=$edxapp->user($r['student_id']);
        $body[]="<tr>";
        $body[]="<td>".$r['id'];
        $body[]="<td><a href='../user/?id=".$r['student_id']."'>".$user['username'];
        $body[]="<td><a href=# title='".$r['state']."'>state</a>";//.$r['state'];
        if (isset($r['grade'])) {
            $grade=$r['grade'].'/'.$r['max_grade'];
        } else {
            $grade='';
        }
        $body[]="<td>$grade</a>";//.$r['state'];
        $body[]="<td>".substr($r['modified'], 0, 10);

    }
    $body[]="</tbody>";
    $body[]="</table>";

} else {
    $body[]= "<pre>No data</pre>";
}


$box=new Admin\Box;
$box->type("primary");
$box->icon('fa fa-list');
$box->title('User log');
$box->body($body);
echo $box->html();
