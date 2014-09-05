<?php
// admin :: test file
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");

$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();


//list all thumbnails
$thumbnail=$gridfs->findOne(['_id.category'=>'thumbnail','_id.name'=>'Screen_Shot_2013-04-16_at_1.43.36_PM.jpg']);
echo "<pre>";print_r($thumbnail);
//sexit;

ob_clean();
header('Content-type:'.$thumbnail->file['contentType']);
echo $thumbnail->getBytes();

