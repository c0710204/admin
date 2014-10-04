<?php
// group info
if (!$group=$edxApp->group($group_id)) {
    echo "<pre>Error : group #$group_id not found</pre>";
    die("<a href='../groups/' class='btn btn-default'>Groups</a>");
} else {
    echo "<input type='hidden' id=group_id value='$group_id'>";
}



$htm=[];

// group name
$htm[]='<div class="form-group">';
$htm[]='<label>Name: </label> ';
$htm[]=$group['name'];
$htm[]='</div>';

// group course
$htm[]='<div class="form-group">';
$htm[]='<label>Course:</label> ';

if ($course_id=$edxCourse->exist($group['course_id'])) {
    $htm[]="<a href='../course/?id=".$course_id."'>".$edxApp->courseName($course_id)."</a>";
    //$htm[]="<pre>$course_id</pre>";
} else {
    $htm[]= $group['course_id'];
    $htm[]= " <span class='label label-danger'>Not found</span>";
}

$htm[]='</div>';

if (!$edxCourse->exist($group['course_id'])) {
    $htm[]= "<pre>Warning : Course '".$group['course_id']."' not found</pre>";
}



//$htm[]="<pre>".print_r($group, true)."</pre>";

$foot=[];
$foot[]="<a href='../groups/' class='btn btn-default'><i class='fa fa-arrow-left'></i> Groups</a>";
$foot[]="<a href=# id='btndel' class='btn btn-danger pull-right'><i class='fa fa-times'></i> Delete group</a>";

$box=new Admin\SolidBox;
$box->id("box-info");
$box->title("Group : $group[type]");
$box->icon("fa fa-info");
echo $box->html($htm, $foot);

