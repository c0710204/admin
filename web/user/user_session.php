<?php
// user sessions
// echo __FILE__;
// var_dump($sessions);exit;

$body=[];

if (count($user_sessions)) {

    $body[]="<table class='table table-condensed'>";
    $body[]="<thead>";
    $body[]="<th>Session start";
    $body[]="<th>Session start";
    $body[]="<th>Length";
    $body[]="</thead>";
    //echo "<pre>".print_r($sessions,true)."</pre>";
    $body[]="<tbody>";
    foreach ($user_sessions as $session) {
        
        $session_id=$session['session'];
        
        $body[]="<tr>";
        $body[]="<td>";
        $body[]="<a href='../session/?id=$session_id'>";
        $body[]=date("D d M Y ",strtotime($session['date_from'])) . "</a>";
        $body[]="<td>".substr($session['date_from'],0,16);
        $length=strtotime($session['date_to']) - strtotime($session['date_from']);
        $minutes=round($length/60);
        $body[]="<td>".$minutes." min";
    }
    $body[]="</tbody>";
    $body[]="</table>";
} else {
    $body[]="<i class='fa fa-warning' style='color:c00'></i> No session data";
}





$box=new Admin\Box;
$box->id("boxusersessiom");
$box->icon("fa fa-bolt");
$box->type("primary");
$box->title("Sessions");
//$box->loading(true);
$foot="<a href='../user_calendar/?user_id=$USERID' class='btn btn-default'><i class='fa fa-calendar'></i> User calendar</a>";
echo $box->html($body,$foot);


