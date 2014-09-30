<?php
//admin :: groups
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";
//use Admin\AdminLte;
$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();
$edxCourse= new Admin\EdxCourse();

$admin->ctrl();


// group counts
/*
$sql="SELECT group_id, COUNT(user_id) as c FROM edxapp.auth_user_groups GROUP BY group_id;";
$q = $admin->db()->query($sql) or die("admin->db()->error");
$GC=[];
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $GC[$r['group_id']]=$r['c'];
}
*/
// print_r($GC);

switch($_POST['do']){
    
    case 'list':
        
        //print_r($_POST);
        $WHERE=[];
        $WHERE[]=1;

        if ($_POST['org']) {
            $WHERE[]="name LIKE '%_".$_POST['org']."%'";
        }

        if ($_POST['type']) {
            $WHERE[]="name LIKE '".$_POST['type']."_%'";
        }

        if ($_POST['search']) {
            $WHERE[]="name LIKE '%".$_POST['search']."%'";
        }

        $sql ="SELECT * FROM edxapp.auth_group ";
        $sql.="WHERE ".implode(" AND ", $WHERE);
        $sql.=" ORDER BY id DESC;";
        
        $q = $admin->db()->query($sql) or die("admin->db()->error $sql");
        //echo "<pre>$sql</pre>";exit;


        $dat=[];
        while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
            preg_match('/^(beta_testers|instructor|staff)_/', $r['name'], $type);
            $r['type']=$type[1];
            $r['course_id']=preg_replace('/^(beta_testers|instructor|staff)_/', '', $r['name']);
            $r['course_id']=str_replace('.', '/', $r['course_id']);
            $r['courseName']=$edxApp->courseName($r['course_id']);
            $dat[]=$r;
        }
        echo json_encode($dat);
        break;

    default:
        die("Error");
        break;
}
