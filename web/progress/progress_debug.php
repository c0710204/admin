<?php
// progress debug


$progressdata=$edxApp->progressData($course_id, [$user_id])[$user_id];
$rcu=$edxCourse->releventCourseUnits($course_id);

$body=[];
$body[]="<pre>edxApp->progressData ".print_r($progressdata,true)."</pre>";

//echo "<li>".count($progressdata)." progressdata<br />";//print_r($data);
//echo "<li>".count($rcu)." rcu<br />";//print_r($data);

$body[]="<pre>edxCourse->releventCourseUnits ".print_r($rcu,true)."</pre>";


// super quick computation
$pct=count($progressdata)/count($rcu)*100;
//echo "<li>quick progress ".round($pct)."%";

$box=new Admin\SolidBox;
$box->icon("fa fa-bug");
$box->title("Progress debug");

echo $box->html($body);