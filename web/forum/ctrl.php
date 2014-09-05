<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxForum;

$admin = new AdminLte();
$admin->ctrl();

$forum = new edxForum();

//print_r($_POST);

switch($_POST['do']){
    
    case 'hide':
        if ($forum->hideContent($_POST['id'])) {
            die("document.location.href='?';");
            //die("Deleted");
        }
        die("Error hiding forum content");
        //print_r($_POST);
        break;

    case 'trash':
        if ($forum->deleteContent($_POST['id'])) {
            die("document.location.href='?';");
            //die("Deleted");
        }
        die("Error deleting forum content");
        break;

    case 'trashThread':
        if ($forum->threadDelete($_POST['id'])) {
            die("document.location.href='?';");
            //die("Deleted");
        }
        die("Error deleting thread");
        break;

    case 'getThreads':

        
        /*
        $filter["org"]=new MongoRegex("/^videox/i");
        $contents = $forum->contents->find($filter, ['_id'=>0,'votes'=>0, 'abuse_flaggers'=>0, 'historical_abuse_flaggers'=>0]);
        $contents->sort(['last_activity_at'=>-1]);
        $n=$contents->count();
        */
        
        $contents=$forum->threads($_POST['org']);
        $n=$contents->count();
        $DAT=[];
        foreach ($contents as $r) {
            //$threads[]=$r;
            //print_r($r);exit;
            $R=[];
            $R['org']=explode("/", $r['course_id'])[0];
            $R['course_id']=$r['course_id'];
            $R['author_id']=$r['author_id'];
            $R['author_username']=ucfirst($r['author_username']);
            $R['title']=$r['title'];
            $R['comment_count']=$r['comment_count'];
            $R['created_at']=date("Y-m-d", $r['created_at']->sec);
            $R['last_activity']=date("Y-m-d", $r['last_activity_at']->sec);
            $DAT[]=$R;
        }
        
        //echo "<pre>";
        //echo "$n"." threads\n";
        echo json_encode($DAT);
        exit;
        break;

    default:
        die('Unknow action :'.$_POST['do']);
}
