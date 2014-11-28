<?php
// course info
$box=new Admin\SolidBox;
$box->icon("fa fa-book");
$box->title("Course info");
$courseName=$edxCourse->displayName($course_id);
echo $box->html("$courseName - <a href='../course/?id=$course_id'>$course_id</a>");
