<?php
// admin :: file info
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

echo "<pre>";
//print_r($_POST);

$edxapp = new EdxApp("../config.json");

$files = $edxapp->mgdb()->edxapp->fs->files;
//$filter=['_id.course'=>'hecd','_id.name'=>'hecturc.jpg','_id.category'=>'asset'];
//$filter=['md5'=>$_POST['md5']];
$filter=['_id.org'=>$_POST['org'], '_id.course'=>$_POST['course'], '_id.name'=>$_POST['name']];
$r=$files->find($filter);//
//print_r($r);

foreach ($r as $f) {
    print_r($f);
}
