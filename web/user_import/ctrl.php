<?php
// ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->ctrl();//check authentication

$edxApp=new Admin\EdxApp();
$edxCrm=new Admin\EdxCrm();



switch ($_POST['do']) {

    case 'addUser':
        
        //print_r($_POST);
        $email=trim($_POST['email']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          die("Invalid email format");
        }

        $password=md5(rand(1,9999999999));
        $password=substr($password,0,8);
        $login=explode('@',$email)[0];

        $sql="INSERT INTO edxcrm.student_bulk_import (sbi_email, sbi_login, sbi_password) VALUES (".$admin->db()->quote($email).",'$login','$password');";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die('getData();');//reload
        exit;


    case 'delete':
        $id =$_POST['id']*1;
        $sql="DELETE FROM edxcrm.student_bulk_import WHERE sbi_id=$id;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die('getData();');//reload
        exit;

    
    case 'list':// get the list of temporary users
        $sql="SELECT * FROM edxcrm.student_bulk_import WHERE 1;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        $list=[];
        while($r=$q->fetch(PDO::FETCH_ASSOC)){
            if(!$r['sbi_first_name'])$r['sbi_first_name']='';
            if(!$r['sbi_last_name'])$r['sbi_last_name']='';
            $list[]=$r;
        }
        echo json_encode($list);
        exit;
        break;

    
    case 'clearList'://clear tmp user list
        //print_r($_POST);
        $sql="DELETE FROM edxcrm.student_bulk_import WHERE 1;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die('ok');
        break;

    default:
        die("Ctrl error: unknow action ".print_r($_POST,true));
        break;
}


die("Error :(");

