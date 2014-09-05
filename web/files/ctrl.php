<?php
//admin :: file ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
//use Admin\EdxCourse;
//use Admin\MongoDatabase;

$admin = new AdminLte("../config.json");
$admin->ctrl();//check authentication

//echo "<pre>";
//$mongo=new MongoDatabase("../config.json");
$edxapp=new EdxApp("../config.json");

if (!$edxapp->connected()) {
    die("No mongodb connection\n");
}

/*
$files = $edxapp->mgdb()->edxapp->fs->files;
$r=$files->find(['_id.category'=>'asset']);
foreach($r as $f){
    print_r($f);
}
*/
//echo "ok";exit;

switch($_POST['do']) {

    case 'delete':
        //print_r($_POST);
        $gridfs = $edxapp->mgdb()->edxapp->getGridFS();
        $file=$gridfs->findOne(['md5'=>$_POST['md5']]);
        if (!$file) {
            die("File not found");
        } else {
            $ID = $file->file['_id'];
            //echo "ID:";print_r($ID);
            $deleted = $gridfs->delete($ID);
            //die("???");
            die("document.location.href='?';");//course_id=".$_POST['course_id']."
        }
        break;


    case 'find':

        //print_r($_POST);
        //$filter=['_id.category'=>'asset'];//"_id.course"=>$coursename, '_id.org'=>$org,
        $filter=[];//"_id.course"=>$coursename, '_id.org'=>$org,
        $filter['_id.category']='asset';

        if ($_POST['course_id']) {
            $o=explode("/",$_POST['course_id']);
            $filter['_id.org']=$o[0];
            $filter['_id.course']=$o[1];
        }

        if ($_POST['contentType']) {
            $filter['contentType']=$_POST['contentType'];
        }

        if ($_POST['filename']) {
            $filter['_id.name']="exam_x250.png";//ok
            $filter['_id.name']="/.*m.*/";//ok
            $filter['_id.name']= array('$regex' => $_POST['filename'], '$options' => 'i');
        }

        //"_id.course"=>$coursename, '_id.org'=>$org,
        $exview=['import_path'=>0, 'uploadDate'=>0,'chunkSize'=>0];//'_id'=>0, 'thumbnail_location'=>0,'locked'=>0
        $files = $edxapp->mgdb()->edxapp->fs->files;
        $r=$files->find($filter, $exview)->limit(30);

        $DAT=[];
        foreach ($r as $v) {
            $DAT[]=$v;
        }

        echo json_encode($DAT);

        exit;
        break;

    case 'filetypes'://get the list of filetypes
        $ops = ['$group'=>['_id'=>['course'=> '$_id.course', 'org'=> '$_id.org']]];
        $courses = $this->modulestore->aggregate($ops);
        break;

    case 'info'://to replace file_info.php
        print_r($_POST);
        $files = $edxapp->mgdb()->edxapp->fs->files;
        $filter=['_id.org'=>$_POST['org'], '_id.course'=>$_POST['course'], '_id.name'=>$_POST['name']];
        $r=$files->find($filter);//
        print_r($r);
        exit;
        break;

    default:
        die("Error");
}

die("File ctrl error");
