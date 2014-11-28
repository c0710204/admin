<?php
// User progression - ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxApp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

echo $admin->ctrl();


switch($_POST['do']){
    
    default:
        echo "unknow action : ".$_POST['do'];
        break;
}

die("error");