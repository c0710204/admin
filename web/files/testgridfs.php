<?php
// admin :: test file
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Files");

$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();

echo $admin->printPrivate();

?>
<section class="content-header">
    <h1><i class='fa fa-folder'></i> Test Files <small></small></h1>
</section>

<!-- Main content -->
<section class="content">
<?php

echo "<pre>";
/*
$collection = $course->mgdb->edxapp->fs->files;
$r=$collection->findOne(['_id.category'=>'asset']);//"_id.course"=>$coursename, '_id.org'=>$org,
var_dump($r);
*/


//get distinct _id.contentType
/*
$d=$gridfs->distinct('_id.category');
foreach($d as $dd){
	print_r($dd);
}
exit;
*/

//list all files
$files=$gridfs->find(['_id.category'=>'thumbnail']);
foreach($files as $f){
	print_r($f);
}

