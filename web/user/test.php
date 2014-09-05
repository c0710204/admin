<?php
//admin :: list users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\Curl;
use Admin\AdminLte;
use Admin\EdxApp;
use Admin\PhpsecCrypt;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("test");

$edxApp = new EdxApp("../config.json");

$phpseccrypt= new PhpsecCrypt();

echo $admin->printPrivate();


$check=$admin->django->checkPassword('jambonbill@gmail.com', 'edx');
var_dump($check);

echo "<pre>";

$password="edx";

$algorithm='sha256';
$iter='10000';
$salt='O1KgfAei96fL';
$digest_size = 32;

echo "<hr />";

//$rehash=base64_encode(PhpsecCrypt::pbkdf2($password, $salt, $iter, $digest_size, $algorithm));
//$rehash=base64_encode($phpseccrypt->pbkdf2($password, $salt, $iter, $digest_size, $algorithm));


//pbkdf2_sha256$10000$O1KgfAei96fL$EioSoXwHMfuay2JJWoD++HV2T21xlze4gKU2uiMnpIY=

$salt = substr(md5(rand(0, 999999)), 0, 12);
echo "<li>salt=$salt\n";

echo $phpseccrypt->djangopass("loto");



/*
function djangopass($pass)
{
    $algorithm='sha256';
    $iter='10000';
    $salt='O1KgfAei96fL';
    $digest_size = 32;
    $b64hash=base64_encode($phpseccrypt->pbkdf2($password, $salt, $iter, $digest_size, $algorithm));

    return "pbkdf2_".$algorithm.'$'.$iter.'$'.$salt.'$'.$b64hash;
}
*/

