<?php
// test mysql
echo "<pre>";

$host = "192.168.33.10";
$user = "root";

mysql_connect($host, $user) or die(mysql_error());

die("mysql connection to $host with user $user ok");
