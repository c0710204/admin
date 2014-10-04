<?php
//group controller
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$edxApp = new Admin\EdxApp();
$admin->ctrl();


switch($_POST['do']){
    

    case 'delete':// delete group completely, maybe we shouldnt allow that
        //print_r($_POST);
        if ($edxApp->groupDelete($_POST['group_id'])) {
            die("document.location.href='../groups/';");
            //die("Deleted");
        }
        die("Error");
        break;


    case 'delUser':
        //print_r($_POST);
        if ($edxApp->userGroupDel($_POST['id'])) {
            die("document.location.href='?id=".$_POST['group_id']."';");
        }
        break;


    case 'addUser':// Add a user to edxapp.auth_user_groups
        //print_r($_POST);
        if ($edxApp->userGroupAddUser($_POST['group_id'], $_POST['user_id'])) {
            die("document.location.href='?id=".$_POST['group_id']."';");
        }
        die('error');
        break;


    default:
        die('Unknow action :'.$_POST['do']);
}

die("Ctrl error");
