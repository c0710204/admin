<?php
// user info ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");
$admin->ctrl();

$edxApp=new EdxApp("../config.json");


switch($_POST['do']){


    case 'enroll':
        //print_r($_POST);
        $id=$edxApp->enroll($_POST['course_id'], $_POST['user_id']);
        if ($id) {
            die("document.location.href='?id=".$_POST['user_id']."'");
        }
        exit;
        break;

    case 'disenroll':
        //print_r($_POST);
        $id=$edxApp->disenroll($_POST['course_id'], $_POST['user_id']);
        if ($id) {
            die("document.location.href='?id=".$_POST['user_id']."'");
        }
        exit;
        break;

    case 'resetPassword':
        //print_r($_POST);
        //$phpseccrypt= new PhpsecCrypt();
        $password=$admin->django->djangopassword($_POST['pass']);
        //$password=$phpseccrypt->djangopass($_POST['user_id'], $_POST['pass']);
        if ($password) {
            $edxApp->updatePassword($_POST['user_id'], $password);
            die("document.location.href='?id=".$_POST['user_id']."'");
        }
        die("error");
        break;

    case 'saveUserInfo':
        //print_r($_POST);
        $edxApp->updateUserProfile($_POST['user_id'], $_POST);
        die("document.location.href='?id=".$_POST['user_id']."';");
        break;

    default:
        break;

}
