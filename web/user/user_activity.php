<?php
// User courses (last) activity
// quite a big box for a small info, so it's replaced by a line in the user info box

$data=$edxApp->studentCourseActivity($USERID, [], 1);
//print_r($data);

$body=[];

if (count($data)) {

    $body[]="<table class='table table-condensed table-striped'>";
    $body[]= "<thead>";
    //$body[]= "<th>Org</th>";
    $body[]= "<th>Course</th>";
    //$body[]= "<th>Module type</th>";
    $body[]= "<th width=150>Datetime</th>";
    $body[]= "</thead>";
    $body[]= "<tbody>";
    foreach ($data as $k => $r) {
        //print_r($r);
        $body[]= "<tr>";
        //$body[]= "<td>".$r['id'];
        //$body[]= "<td>".explode("/", $r['course_id'])[0]."</a>";// org
        $body[]= "<td title='".$r['course_id']."'>";
        $body[]= "<a href='../course_unit/?id=".$r['module_id']."'>".$edxApp->categoryIcon($r['module_type'])."</a>";
        $body[]= " <a href='../course/?id=".$r['course_id']."'>".$edxApp->courseName($r['course_id'])."</a>";

        //$body[]= "<td><a href='../course_unit/?id=".$r['module_id']."''>".$r['module_type'];
        //categoryIcon($r['module_type']);
        //$body[]= "<td>state";
        $r['modified']=str_replace(date("Y-m-d"), "", $r['modified']);
        $body[]= "<td width=150>".substr($r['modified'], 0, 16);

        $body[]= "</tr>";
    }
    $body[]= "</tbody>";
    $body[]= "</table>";

} else {
    $body[]="<pre>No activity</pre>";
}

$footer=[];
$footer[]="<a href='../user_activity/?user_id=$USERID' class='btn btn-primary'><i class='fa fa-clock-o'></i> See all activity</a>";

$box=new Admin\SolidBox;
//$box->type("primary");
$box->title("<i class='fa fa-clock-o'></i> Last activity <small>courseware_studentmodule</small>");
echo $box->html($body, $footer);

?>
<div id='moreAccess'></div>

<script>
</script>