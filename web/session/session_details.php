<?php
// Session details
$body=[];
$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
$body[]="<th>Time</th>";
$body[]="<th>Event type</th>";
$body[]="<th>Event</th>";
$body[]="</thead>";

$unit_ids=[];

foreach ($data as $r) {
    
    if(preg_match("/(page_close)/",$r['event_type']))continue;
  	
  	$json=json_decode($r['event']);
    //var_dump($json);exit;
    //
  	if(isset($json->id)){
  		$unit_ids[]=$json->id;
  	}

    $body[]= "<tr>";
    
    //$body[]= "<td>".$r['id']; 
    $body[]= "<td>".str_replace($session_date,'',$r['time']);
    
    //$body[]= "<td>".$r['user_id'];
    $body[]= "<td>".$r['event_type'];
    $body[]= "<td>".$r['event'];
    //print_r($tracking);
} 
$body[]= "</table>";

$box=new Admin\SolidBox;
$box->title("Session details <small>$session_date</small>");
$box->icon("fa fa-user");
$box->type("default");
echo $box->html($body);

$unit_ids=array_unique($unit_ids);

$x=explode("/",$unit_ids[0]);
$course_id=$x[2]."/".$x[2]."/course";
$course_name=$edxCourse->displayName($course_id);
die("course_id=$course_id - $course_name");

echo "<pre>";

foreach($unit_ids as $unit_id){
	$unit=$edxCourse->unit($unit_id);
	echo "$unit_id\n";
	print_r($unit);
}
//print_r($unit_ids);
echo "</pre>";
