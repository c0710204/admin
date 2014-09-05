<?php
//course class test
//
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;


echo "<pre>";
$t=strtotime('2015-06-26');
$t=strtotime('26-06-2014');
die("$t");
//$admin = new AdminLte("../config.json");
//$admin->path("../");
//echo $admin->printPrivate();

$org = 'mylgd';
$name='1';

$course= new EdxCourse("../config.json", $org, $name);
if ($course->exist()) {
    echo "course $name ok\n";
} else {
    echo "course $name not found\n";
    exit;
}

echo "<li>org : " . $org;
echo "<li>name : " . $name;
echo "<hr />";
echo "<li>display name : " . $course->displayName();
echo "<li>short desc.  : " . $course->shortDescription();
echo "<hr />";
//echo "<li>overview : " . $course->overview() . "\n";
//exit;
//if ($course->updateOverview("This is the new course overview")) {
if ($course->updateDisplayName("New display name")) {
    echo "course updated\n";
} else {
    echo "nope\n";
}

echo "ok\n";

//$edxapp=new EdxApp("../config.json");
//$c=$edxapp->course($org, $name);
$meta=$course->metadata();
echo "metadata:";print_r($meta);
//echo count($c);exit;

//var_dump($meta);
/*
foreach($c as $k => $v){
    print_r($v);
    var_dump($v);
}
*/
