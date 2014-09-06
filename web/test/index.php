<?php
//admin test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$admin->printPublic();


//$pouet = new Admin\Pouet;
//echo $pouet->test("pouet is test");