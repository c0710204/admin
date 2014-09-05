<?php
header('Content-Type: text/html; charset=utf-8');

require __DIR__."/../vendor/autoload.php";

// Uses
use Admin\Curl;
use Admin\UserDjango;

//$db = new DjangoDatabase();



/*
$log = new Monolog\Logger('name');
$log->pushHandler(new Monolog\Handler\StreamHandler('app.log', Monolog\Logger::WARNING));
$log->addWarning('login.php');
*/

$auth = new UserDjango();

echo "<pre>";

$email='honor@example.com';
$password='edx';//a2549c4e69c6751d63a6cff2e46d77d48be9f1f0a206273fbf2db05acc0f7da3

$res = $auth->checkPassword($email, $password);
var_dump($res);


$res = $auth->getUsers();

print_r($res);

echo "login.php";
