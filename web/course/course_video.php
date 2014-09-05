<?php
//course video
$body=[];
$video=$edxCourse->video();
$youtubeid=$edxCourse->youtubeid();

$footer=[];
$footer[]="<button class='btn btn-primary' onclick='setVideo()'>Set video</button>";

if ($video) {
    $body[]=$video;
    $footer[]="&nbsp;";
    $footer[]="<button class='btn pull-right' onclick='trashVideo()'><i class='fa fa-trash-o'></i></button>";
} else {
    $body="<pre>No video</pre>";
}

$footer[]="<span id='moreVideo'></span>";

$small="<small><a href='https://www.youtube.com/watch?v=$youtubeid' target=_blank>$youtubeid</a></small>";

$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-video-camera');
$box->title("Video $small");
$box->body($body);
$box->footer($footer);//, 'collapse');
echo $box->html();

//echo "Course metadata : ";
//$meta=$edxapp->course_metadata($org, $course);
//echo "<pre>".print_r($meta, true)."</pre>";
?>
<script>
function setVideo(){
    var youtubeid=prompt("Please set youtube video code");
    if(!youtubeid)return false;
    var p={
        'do':'updateVideo',
        'course_id':$('#course_id').val(),
        'youtubeid':youtubeid
    };

    $('#moreVideo').html("Saving...");
    $('#moreVideo').load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

function trashVideo(){
    if(!confirm("Delete this youtube video link ?"))return false;
    var p={
        'do':'updateVideo',
        'course_id':$('#course_id').val(),
        'youtubeid':''
    };

    $('#moreVideo').html("Deleting...");
    $('#moreVideo').load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

</script>