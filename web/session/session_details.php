<?php
// Session details

/*
$where=[];
$where[]="modified > '$date_from'";
$where[]="modified < '$date_to'";
$activitydata=$edxApp->studentCourseActivity($user_id, $where);
print_r($activitydata);
*/

//print_r($data);exit;

$body=[];
$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
$body[]="<th></th>";
$body[]="<th>Time</th>";
$body[]="<th>Event</th>";
$body[]="</thead>";

$body[]="<tbody>";

foreach ($data as $r) {

    //print_r($r);exit;
    //if($r['event_type']=='page_close')continue;

    $body[]= "<tr>";
    $body[]= "<td>".event_icon($r['event_type']);//$r['event_type']
    //$body[]= "<td>".str_replace($session_date,'',$r['time']);    
    $body[]= "<td>".substr($r['time'],11,8);    
    


    $json=json_decode($r['event']);
    

    if(isset($json->chapter)){
        $chapters[]=$json->chapter;
    }



    if (isset($json->id)) {
        //$unit_id=str_replace("-", "/", $json->id);
        $unit_ids[]=$json->id;
        
        $body[]= "<td><a href='../course_unit/?id=".$json->id."'>".$json->id;
        
        $unit=$edxCourse->unit($json->id);
        if(preg_match("/\-video-/", $json->id)){
            $videos[]=$json->id;
        }
        
    } elseif($r['event']) {
        $body[]= "<td>".$r['event'];
    } else {
        $body[]= "<td>".$r['event_type'];
    }

} 
$body[]= "</tbody>";
$body[]= "</table>";




$box=new Admin\SolidBox;
$box->title("Session details <small>$session_date</small>");
$box->icon("fa fa-user");
$box->type("default");
echo $box->html($body);


/*
if (count($videos)) {
    $videos=array_unique($videos);
    echo "<pre>Videos:";
    print_r($videos);    
    echo "</pre>";
}

if (count($chapters)) {
    $chapters=array_unique($chapters);
    echo "<pre>Chapters:";
    print_r($chapters);
    echo "</pre>";   
}
*/
/*
$unit_ids=array_unique($unit_ids);
if (count($unit_ids)) {
    $unit_id=$unit_ids[0];
    //echo "$unit_id";
    //$metadata=$edxCourse->metadata($course_id);
    $meta = $edxCourse->metadata($unit_id);
    $displayName=$meta['display_name'];
    echo "<pre>$displayName</pre>";
    //echo "<pre>";print_r($meta);echo "</pre>";
}
*/


/*
if(preg_match("/^i4x-/",$unit_ids[0])){
	$x=explode("-",$unit_ids[0]);	
	$course_id=$x[2]."/".$x[2]."/course";
} elseif(preg_match("/^i4x\//",$unit_ids[0])) {
	$x=explode("/",$unit_ids[0]);	
	$course_id=$x[2]."/".$x[2]."/course";
}
*/

//die("course_id=$course_id");

//$course_name=$edxCourse->displayName($course_id);

/*
echo "<pre>";
foreach($unit_ids as $unit_id){
	$unit=$edxCourse->unit($unit_id);
	echo "$unit_id\n";
	print_r($unit);
}
//print_r($unit_ids);
echo "</pre>";
*/



// Functions
function event_icon($event_type='')
{
    $ico='';
    switch($event_type){
        
        case 'textbook.pdf.chapter.navigated':
        case 'textbook.pdf.display.scaled':
        case 'textbook.pdf.zoom.buttons.changed':
        case 'textbook.pdf.zoom.menu.changed':
        case 'book':
            $ico='fa fa-book';
            break;
        case 'hide_transcript':$ico='fa fa-play';break;
        case 'load_video':$ico='fa fa-eject';break;
        case 'page_close':$ico='fa fa-times';break;
        case 'play_video':$ico='fa fa-play';break;
        case 'pause_video':$ico='fa fa-pause';break;
        case 'seek_video':$ico='fa fa-fast-forward';break;
        case 'stop_video':$ico='fa fa-stop';break;
        
        case 'seq_goto':
        case 'seq_next':
            $ico='fa fa-arrow-right';
            break;

        case 'show_transcript':$ico='fa fa-play';break;
        
        default:
            $ico='fa fa-question';
            break;
    }
    return "<i class='$ico' title='$event_type'></i>";
}
