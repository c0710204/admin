<?php
//admin :: CRM company
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();
$edxCrm= new Admin\EdxCrm();

switch($_POST['do']){


    default:
        echo "ctrl error : unknow action";
        print_r($_POST);
        exit;
        break;
}

exit;

die("ctrl error :(");