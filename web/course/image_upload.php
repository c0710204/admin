<?php
// course image upload
//http://www.php.net/manual/en/mongogridfs.storefile.php

header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");
$edxapp = new EdxApp("../config.json");

echo "<pre>";
print_r($_FILES);
print_r($_POST);

$course_id=$_POST['course_id'];
if (!$course_id) {
	die("error: !course_id");
}

$o=explode("/", $course_id);
$org=$o[0];
$course=$o[1];

if ($_FILES["file"]["error"] > 0) {
    echo "Error: " . $_FILES["file"]["error"] . "<br>";
    exit;
} else {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Stored in: " . $_FILES["file"]["tmp_name"]."<br />";
}



$filename=$_FILES["file"]["name"];
$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);


$contentType=$_FILES["file"]["type"];

//$m = new MongoClient();
//$gridfs = $m->selectDB('test')->getGridFS();
$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();




$ID=[];
$ID['_id']['tag']='c4x';
$ID['_id']['org']=$org;
$ID['_id']['course']=$course;
$ID['_id']['category']='asset';
$ID['_id']['name']=basename($filename);
$ID['_id']['revision']='';

$gridfs->delete($ID);

$ID['filename']='/c4x/'.$org.'/'.$course.'/asset/'.$filename;
$ID['contentType']=$contentType;
$ID['displayname']=basename($filename);
$ID['import_path']='';
$ID['locked']=false;
$ID['thumbnail_location']=[];
$ID['thumbnail_location'][]='c4x';
$ID['thumbnail_location'][]=$org;
$ID['thumbnail_location'][]=$course;
$ID['thumbnail_location'][]='thumbnail';
$ID['thumbnail_location'][]=basename($filename);
$ID['thumbnail_location'][]='';

$id = $gridfs->storeFile($_FILES["file"]["tmp_name"], $ID);//add extra (id) here


// Here we must also create the thumbnail (128px wide)!!!!
$ID['_id']['category'] = 'thumbnail';
$ID['filename'] = '/c4x/'.$org.'/'.$course.'/thumbnail/'.$filename;
$ID['thumbnail_location']=[];
$gridfs->delete($ID);
$id = $gridfs->storeFile($_FILES["file"]["tmp_name"], $ID);//add extra (id) here

$gridfsFile = $gridfs->get($id);
var_dump($gridfsFile->file);
