<?php
// chapters progression
// http://almsaeedstudio.com/AdminLTE/pages/tables/simple.html

$body=$foot=[];

$body[]="<table class='table table-condensed table-bordered'>";

$chapters=$edxCourse->chapters($course_id);

if (is_array($chapters) && count($chapters)) {
    $body[]="<thead>";
    $body[]="<th width=30>#</th>";
    $body[]="<th>Chapter name</th>";
    $body[]="<th>Progress</th>";
    $body[]="<th></th>";
    $body[]="</thead>";
    $body[]="<tbody>";
    $i=1;
    foreach ($chapters as $chapter) {
        $body[]="<tr>";
        $body[]="<td>$i.</td>";
        $body[]="<td><a href=../course_chapter/?unit_id=".$chapter[0].">".$chapter[1]."</a>";
        $body[]="<td>";
        $body[]="<div class='progress xs'>";
        $body[]="<div class='progress-bar progress-bar-green' style='width: 50%;'></div>";
        $body[]="</div>";
        $body[]="<td><span class='badge bg-green'>50%</span>";
        $body[]="</tr>";
        $i++;
    }
    $body[]="</tbody>";
    $body[]="<tfoot>";
    $body[]="<tr>";
    $body[]="<td>";
    $body[]="<td>Progress total";
    $body[]="<td>";
    $body[]="<div class='progress xs'>";
    $body[]="<div class='progress-bar progress-bar-red' style='width: 10%;'></div>";
    $body[]="</div>";
    
    $body[]="<td><span class='badge bg-red'>10%</span>";
    $body[]="</tfoot>";
    //$body[]='</div>';
}

$body[]='</table>';


$box=new Admin\SolidBox;
//$box->type("danger");
$box->title($edxapp->courseName($course_id)." <small>test</small>");
$box->icon('fa fa-book');
echo $box->html($body, $footer);

