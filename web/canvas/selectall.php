<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

// set_time_limit(600);
$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();
$start=time();

//$edxapp= new Admin\EdxApp();
//$edxCourse= new Admin\EdxCourse();
//$edxTest= new Admin\EdxTest();
//$canvas= new Admin\Canvas();

// test script to select all the users from edxapp.auth_user

$sql = "SELECT username FROM edxapp.auth_user WHERE 1;";
$q = $admin->db()->query($sql) or die("error : $sql");
$usernames=[];
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $usernames[]=$r['username'];
}



echo count($usernames) ." usernames in edxapp.auth_user\n";

echo "<li>done in ".(time()-$start)." sec\n";


