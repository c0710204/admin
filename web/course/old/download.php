<?php
// Download
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;
use Admin\EdxApp;
//use Admin\EdxCourse;

echo "<pre>";
print_r($_GET);

$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();

//ajouter le org et le coursename pour etre plus secure
$file=$gridfs->findOne(['_id.name'=>basename($_GET['filename'])]);
//$file=$gridfs->findOne();//['filename'=>$_GET['filename']]
var_dump($file);

$filename=$file->file['filename'];
$filesize=$file->file['length'];

ob_clean();
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($filename).'"');
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: '.$filesize);
echo $file->getBytes();
