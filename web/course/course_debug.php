<?php
// course debug

$HTM=[];
$HTM[]="<pre>";

$HTM[]="metadata: ".print_r($edxCourse->metadata(), true);
//$HTM[]="course:" . print_r($edxCourse->category("course"), true);


/*
$HTM[]=print_r($course, true);
//var_dump($course);
*/

/*
$course=$edxapp->mgdb()->edxapp->modulestore->find(["_id.course"=>$coursename]);//->limit(2);
foreach ($course as $v) {
    $HTM[]=print_r($v, true);
}
*/
$HTM[]="</pre>";


//echo "<pre>".print_r($meta, true)."</pre>";
echo $admin->box("Danger", "<i class='fa fa-bug'></i> Debug", $HTM, [], 'collapse');
