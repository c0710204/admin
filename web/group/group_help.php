<?php
// show some group info

$box=new Admin\SolidBox;
$box->title("Help");

$htm=[];

switch($group['type']){

    default:
        $htm[]="<pre>";
        $htm[]="http://edx.readthedocs.org/projects/edx-partner-course-staff/en/latest/releasing_course/beta_testing.html";
        $htm[]="</pre>";
        break;
}


echo $box->html($htm);

