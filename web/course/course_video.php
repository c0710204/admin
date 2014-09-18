<?php
//course video
$body=[];
$video=$edxCourse->video($course_id);
$youtubeid=$edxCourse->youtubeid($course_id);

$footer=[];
$footer[]="<button class='btn btn-primary' onclick='setVideo()'>Set video</button>";

if ($video) {
    $body[]=$video;
    $footer[]="&nbsp;";
    $footer[]="<button class='btn pull-right' onclick='trashVideo()'><i class='fa fa-trash-o'></i></button>";
    $small="<small><a href='https://www.youtube.com/watch?v=$youtubeid' target=_blank>$youtubeid</a></small>";
} else {
    $body="<pre>No video</pre>";
    $small="<small>No video</small>";
}

$footer[]="<span id='moreVideo'></span>";



$box=new Admin\SolidBox;
$box->icon('fa fa-video-camera');
$box->title("Video $small");
$box->body($body);
$box->footer($footer);//, 'collapse');
$box->collapsed(true);//, 'collapse');
echo $box->html();
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