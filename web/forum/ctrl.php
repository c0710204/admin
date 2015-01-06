<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxForum;

$admin = new AdminLte();
$admin->ctrl();

$edxApp = new Admin\EdxApp();
$forum = new Admin\EdxForum();

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
        
        $contents=$forum->threads($_POST['org']);
        $n=$contents->count();
        $DAT=[];
        foreach ($contents as $r) {
            $R=[];
            $R['id']=$r['_id']->{'$id'};
            $R['org']=explode("/", $r['course_id'])[0];
            
            if ($_POST['course_id'] && $_POST['course_id']<>$r['course_id']) {
                continue;
            }
            
            $R['course_id']=$r['course_id'];

            $courseName=$edxApp->courseName($r['course_id']);
            if (preg_match("/not found/i", $courseName)) {
                $R['courseName']='';
            } else {
                $R['courseName']=ucfirst(strtolower($courseName));
            }

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
