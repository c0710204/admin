<?php
// group info
if (!$group=$edxApp->group($group_id)) {
    echo "<pre>Error : group #$group_id not found</pre>";
    die("<a href='../groups/' class='btn btn-default'>Groups</a>");
}

$box=new Admin\SolidBox;
$box->title("Group : $group[type]");
$box->icon("fa fa-info");

$htm=[];


// group type
/*
$htm[]='<div class="form-group">';
$htm[]='<label>Type: </label> ';
$htm[]=$group['type'];
//$htm[]='<input type="text" class="form-control" id="displayName" value="'.$group['type'].'">';
$htm[]='</div>';
*/


// group name
$htm[]='<div class="form-group">';
$htm[]='<label>Name</label>';
$htm[]='<input type="text" class="form-control" id="displayName" value="'.$group['name'].'">';
$htm[]='</div>';

// group course
$htm[]='<div class="form-group">';
$htm[]='<label>Course:</label> ';
$htm[]="<a href=#>".$group['course_id']."</a>";
//$htm[]='<input type="text" class="form-control" id="shortDescription" value="'.$group['course_id'].'">';
$htm[]='</div>';


//$htm[]="<pre>".print_r($group, true)."</pre>";

$foot=[];
$foot[]="<a href='../groups/' class='btn btn-default'> Groups</a>";
$foot[]="<a href=# id='btndel' class='btn btn-default pull-right'><i class='fa fa-eraser'></i> Delete group</a>";

echo $box->html($htm, $foot);
