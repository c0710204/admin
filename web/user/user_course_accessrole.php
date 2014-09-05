<?php
// User courses access role

$courses=$edxApp->studentCourseAccessRole($USERID);


//print_r($courses);
$body=[];

if (count($courses)) {

    $body[]="<table class='table table-condensed table-striped'>";
    $body[]= "<thead>";
    //$body[]= "<th>#</th>";
    $body[]= "<th>org</th>";
    $body[]= "<th>course_id</th>";
    $body[]= "<th>role</th>";
    //$body[]= "<th width=30>x</th>";
    $body[]= "</thead>";
    $body[]= "<tbody>";
    foreach ($courses as $k => $r) {
        //print_r($r);
        $body[]= "<tr>";
        //$body[]= "<td>".$r['id'];
        $body[]= "<td>".$r['org'];
        $body[]= "<td>".$r['course_id'];
        $body[]= "<td>".$r['role'];
        $body[]= "</tr>";
    }
    $body[]= "</tbody>";
    $body[]= "</table>";

} else {
    $body[]=$admin->callout("danger", "No data");
}



$footer=[];


$title="<i class='fa fa-info'></i> Course accessrole <small>student_courseaccessrole</small>";
echo $admin->box("primary", $title, $body, $footer, "collapse");
?>
<div id='moreAccess'></div>

<script>
</script>