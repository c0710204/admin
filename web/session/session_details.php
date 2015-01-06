<?php
// Session details

//print_r($data);exit;

$body=[];
$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
$body[]="<th></th>";
$body[]="<th>Time</th>";
$body[]="<th>Event</th>";
$body[]="</thead>";

$body[]="<tbody>";

$last_time='';
$inactivity=0;// inactivity time in minutes

foreach ($data as $r) {

    //print_r($r);exit;
    //if($r['event_type']=='page_close')continue;
    if ($last_time) {
        $lap=strtotime($last_time)-strtotime($r['time']);
        if ($lap>600) {
            $body[]= "<tr>";
            $body[]= "<td>";
            $body[]= "<td>";
            //$body[]= "<td>Lap : ".$lap;
            $minutes=round($lap/60);
            $inactivity+=$minutes;
            if($minutes>60){
                $body[]= "<td><i class='fa fa-warning' style='color:#c00'> ".round($minutes/60)." hour(s) of inactivity</i>";
            } else {
                $body[]= "<td><i class='fa fa-warning' style='color:#c00'> $minutes minute(s) of inactivity</i>";
            }
            
        }
    }

    $body[]= "<tr>";
    $body[]= "<td>".event_icon($r['event_type']);//$r['event_type']
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
    $last_time=$r['time'];
} 

$body[]= "</tbody>";
$body[]= "</table>";

$length=strtotime($session_end)-strtotime($session_start);
$total_minutes=round($length/60);

$body[]= "<li>Total time : ".round($total_minutes)." minute(s)";
$body[]= "<li>Inactive time : ".round($inactivity)." minute(s)";
$body[]= "<li>Active time : ".round($total_minutes-$inactivity)." minute(s)";


$box=new Admin\SolidBox;
$box->id("sessionDetails");
$box->title("Session details <small>$session_date</small>");
$box->icon("fa fa-user");
$box->type("default");
//$box->loading(true);
echo $box->html($body);




/*
$sql="SELECT * FROM edxapp.courseware_studentmodule WHERE student_id=$user_id ORDER BY modified DESC LIMIT 10;";
$q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
while($r=$q->fetch()){
    print_r($r);
}
*/





// Functions //
// Functions //
// Functions //

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
