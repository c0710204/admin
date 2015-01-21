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

    

    case 'getRecord'://edit user record
        
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

        $sql="SELECT * FROM edxcrm.student_bulk_import WHERE sbi_course_id LIKE '';";// LIMIT 300
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        //echo "$sql";
        $list=[];
        while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
            
            // emails and logins must be checked before import !!!
            $testmail=$edxApp->userEmailId($r['sbi_email']);
            $testname=$edxApp->usernameId($r['sbi_login']);
            if($testmail)$r['warning_mail']=$testmail;
            if($testname)$r['warning_name']=$testname;
            //if(!$r['sbi_first_name'])$r['sbi_first_name']='';
            //if(!$r['sbi_last_name'])$r['sbi_last_name']='';
            $list[]=$r;
        }
        echo json_encode($list);
        exit;
        break;

    case 'saveSbi':// update temp user record
        
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

    case 'confirmEnroll':// set desired enrollment for the list of users, before user creation
        //print_r($_POST);
        $course_id=trim($_POST['course_id']);
        $sql = "UPDATE edxcrm.student_bulk_import SET sbi_course_id=".$admin->db()->quote($course_id)." WHERE sbi_course_id LIKE '';";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die("document.location.href='?';");//reload
        break;

    case 'clearList'://clear tmp user list
        //print_r($_POST);
        $sql="DELETE FROM edxcrm.student_bulk_import WHERE 1;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        die('getData();');
        break;

    case 'import'://final step : user creation and enrollments
        
        $sql="SELECT * FROM edxcrm.student_bulk_import WHERE 1;";// LIMIT 300
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
        $imported=0;
        $errors=0;
        while($r=$q->fetch(PDO::FETCH_ASSOC)){
            
            //print_r($r);
            
            // create user
            $user_id=$edxApp->userCreate($r['sbi_email'], $r['sbi_login'], $r['sbi_first_name'], $r['sbi_last_name']);
            
            if ($user_id) {
                
                // set password
                $password=$admin->django->djangopassword($r['sbi_password']);
                $edxApp->updatePassword($user_id, $password);

                // enroll
                $id=$edxApp->enroll($r['sbi_course_id'], $user_id);
                
                // send mail
                // todo..
                
                // log as text
                error_log("User #$user_id created and enrolled to course ".$r['sbi_course_id']." - enroll_id #$id\n", 3, '/tmp/admin_importusers.txt');
                $imported++;
            } else {
                error_log("Error creating user ".print_r($r)."\n", 3, '/tmp/admin_importusers.txt');
                //die("Error creating user $r");
                $errors++;
            }
            
            
            // clear temp record //
            $sbi_id=$r['sbi_id'];
            $sql="DELETE FROM edxcrm.student_bulk_import WHERE sbi_id=$sbi_id LIMIT 1;";
            $admin->db()->query($sql) or die(print_r($admin->db()->errorInfo()."<hr />$sql", true));
            
        }
        
        if($imported>0)echo "alert('$imported user(s) imported successfully');\n";
        if($errors>0)echo "alert('$errors errors(s), please check import logs !');\n";
        die("document.location.href='?';");
        break;

    default:
        die("Ctrl error: unknow action ".print_r($_POST,true));
        break;
}


die("Error :(");
