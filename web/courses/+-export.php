<?php
//admin :: export course (wip)
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\EdxCourse;

$edxcourse = new EdxCourse("../config.json");

echo "<pre>";
echo "export\n";

$gridfs = $edxcourse->mgdb->edxapp->getGridFS();

// Find image to stream
//$test = $gridfs->findOne("exam_x250.png");//nope
$test = $gridfs->findOne(["_id.name"=>"Logo_Template.jpg"]);//yes
//var_dump($test);



$f=$edxcourse->mgdb->edxapp->fs->chunks->find();
var_dump($f);
foreach ($f as $i) {
    var_dump($i);
}
