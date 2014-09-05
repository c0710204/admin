<?php
// mongo file download
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;
use Admin\EdxApp;


header('Content-Description: File Transfer');
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename=Image.png');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize("Image.png"));
ob_clean();
flush();
readfile("Image.png");

