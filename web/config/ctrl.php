<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");//admin interface
$edxapp = new EdxApp("../config.json");//admin interface

//print_r($_POST);
switch($_POST['do']){

    case 'testPdo':
        //print_r($_POST);
        try {
            $dsn = "mysql:host=".$_POST['host'].";dbname=edxapp";

            $db = new \PDO($dsn, $_POST['user'], $_POST['pass']);
             //echo "dsn=$dsn";
             echo $admin->callout("info", "<i class='fa-thumbs-up'></i> PDO Connection Ok", "$dsn");
        } catch (PDOException $e) {
            //echo "<li>" . $e->getMessage();
            echo $admin->callout("danger", "PDO Connection error", $e->getMessage());
        }
        break;

    case 'testMongo':
        //print_r($_POST);

        if (!$_POST['port']) {
            $_POST['port']='27017';//default port
        }

        $str="mongodb://".$_POST['host'].":".$_POST['port'];

        if (!$mgdb = new \MongoClient($str)) {
            throw new \Exception('Error: mongo connection');
            echo $admin->callout("danger", "Mongo Connection error", $e->getMessage());
        }

        if (!$mgdb->connected) {
            echo $admin->callout("danger", "Mongo Connection error", $e->getMessage());
        } else {
            //$this->modulestore=$this->mgdb->edxapp->modulestore;
            echo $admin->callout("info", "<i class='fa-thumbs-o-up'></i> MongoDB Connection Ok", "Smooth");//ok
        }
        break;

    default:
        die("Error : Unknow action : " . $_POST['do']);
        break;
}

exit;
