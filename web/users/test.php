<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");
$edxapp= new EdxApp("../config.json");
echo "<pre>";
$list=$edxapp->userList();
echo json_encode($list);
