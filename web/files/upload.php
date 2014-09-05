<?php
// admin :: upload file
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");

$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();

echo "<pre>";

//print_r($_POST);
//print_r($_FILES);

$course_id=$_POST['course_id'];
$o=explode("/", $course_id);
$org=$o[0];
$course=$o[1];
$name=$o[2];

if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
} else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["file"]["tmp_name"]."<br />";
}

$filename=$_FILES["file"]["name"];

//$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);


$contentType=$_FILES["file"]["type"];

$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();

// delete previous

//delete previous file if any
$d=$gridfs->remove(['_id.org'=>$org, '_id.course'=>$course, '_id.name'=>basename($filename)]);
if ($d) {
    echo "Previous file deleted!\n";
}






//if it's a picture, generate a thumbnail first
if (preg_match("/png|jpe?g/i", $contentType)) {
    echo "<li>Thumbnail generation!\n";
    $ID=[];
    $ID['_id']['tag']='c4x';
    $ID['_id']['org']=$org;
    $ID['_id']['course']=$course;
    $ID['_id']['category']='thumbnail';
    $ID['_id']['name']=basename($filename);
    $ID['_id']['revision']='';
    $ID['filename']='/c4x/'.$org.'/'.$course.'/thumbnail/'.$filename;
    $ID['contentType']=$contentType;
    $ID['displayname']=basename($filename);
    $ID['thumbnail_location']='';
    $ID['import_path']='';
    $ID['locked']=false;
    // storeFile
    $id = $gridfs->storeFile($_FILES["file"]["tmp_name"], $ID);//add extra (id) here
}





$ID=[];
$ID['_id']['tag']='c4x';
$ID['_id']['org']=$org;
$ID['_id']['course']=$course;
$ID['_id']['category']='asset';
$ID['_id']['name']=basename($filename);
$ID['_id']['revision']='';
$ID['filename']='/c4x/'.$org.'/'.$course.'/asset/'.$filename;
$ID['contentType']=$contentType;
$ID['displayname']=basename($filename);
$ID['import_path']='';
$ID['locked']=false;
$ID['thumbnail_location'][]='c4x';
$ID['thumbnail_location'][]=$org;
$ID['thumbnail_location'][]=$course;
$ID['thumbnail_location'][]='thumbnail';
$ID['thumbnail_location'][]=basename($filename);
$ID['thumbnail_location'][]='';

// storeFile
$id = $gridfs->storeFile($_FILES["file"]["tmp_name"], $ID);//add extra (id) here





/*
$ID['thumbnail_location']=[];
$ID['thumbnail_location'][]='c4x';
$ID['thumbnail_location'][]=$_POST['org'];
$ID['thumbnail_location'][]=$_POST['coursename'];
$ID['thumbnail_location'][]='thumbnail';
$ID['thumbnail_location'][]=basename($filename);
$ID['thumbnail_location'][]='';
*/




// Here we must also create the thumbnail (128px wide)!!!!


//$gridfsFile = $gridfs->get($id);
//var_dump($gridfsFile->file);

//echo "<script>parent.location.href='index.php?course_id=$course_id';</script>";
die("ok\n");
