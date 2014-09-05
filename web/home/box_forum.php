<?php
//<h1>Versions</h1>

$body=[];
$body[]="<h2>Coming soon</h2>";
/*

$body[]="<table>";
$body[]="<thead>";
$body[]="<th>#</th>";
$body[]="<th>#</th>";
$body[]="<th>#</th>";
$body[]="</thead>";
$body[]="<tbody>";

$body[]="</tbody>";
$body[]="</table>";
*/

echo $admin->box("primary", "<a href='../forum/'><i class='fa fa-comments-o'></i></a> Forum activity", $body, []);
