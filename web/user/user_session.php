<?php
// user sessions
// echo __FILE__;
// var_dump($sessions);exit;

$body=[];
//$body[]="<pre>".print_r($sessions,true)."</pre>";
$body[]="<table class='table table-condensed'>";
$body[]="<thead>";
//$body[]="<th>Sess";
$body[]="<th>Session start";
$body[]="<th>Session start";
$body[]="<th>Length";
$body[]="</thead>";

//echo "<pre>".print_r($sessions,true)."</pre>";

foreach ($user_sessions as $session) {
    
    //var_dump($v);
    //$time=$edxApp->session_time($session);
    //print_r($session);exit;
    //continue;
    $session_id=$session['session'];
    
    $body[]="<tr>";
    $body[]="<td>";
    $body[]="<a href='../session/?id=$session_id'>";

    $body[]=date("D d M Y ",strtotime($session['date_from'])) . "</a>";
    $body[]="<td>".substr($session['date_from'],0,16);
    //$body[]="<td>".$session['date_to'];
    $length=strtotime($session['date_to']) - strtotime($session['date_from']);
    $minutes=round($length/60);
    $body[]="<td>".$minutes." min";
}
//$body[]="</table>";
$body[]="</table>";



$box=new Admin\Box;
$box->id("boxusersessiom");
$box->icon("fa fa-bolt");
$box->type("primary");
$box->title("Sessions");
//$box->loading(true);
$foot="<a href='../user_calendar/?user_id=$USERID' class='btn btn-default'><i class='fa fa-calendar'></i> Calendar</a>";
echo $box->html($body,$foot);


