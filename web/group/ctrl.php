<?php
//group controller
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$edxApp = new Admin\EdxApp();
$admin->ctrl();


switch($_POST['do']){
    

    case 'delete':
        //print_r($_POST);
        if ($edxApp->groupDelete($_POST['group_id'])) {
            die("document.location.href='../groups/';");
            //die("Deleted");
        }
        die("Error");
        break;


    default:
        die('Unknow action :'.$_POST['do']);
}
