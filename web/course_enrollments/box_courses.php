<?php
// List of courses for quick selection

$enrollCount=$edxApp->enrollCounts();

//echo "<pre>";print_r($enrollCount);echo "</pre>";

$body=[];
$body[]= "<table class='table table-condensed table-striped'>";

$body[]= "<thead>";
$body[]= "<th width=50><i class='fa fa-home'></i> Org</th>";
$body[]= "<th><i class='fa fa-book'></i> Course</th>";
$body[]= "<th>Enroll</th>";
$body[]= "<th width=90><i class='fa fa-calendar'></i> Start</th>";
$body[]= "<th width=90><i class='fa fa-calendar'></i> End</th>";
$body[]= "</thead>";

$body[]= "<tbody>";
foreach ($edxApp->courseids() as $courseId) {
    
    $body[]= "<tr>";
    $body[]= "<td width=50>".explode("/", $courseId)[0];
    $body[]= "<td><a href='?course_id=$courseId'>".ucfirst(strtolower($edxApp->courseName($courseId)))."</a>";
    $body[]= "<td width=50 style='text-align:right'>".@($enrollCount[$courseId]*1);
    $startDate=date("Y-m-d",$edxCourse->startDate($courseId));
    $endDate=date("Y-m-d",$edxCourse->endDate($courseId));
    if(preg_match("/1970/",$startDate))$startDate='';
    if(preg_match("/1970/",$endDate))$endDate='';
    $body[]= "<td>".$startDate;
    $body[]= "<td>".$endDate;

}
$body[]= "</tbody>";
$body[]= "</table>";

$box=new Admin\SolidBox;

$box->title("Select a course");
$box->icon("fa fa-search");

echo $box->html($body,"<i class=text-muted>Select a course</i>");
?>
<script>
$(function(){
	$('table').tablesorter();
});
</script>