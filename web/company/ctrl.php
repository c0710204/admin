<?php
//admin :: CRM company
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();
$edxCrm= new Admin\EdxCrm();

switch($_POST['do']){

	case 'delete':
		//print_r($_POST);
		$company_id=$_POST['id']*1;
		if($company_id>0){
			$sql="DELETE FROM edxcrm.companies WHERE c_id=$company_id LIMIT 1;";
			$admin->db()->query($sql) or die("Error : $sql");
			//echo $sql;
			die('document.location.href="../companies/";');
		}
		exit;
		break;

    default:
        echo "ctrl error : unknow action";
        print_r($_POST);
        exit;
        break;
}

exit;

die("ctrl error :(");