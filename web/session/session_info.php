<?php
// session info
$box=new Admin\SolidBox;
$box->icon("fa fa-bolt");
$box->title("Session <small>$session_id</small>");
$box->type("default");

$body=[];
$body[]="<li>User : <a href='../user/?id=".$S['user_id']."'>".$USR['username']."</a>";
$body[]="<li>Course : ?";
$body[]="<li>Session start: ".$S['date_from'];

$length=(strtotime($S['date_to'])-strtotime($S['date_from']));
$minutes=round($length/60);

$body[]="<li>Session length : ".$minutes." minutes";
$body[]="<li>".count($data)." records";

//$body[]="$session_id";
$foot="<a href='../sessions' class='btn btn-default'><i class='fa fa-arrow-left'></i> Sessions</a>";
echo $box->html($body,$foot);
