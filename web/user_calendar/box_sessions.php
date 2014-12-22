<?php
// User calendar
// Box sessions

$sessions=$edxApp->sessions([$USERID])[$USERID];

$box = new Admin\SolidBox;
$box->id("boxleft");
$box->icon("fa fa-bolt");
$box->title(count($sessions)." sessions");



$body=[];
$body[]="<table class='table table-condensed'>";
$body[]="<thead>";
$body[]="<th>Date</th>";
$body[]="<th>Length</th>";
$body[]="</thead>";
$body[]="<tbody>";
foreach($sessions as $k=>$session){
	$body[]="<tr>";
	$body[]="<td><a href='../session/?id=".$session['session']."'>".$session['date_from']."</a>";
	$body[]="<td>Length";
}
$body[]="</tbody>";
$body[]="</table>";

echo $box->html($body,"<a href=# class='btn btn-default'><i class='fa fa-arrow-right'></i> Ok</a>");

