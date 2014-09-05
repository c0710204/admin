<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxForum;

$admin = new AdminLte();
$admin->ctrl();

$forum = new edxForum();

//print_r($_POST);

switch($_POST['do']){
    
    
    case 'closeThread':
        //print_r($_POST);
        if ($forum->threadClose($_POST['id'], $_POST['status'])) {
            //die("thread changed ok\n");
            die("document.location.href='?id=".$_POST['id']."';");
        }
        die('error');
        break;

    case 'trash'://trash some content
        if ($forum->deleteContent($_POST['id'])) {
            //print_r($_POST);
            die("document.location.href='?id=".$_POST['thread_id']."';");
            //die("Deleted");
        }
        die("Error deleting forum content");
        break;

    case 'trashThread'://delete thread conpletely
        if ($forum->threadDelete($_POST['id'])) {
            die("document.location.href='../forum';");
            //die("Deleted");
        }
        die("Error deleting thread");
        break;


    default:
        die('Unknow action :'.$_POST['do']);
}
