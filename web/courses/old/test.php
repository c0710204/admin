<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;

use Admin\EdxCourse;
$edxcourse = new EdxCourse("../config.json");

echo "<pre>";

/*
$filter=[];
$filter['_id.org']='fbm';
$filter['_id.course']='00';
$filter['_id.category']='course';
//$filter['_id.org']='fbm';
*/


//$edxcourse->course_id("fbm/template/0");
$edxcourse->course_id("fbm/00/0");


$filter=["_id.course"=>'00', '_id.org'=>'fbm', "_id.name"=>"video"];
//$data=$edxcourse->modulestore->remove($filter);die("deleted");
$data=$edxcourse->modulestore->findOne($filter);
print_r($data);
//exit;
/*
$dat=[];
$dat["_id"]["tag"]="i4x";
$dat["_id"]["org"]="fbm";
$dat["_id"]["course"]="00";
$dat["_id"]["category"]="about";
$dat["_id"]["name"]="video";
$dat["_id"]["revision"]=null;
$dat["definition"]["data"]["data"]="youpitralala";

$newId=$edxcourse->modulestore->insert($dat);

print_r($newId);die("test ok?");
*/
$video=$edxcourse->video();
if (!$video) {
    //die("no video");
}
echo htmlentities($video);
echo "\n";

//<iframe width="560" height="315" src="//www.youtube.com/embed/1l6UPe9S45Y?rel=0" frameborder="0" allowfullscreen=""></iframe>
//$edxcourse->insertVideo("Uf0_g8FdmBs");
if ($up=$edxcourse->updateVideo("Uf0_g8FdmBs")) {
    echo "Video updated\n";
    print_r($up);
}

$video=$edxcourse->video();
echo htmlentities($video);


/*
$data=$edxcourse->modulestore->findOne($filter);
//var_dump($data);
$data['metadata']['display_name']='display_name';
print_r($data);

$up=$edxcourse->modulestore->update($filter, $data);

print_r($up);
*/