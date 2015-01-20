<?php
// ctrl
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->ctrl();//check authentication

$edxApp=new Admin\EdxApp();
$edxCrm=new Admin\EdxCrm();


switch (@$_POST['do']) {

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


    case 'delete'://delete one recordx
        $id =$_POST['id']*1;
        $sql="DELETE FROM edxcrm.student_bulk_import WHERE sbi_id=$id;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die('getData();');//reload
        exit;

    case 'getRecord':
        
        $id =$_POST['id']*1;
        
        $sql="SELECT * FROM edxcrm.student_bulk_import WHERE sbi_id=$id;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        
        $r=$q->fetch(PDO::FETCH_ASSOC);
        if($r){
            echo "$('#sbi_id').val($id);\n";
            echo "$('#email').val('".$r['sbi_email']."');\n";
            echo "$('#login').val('".$r['sbi_login']."');\n";
            echo "$('#firstname').val('".$r['sbi_first_name']."');\n";
            echo "$('#lastname').val('".$r['sbi_last_name']."');\n";
        }
        exit;
        break;

    
    case 'list':// get the list of temporary users

        $sql="SELECT * FROM edxcrm.student_bulk_import WHERE 1;";// LIMIT 300
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        //echo "$sql";
        $list=[];
        while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
            
            // emails and logins must be checked before import !!!
            $testmail=$edxApp->userEmailId($r['sbi_email']);
            $testname=$edxApp->usernameId($r['sbi_login']);
            
            if($testmail)$r['warning_mail']=$testmail;
            if($testname)$r['warning_name']=$testname;
            

            if(!$r['sbi_first_name'])$r['sbi_first_name']='';
            if(!$r['sbi_last_name'])$r['sbi_last_name']='';
            $list[]=$r;
        }
        echo json_encode($list);
        exit;
        break;

    case 'saveSbi':
        
        //print_r($_POST);
        $sbi_id=$_POST['sbi_id']*1;
        $email=trim($_POST['email']);
        $login=trim($_POST['login']);
        $first_name=trim($_POST['firstname']);
        $last_name=trim($_POST['lastname']);

        $sql ="UPDATE edxcrm.student_bulk_import SET ";
        $sql.="sbi_email=".$admin->db()->quote($email).", ";
        $sql.="sbi_login=".$admin->db()->quote($login).", ";
        $sql.="sbi_first_name=".$admin->db()->quote($first_name).", ";
        $sql.="sbi_last_name=".$admin->db()->quote($last_name)." ";
        $sql.="WHERE sbi_id=$sbi_id LIMIT 1;";
        
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo()."<hr >$sql", true));

        die('getData();');
        exit;
        break;

    case 'confirmEnroll':
        
        //print_r($_POST);
        
        $course_id=trim($_POST['course_id']);
        $sql = "UPDATE edxcrm.student_bulk_import SET sbi_course_id=".$admin->db()->quote($course_id)." WHERE 1;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        
        die("Done");
        break;

    case 'clearList'://clear tmp user list
        //print_r($_POST);
        $sql="DELETE FROM edxcrm.student_bulk_import WHERE 1;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die('getData();');
        break;

    case 'import':
        $sql="SELECT * FROM edxcrm.student_bulk_import WHERE 1;";// LIMIT 300
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        while($r=$q->fetch(PDO::FETCH_ASSOC)){
            //import $r
        }
        break;

    default:
        die("Ctrl error: unknow action ".print_r($_POST,true));
        break;
}


die("Error :(");
