<?php
// box students
$box=new Admin\SolidBox();
$box->id('boxStudents');
$box->icon('fa fa-users');
$box->title("Students");

$id=$_GET['id'];

$sql="SELECT * FROM edxcrm.company_students WHERE cs_company=$id;";
$admin->db()->query($sql) or die("error : $sql");


//$body="<pre>List of students</pre>";
$body=[];
$body[]="<table class='table table-condensed'>";
$body[]="<thead>";
$body[]="<th>#</th>";
$body[]="<th>a</th>";
$body[]="<th>b</th>";
$body[]="<th>c</th>";
$body[]="</thead>";

$body[]="</table>";


echo $box->html($body,"footer");
