<?php
// Session Overview



$body=[];

if ($course_id) {
    $body[]="<h3><i class='fa fa-book'></i> <a href='../course/?id=$course_id'>".ucfirst(strtolower($edxCourse->displayName($course_id)))."</a></h3>";
}

$body[]="<h3><i class='fa fa-calendar'></i> Session start : $session_start</h3>";
//$body[]="<li>Session end : $session_end";
$body[]="<h3><i class='fa fa-clock-o'></i> ".round($session_length/60)." minutes</h3>";



// Show videos
if (count($videos)) {
    $body[]="<h3>".count($videos) . " videos</h3>";
    $body[]="<table class='table table-condensed'>";
    foreach($videos as $unit_id=>$dat){
        
        $body[]="<tr>";
        $body[]="<td><i class='fa fa-camera'></i> <a href='../course_unit/?id=".$unit_id."'>".$edxCourse->unitName($unit_id)."</a>";
        $parent_id=$edxCourse->unitParent($unit_id);
        $body[]="<td>".$edxCourse->unitName($parent_id);
        //$body[]="<td>".count($dat);
    }
    $body[]="</table>";
}

//$body[]="Videos";
if(count($chapters)){
    $body[]=count($chapters)." chapters<br />";    
}

$foot="<i class=text-muted>".count($data)." record(s)</i>";

//var_dump($data);

$box=new Admin\SolidBox;
$box->title("Session overview");
$box->icon("fa fa-eye");
$box->type("danger");

echo $box->html($body,$foot);


