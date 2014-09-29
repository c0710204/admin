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
$htm[]="<pre>".print_r($group, true)."</pre>";

$foot=[];
$foot[]="<a href='../groups/' class='btn btn-default'> Groups</a>";
$foot[]="<a href=# id='btndel' class='btn btn-default pull-right'><i class='fa fa-eraser'></i> Delete group</a>";

echo $box->html($htm, $foot);
