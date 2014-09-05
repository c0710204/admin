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
$filter=['_id.course' => 'toto', '_id.org'=>'org', '_id.category'=>'about', '_id.name'=>'overview'];

$filename='logo64.png';

$ID=[];
$ID['_id']['tag']='c4x';
$ID['_id']['org']='mylgd';
$ID['_id']['course']='my69';
$ID['_id']['category']='asset';
$ID['_id']['name']=basename($filename);
$ID['_id']['revision']='';
$ID['contentType']='image/png';
$ID['displayname']=basename($filename);


$id = $gridfs->storeFile($filename, $ID, array( 'safe' => true ));//add extra (id) here
//$id = $gridfs->storeFile('logo.png', array('contentType' => 'plain/text'), array( 'safe' => true ));//add extra (id) here

echo "id: ";
var_dump($id);

echo "<hr />";
echo "re: ";

$gridfsFile = $gridfs->get($id);
//var_dump($gridfsFile->file);
print_r($gridfsFile->file);
