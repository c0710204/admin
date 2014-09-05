<?php
// pdo
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../vendor/autoload.php";

use Admin\AdminLte;
use Admin\UserDjango;
//use Admin\Pdo;

$admin = new AdminLte(__DIR__."/config.json");

$admin->printe();
//$UD=new UserDjango();

//echo session_id() . "<br />";
echo "<pre>";

//$PDO = new Pdo(__DIR__."/config.json");
//$db=$PDO->getDatabase();
$db=$admin->db();

$q=$db->query("SELECT * FROM edxapp.auth_user LIMIT 1;");

//var_dump($q);
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    var_dump($r);

}

$sess=$admin->session();
print_r($sess);

print_r($_SESSION);

echo "ok";
