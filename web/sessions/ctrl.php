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
        if(isset($_POST['date_from'])){
            $WHERE[]="date_from>='".$_POST['date_from']."'";
        }

        if(isset($_POST['date_to'])){
            $WHERE[]="date_to>='".$_POST['date_to']."'";
        }

        if (isset($_POST['search']) && preg_match("/^[0-9]+$/",$_POST['search'])) {
            $WHERE[]="user_id='".$_POST['search']."'";
		} else if (isset($_POST['search'])) {
            $OR=[];
            $OR[]="username LIKE '%".$_POST['search']."%'";
            $OR[]="email LIKE '%".$_POST['search']."%'";
            $OR[]="first_name LIKE '%".$_POST['search']."%'";
            $OR[]="last_name LIKE '%".$_POST['search']."%'";
            
            $sql = "SELECT id FROM edxapp.auth_user WHERE (".implode(" OR ", $OR).");";
            $q=$admin->db()->query($sql) or die("<pre>error:$sql</pre>");
            
            $user_filter=[];    
            while($r=$q->fetch(PDO::FETCH_ASSOC))$user_filter[]=$r['id'];
            $WHERE[]="user_id IN (".implode(',', $user_filter).")";
        }

    	$WHERE=implode(" AND ", $WHERE);
    	
    	//print_r($_POST);exit;
    	$LIMIT=$_POST['limit']*1;
    	$sql = "SELECT session, user_id, date_from, date_to FROM edxapp.tracking_session WHERE $WHERE ORDER BY date_to DESC LIMIT $LIMIT;";
    	$q = $admin->db()->query($sql) or die("nope");
    	
    	$dat=[];
    	$users=[];//list of users

    	while ($r=$q->fetch()) {
    		$users[]=$r['user_id'];
    		// compute session length
            $r['length']=(strtotime($r['date_to'])-strtotime($r['date_from']));
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