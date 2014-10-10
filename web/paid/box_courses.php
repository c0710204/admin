<?php
// box courses

$box=new Admin\SolidBox();
$box->title("Courses");
$box->icon("fa fa-book");

$courses=$edxCourse->courses();
print_r($courses);

echo $box->html("Hello world");
