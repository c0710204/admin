<?php
// Forum Administrators

//echo "<li>$course_id";
$ROLES=$edxapp->clientRoles($course_id);

//echo "<pre>Roles: ".print_r($ROLES, true)."</pre>";




// Administrators
// Administrators
// Administrators
$htm=[];
$users=$edxapp->clientRoleUsers($ROLES['Administrator']);
//print_r($users);
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($users as $user_id) {
    $htm[]="<tr>";
    $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$user_id."'>".$edxapp->userName($user_id);

}
$htm[]="</table>";

$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title(count($users)." Forum administrator(s)");
$box->icon("fa fa-users");
echo $box->html($htm);




// Moderators
// Moderators
// Moderators
$users=$edxapp->clientRoleUsers($ROLES['Moderator']);

$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($users as $user_id) {
    $htm[]="<tr>";
    $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$user_id."'>".$edxapp->userName($user_id);

}
$htm[]="</table>";

$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title(count($users)." Forum moderator(s)");
$box->icon("fa fa-users");
echo $box->html($htm);




// Teacher Assistants
// Teacher Assistants
// Teacher Assistants
$users=$edxapp->clientRoleUsers($ROLES['Community TA']);

$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($users as $user_id) {
    $htm[]="<tr>";
    $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$user_id."'>".$edxapp->userName($user_id);

}
$htm[]="</table>";

$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title(count($users)." Forum TA(s) <small>Teacher assistant</small>");
$box->icon("fa fa-users");
echo $box->html($htm);
