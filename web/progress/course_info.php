<?php
// course info
$box=new Admin\SolidBox;
$box->icon("fa fa-book");
$box->title("Course info");
$courseName=$edxCourse->displayName($course_id);
$courseName=ucfirst(strtolower($courseName));

$body=[];
//$body[]=ucfirst(strtolower($courseName));
//$body[]=" - <a href='../course/?id=$course_id'>$course_id</a>";
$body[]="Org : ".explode("/",$course_id)[0]."<br />";
$body[]="<a href='../course/?id=$course_id'>$courseName</a>";

echo $box->html($body);
