<?php

//$chapters=$edxCourse->chapters($course_id);
//print_r($course_id);
//$body=print_r($chapters, true);
$htm[]="<ol>";
//$htm[]=$chapters;
foreach ($edxCourse->chapters($course_id) as $chapter) {
    
    $htm[]="<li>";
    
    if ($_GET['unit_id'] == $chapter[0]) {
        $htm[]="<b>".$chapter[1]."</b>";
    } else {
        $htm[]="<a href=../chapter/?unit_id=".$chapter[0].">".$chapter[1]."</a>";
    }

    //<small class='pull-right'>test</small>
    $htm[]="</li>";
}
$htm[]="</ol>";

$box=new Admin\SolidBox;
$box->title("Chapter location");
echo $box->html($htm);
