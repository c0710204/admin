<?php
// admin canvas
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte();
$admin->ctrl();

$canvas=new Admin\Canvas();

switch ($_POST['do']) {


    case 'connect':
        //print_r($_POST);
        $_SESSION['canvas']['host']=$_POST['host'];
        $_SESSION['canvas']['database']=$_POST['database'];
        $_SESSION['canvas']['user']=$_POST['user'];
        $_SESSION['canvas']['pass']=$_POST['pass'];
        

        if ($canvas->dbtest()) {
            //connected;
            $_SESSION['canvas']['connected']=true;
        } else {
            //alert('nope');
            $_SESSION['canvas']['connected']=false;
        }

        echo "document.location.href='?';";
        exit;
        break;

    default:
        die('Error : unknow action');
}

die("Ctrl Error");
