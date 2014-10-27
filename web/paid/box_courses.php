<?php
// box courses

$box=new Admin\SolidBox();
$box->title("Courses");
$box->icon("fa fa-book");

$courses=$edxCourse->courses();//get this list of courses

$body=[];
$body[]="<select class='form-control'>";
$body[]="<option>Any</option>";
foreach ($courses as $course_id) {
    $body[]="<option>$course_id</option>";
}
$body[]="</select>";
//print_r($courses);

echo $box->html($body);
