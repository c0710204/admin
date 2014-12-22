<?php
// admin :: Sessions (Edx Sessions)
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->ctrl();

$edxApp = new EdxApp();
$edxCourse = new EdxCourse();


switch ($_POST['do']) {
    
    case 'getList':
    	
    	$WHERE=[];
    	$WHERE[]=1;
    	//print_r($_POST);
    	if (isset($_POST['search'])) {
    		
    		$sql = "SELECT id FROM edxapp.auth_user WHERE username LIKE ".$admin->db()->quote($_POST['search'])." LIMIT 1;";
    		$q = $admin->db()->query($sql) or die("$sql");	
    		
    		while ($r=$q->fetch()) {
    			$WHERE[]='user_id='.$r['id'];
    		}
    	}

    	$WHERE=implode(" AND ", $WHERE);
    	
    	//print_r($_POST);exit;
    	$sql = "SELECT session, user_id, date_from, date_to FROM edxapp.tracking_session WHERE $WHERE ORDER BY date_to DESC LIMIT 30 ;";
    	$q = $admin->db()->query($sql) or die("nope");
    	
    	$dat=[];
    	$users=[];//list of users

    	while ($r=$q->fetch()) {
    		$users[]=$r['user_id'];
    		$dat[]=$r;
    		//$r=$db->query()
    	}
    	
    	$userData=$edxApp->userData($users);
    	//print_r($userData);exit;
    	foreach($dat as $k=>$r){
    		$dat[$k]['username']=$userData[$r['user_id']]['username'];
    	}
    	
    	echo json_encode($dat);
    	break;

    default:
    	die("Error : ".print_r($_POST,true));
        break;
}


// functions