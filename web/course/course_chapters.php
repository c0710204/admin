<?php
// course structure

$htm=[];
//$htm[]="<pre>$course_id</pre>";

$chapters=$edxCourse->chapters($course_id);
$unitCount=$edxCourse->unitCount($course_id);

//echo "<li>unitCount=$unitCount;<br />";
/*
if (is_array($chapters) && count($chapters)) {
    $htm[]="<ol>";
    //$htm[]=$chapters;
    foreach ($chapters as $chapter) {
        $htm[]="<li>";
        $htm[]="<a href=../course_chapter/?unit_id=".$chapter[0].">".$chapter[1]."</a>";
        $htm[]="<small class='pull-right'>".explode("/", $chapter[0])[5]."</small>";
        $htm[]="</li>";
    }
    $htm[]="</ol>";
} else {
    $htm[]=new Admin\Callout("danger", "Course error: no chapters");
}
*/

if (is_array($chapters) && count($chapters)) {
    $htm[]="<table class='table table-condensed'>";
    $i=0;
    foreach ($chapters as $chapter) {
        $i++;
        $htm[]="<tr>";
        $htm[]="<td>$i";
        $htm[]="<td><a href=../course_chapter/?unit_id=".$chapter[0].">".ucfirst(strtolower($chapter[1]))."</a>";
        //$htm[]="<td><small class='pull-right'>".explode("/", $chapter[0])[5]."</small>";
        //$htm[]="</li>";
    }
    $htm[]="</table>";
} else {
    $htm[]=new Admin\Callout("danger", "Course error: no chapters");
}



$foot=[];
$foot[]="<a href='../course_structure/?id=$course_id' class='btn btn-default'><i class='fa fa-sitemap'></i> Structure details</a>";

if (is_array($chapters) && count($chapters)) {
    $small="<small>".count($chapters)." chapters</small>";
    //print_r($chapters)
} else {
    $small="<small>No chapters</small>";
}

$box = new Admin\SolidBox;
$box->title("Course chapters $small");
$box->icon('fa fa-sitemap');
$box->iconUrl("../course_structure/?id=$course_id");//

$box->body_padding(false);
//$box->collapsed(true);

echo $box->html($htm, $foot);
