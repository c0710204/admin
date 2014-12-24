<?php
// session digest data
$course_id='';
$course_ids=[];
$unit_ids=[];
$videos=[];
$chapters=[];//pdf chapters
$times=[];

//echo "<li>".count($data);
//print_r($data);

foreach ($data as $r) {
 
    $json=json_decode($r['event']);
    
    $times[]=$r['time'];

    // psa
    if (isset($json->chapter)) {
        $chapters[$json->chapter][]=$json;
    }


    if (isset($json->id)) {
        
        if(preg_match("/^i4x:/",$json->id)){

        }
        /*
        $x=explode("-",$json->id);
        if(count($x)) {
            print_r($r);
            print_r($x);
            $org=$x[1];
            $course=$x[2];
        }
        */   
        $unit_ids[]=$json->id;
        
        $unit=$edxCourse->unit($json->id);
        if (preg_match("/\-video-/", $json->id)) {
            //@unset($json->id);
            $videos[$json->id][]=$json;
        }
    }
}

if(count($unit_ids)){
    if(preg_match("/^i4x-/",$unit_ids[0])){
        $x=explode("-", $unit_ids[0]);    
        $course_id=$x[1].'/'.$x[2].'/course';
    }else{
        $x=explode("/", $unit_ids[0]);
        $course_id=$x[2].'/'.$x[3].'/course';
    }    
}

$session_start=min($times);
$session_end=max($times);
$session_length=(strtotime($session_end)-strtotime($session_start));

/*
function session_digest($data=[])
{
    $digest=[];
    return $digest;
}
*/