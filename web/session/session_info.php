<?php

// session info
$box=new Admin\SolidBox;
$box->icon("fa fa-bolt");
$box->title("Session info");// <small>$session_id</small>
$box->type("danger");

$body=[];
$body[]="<i class='fa fa-user'></i> <a href='../user/?id=$user_id'>$username</a> #$user_id<br />";
//$body[]="<i class='fa fa-envelope'></i> ".$USR['email']."<br />";
$body[]="<i class='fa fa-book'></i> Course<br />";
$body[]="<i class='fa fa-calendar'></i> Session start: ".$S['date_from']."<br />";
//$body[]="<i class='fa fa-calendar'></i> Session end: ".$S['date_to']."<br />";

$length=(strtotime($S['date_to'])-strtotime($S['date_from']));
$minutes=round($length/60);

$body[]="<i class='fa fa-clock-o'></i> ".$minutes." minutes";
//$body[]="<li>".count($data)." records";

//$body[]="$session_id";
$foot=[];
$foot[]="<a href='../sessions' class='btn btn-default'><i class='fa fa-arrow-left'></i> Sessions</a> ";
$foot[]="<a href='../user_calendar/?user_id=$user_id' class='btn btn-default pull-right'><i class='fa fa-calendar'></i> User calendar</a> ";

echo $box->html($body,$foot);


