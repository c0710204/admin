<?php
// calendar user info

$user=$edxApp->user($USERID);
$username=$user['username'];

//$body=print_r($user,true);

$box = new Admin\SolidBox;
$box->id("boxleft");
$box->icon("fa fa-user");
$box->title("$username");

$body[]="Joined : ".substr($user['date_joined'],0,10)."<br />";
$body[]="Last login : ".substr($user['last_login'],0,10)."<br />";

$body[]="<b>Enrollments</b><br />";




$foot="<a href='../user/?id=$USERID' class='btn btn-default'><i class='fa fa-arrow-right'></i> User info</a>";

echo $box->html($body,$foot);
