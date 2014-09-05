<?php
//distnct courses

$ids=$edxapp->courseids();
//print_r($ids);

$body=[];
$body[]="<select id='course_id' class='form-control'>";
foreach ($ids as $course_id) {
    if (@$_GET['id']==$course_id) {
        $body[]="<option value=$course_id selected>$course_id</option>";
    } else {
        $body[]="<option value=$course_id>$course_id</option>";
    }
    
}
$body[]="</select>";
$foot=[];

$box = new Admin\SolidBox;
$box->type("danger");
$box->icon("fa fa-book");
$box->title("Course");
$box->body($body);
echo $box->html();
