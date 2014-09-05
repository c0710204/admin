<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

//$admin = new AdminLte("../config.json");

$edxapp = new EdxApp("../config.json");
$gridfs = $edxapp->mgdb()->edxapp->getGridFS();

//print_r($_GET);
//list all thumbnails
$file=$gridfs->findOne(['md5'=>$_GET['md5']]);

$filename=$file->file['filename'];
$filesize=$file->file['length'];

ob_clean();
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($filename).'"'); //<<< Note the " " surrounding the file name
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: '.$filesize);
echo $file->getBytes();
