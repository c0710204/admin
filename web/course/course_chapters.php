<?php
// course structure

$htm=[];
//$htm[]="<pre>$course_id</pre>";

$chapters=$edxCourse->chapters();
$unitCount=$edxCourse->unitCount();

//echo "<li>unitCount=$unitCount;<br />";

if (is_array($chapters) && count($chapters)) {
    $htm[]="<ol>";
    //$htm[]=$chapters;
    foreach ($chapters as $chapter) {
        $htm[]="<li>";
        $htm[]="<a href=../chapter/?unit_id=".$chapter[0].">".$chapter[1]."</a>";
        //<small class='pull-right'>test</small>
        $htm[]="</li>";
    }
    $htm[]="</ol>";
} else {
    $htm[]=new Admin\Callout("danger", "Course error: no chapters");
}

$foot=[];
$foot[]="<a href='../course_structure/?id=$course_id' class='btn btn-default'><i class='fa fa-sitemap'></i> Structure details</a>";

if (is_array($chapters) && count($chapters)) {
    $small="<small>".count($chapters)." chapters</small>";
} else {
    $small="<small>No chapters</small>";
}

$box = new Admin\SolidBox;
$box->title("Course chapters $small");
$box->icon('fa fa-sitemap');
$box->iconUrl("../course_structure/?id=$course_id");//todo here !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$box->body($htm);
$box->footer($foot);
//echo $box("primary", "<i class='fa fa-sitemap'></i> Course structure $small", $htm, $foot);
echo $box->html();
