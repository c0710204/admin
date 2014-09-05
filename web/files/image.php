<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Files");

$edxapp = new EdxApp("../config.json");


// image
// http://www.php.net/manual/en/mongogridfsfile.getbytes.php



$m = $edxapp->mgdb();
//$images = $m->my_db->getGridFS('images');
$images = $m->edxapp->getGridFS('images');
var_dump($images);

$image = $images->findOne('cursive.png');
var_dump($image);

/*
header('Content-type: image/png;');
$stream = $image->getResource();

while (!feof($stream)) {
    echo fread($stream, 8192);
}
*/
