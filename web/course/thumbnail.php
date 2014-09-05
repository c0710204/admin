<?php
// course image
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

echo "<pre>";
$edxapp = new EdxApp("../config.json");

$gridfs = $edxapp->mgdb()->edxapp->getGridFS();


//$image=$gridfs->findOne();
//$image=$gridfs->find();//ok
//$image=$gridfs->find(["_id.name"=>"Screen_Shot_2013-04-16_at_1.43.36_PM.png"]);//ok
//$image=$gridfs->find(["_id.name"=>"2001-a-space-odyssey-original.jpeg"]);//ok
$image=$gridfs->find(["_id.category"=>"asset", "_id.name"=>$_GET['name']]);//ok
//$image=$gridfs->find(["_id.name"=>"canvas.png"]);//ok
//$image=$gridfs->find(["_id.org"=>"hec"]);//ok

//var_dump($image);
foreach ($image as $img) {
    //var_dump($img);exit;
    ob_clean();
    header('Content-type:image/jpg');
    echo $img->getBytes();
    exit;
}
exit;


$image=$gridfs->findOne(["filename"=>"/c4x/hec/hecA/thumbnail/Color01.jpg"]);//["_id.name"=>"canvas.png"]
$image->getBytes();

ob_clean();
header('Content-type:image/jpg');
echo $image->getBytes();
