<?php
// course unit - box info

//$unit=$edxCourse->unit($unit_id);
$metadata=$unit['metadata'];

$body=[];

$youtube_id=$metadata['youtube_id_1_0'];
$metadata['html5_sources'];

//$body[]=$youtube_id."<br />";
//$body[]=$metadata['sub']."<br />";

if ($youtube_id) {
    //$body[]="<iframe width=100% height=315 src='//www.youtube.com/embed/".$youtube_id."' frameborder=0 allowfullscreen></iframe>";
    $url="//www.youtube.com/embed/".$youtube_id;
    $body[]="<i class='fa fa-youtube'></i> <a href='$url'>Youtube ".basename($url)."</a><br />";
}

if ($metadata['html5_sources']) {

    foreach ($metadata['html5_sources'] as $url) {
        $body[]="<i class='fa fa-film'></i> <a href='$url'>".basename($url)."</a><br />";
    }
}

if (isset($metadata['download_video'])) {
    $body[]="<a href=# class='btn btn-primary'>Video download enabled</a>";
}

$foot=[];
//$foot[]="<button class='btn'><i class='fa fa-save'></i> Save</button>";
$small="<small><a href='https://www.youtube.com/watch?v=$youtube_id' target=_blank>$youtube_id</a></small>";

$box=new Admin\SolidBox;
$box->title("Video $small");
$box->icon("fa fa-camera");
$box->body($body);
echo $box->html();
