<?php
// Forum Administrators

//echo "<li>$course_id";
$ROLES=$edxapp->clientRoles($course_id);

//echo "<pre>Roles: ".print_r($ROLES, true)."</pre>";




// Administrators
// Administrators
// Administrators
$htm=$foot=[];
$users=$edxapp->clientRoleUsers($ROLES['Administrator']);
if (count($users)) {
    $htm[]="<table class='table table-condensed'>";
    foreach ($users as $user_id) {
        $htm[]="<tr>";
        $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$user_id."'>".ucfirst($edxapp->userName($user_id));

    }
    $htm[]="</table>";
} else {
    $htm[]="<pre>No administrator</pre>";
}

$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title("Forum administrator(s)");
$box->icon("fa fa-users");

// foot -> permissions
$foot[]="<label>Permissions :</label><br />";
foreach ($edxapp->clientPermissions($ROLES['Administrator']) as $k => $v) {
    $v = str_replace("_", " ", ucfirst($v));
    $foot[]="<i class='text-muted'>$v</i> - ";
}
$box->footer($foot);

echo $box->html($htm);




// Moderators
// Moderators
// Moderators
$users=$edxapp->clientRoleUsers($ROLES['Moderator']);

$htm=$foot=[];
if (count($users)) {
    $htm[]="<table class='table table-condensed'>";
    foreach ($users as $user_id) {
        $htm[]="<tr>";
        $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$user_id."'>".ucfirst($edxapp->userName($user_id));

    }
    $htm[]="</table>";
} else {
    $htm[]="<pre>No moderator</pre>";
}

$foot[]="<label>Permissions :</label><br />";
foreach ($edxapp->clientPermissions($ROLES['Moderator']) as $k => $v) {
    $v = str_replace("_", " ", ucfirst($v));
    $foot[]="<i class='text-muted'>$v </i> - ";
}


$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title("Forum moderator(s)");
$box->icon("fa fa-users");
echo $box->html($htm, $foot);




// Teacher Assistants
// Teacher Assistants
// Teacher Assistants

$users=$edxapp->clientRoleUsers($ROLES['Community TA']);

$htm=$foot=[];
if (count($users)) {
    $htm[]="<table class='table table-condensed'>";
    foreach ($users as $user_id) {
        $htm[]="<tr>";
        $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$user_id."'>".ucfirst($edxapp->userName($user_id));
    }
    $htm[]="</table>";
} else {
    $htm[]="<pre>No forum TA</pre>";
}

$box = new Admin\SolidBox;
$box->id("box-threads");
$box->title("Forum TA(s) <small>Teacher assistant</small>");
$box->icon("fa fa-users");

$foot[]="<label>Permissions :</label><br />";
foreach ($edxapp->clientPermissions($ROLES['Community TA']) as $k => $v) {
    $v = str_replace("_", " ", ucfirst($v));
    $foot[]="<i class='text-muted'>$v</i> - ";
}

echo $box->html($htm, $foot);




// Students
// Students
// Students

$users=$edxapp->clientRoleUsers($ROLES['Student']);
$htm=[];

$box = new Admin\SolidBox;
$box->id("box-threads");
$box->title("Students permissions");
$box->icon("fa fa-users");

$foot=[];
foreach ($edxapp->clientPermissions($ROLES['Student']) as $k => $v) {
    $v = str_replace("_", " ", ucfirst($v));
    $foot[]="<i class='text-muted'>$v</i> - ";
}

echo $box->html($foot);
