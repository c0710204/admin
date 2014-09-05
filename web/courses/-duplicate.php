<?php
//admin :: copy course
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\EdxCourse;

$edxcourse = new EdxCourse("../config.json");
echo "<pre>";


//source
$filter=[];
$filter['_id.course']='00';
$filter['_id.org'] = 'fbm';


$neworg='xxx';
$newcourse='xtremcourse';

$gridfs = $edxcourse->mgdb->edxapp->getGridFS();


$files=$gridfs->find($filter);



foreach ($files as $file) {
    //$dat=$file->file;

    //$file->file["_id"]['org']=$neworg;
    //$file->file["_id"]['course']=$newcourse;

    //print_r($file->file);

    //$ID = $file->file['_id'];
    //$gridfs->save($file);
    echo "save()\n";
}

die('ok');

/*
$data=$edxcourse->mgdb->edxapp->modulestore->find($filter);
$rec=0;
foreach ($data as $dat) {
    $rec++;
    //print_r($dat['_id']);
    $dat["_id"]['org']=$neworg;
    $dat["_id"]['course']=$newcourse;
    $edxcourse->mgdb->edxapp->modulestore->insert($dat);
}
*/


echo "<hr />$rec records\n";
echo "<li>done";
