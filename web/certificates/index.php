<?php
//admin :: Certificates
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->printPrivate();

$edxcourse = new EdxCourse();

$sql="SELECT * FROM edxapp.certificates_certificatewhitelist;";
echo "<pre>$sql</pre>";
//$q=

$sql="SELECT * FROM edxapp.certificates_generatedcertificate;";
echo "<pre>$sql</pre>";
