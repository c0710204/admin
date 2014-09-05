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


echo "<pre>";

// 1 get the id of the file to delete
//$id = $gridfs->storeFile('logo.png', array('contentType' => 'plain/text'), array( 'safe' => true ));//add extra (id) here

$filter=['_id.category'=>'thumbnail','_id.name'=>'Screen_Shot_2013-04-16_at_1.43.36_PM.jpg'];
$filter=['md5'=>'a0058e15689e552549cdcb37efa72f81'];//test md5
$file=$gridfs->findOne($filter);

if (!$file) {
    die("File not found");
}

$ID = $file->file['_id'];
echo "ID:";
print_r($ID);



//2 delete the file with the given id
if ($ID) {
    $deleted = $gridfs->delete($ID);
    if ($deleted) {
        echo "file deleted\n";
    } else {
        echo "nope\n";
    }
}
