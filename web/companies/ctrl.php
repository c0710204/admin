<?php
//admin :: list (edxcrm) companies
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$edxApp= new Admin\EdxApp();
$edxCrm= new Admin\EdxCrm();


switch($_POST['do']){

    case 'createCompamy':
        //print_r($_POST);
        // check if comp exist first //
        if ($user_id=$edxCrm->company_exist($_POST['name'])) {
            echo "alert('This user already exist !');\n";
            die("document.location.href='../user/?id=$user_id';\n");
        }

        $comp_id=$edxCrm->company_create($_POST['name']);
        //var_dump($created);
        if ($comp_id) {
            die("document.location.href='../companies/?id=$user_id';\n");
        } else {
            die("alert('error creating company');");
        }
        break;


    case 'getCompanyList':

        //print_r($_POST);

        $WHERE=[];        
        if (preg_match("/^[0-9]+$/", $_POST['search'])) {
            $WHERE[]="c_id=".$_POST['search']*1;
        } else {
            $OR=[];
            $OR[]="c_name LIKE '%".$_POST['search']."%'";
            //$OR[]="first_name LIKE '%".$_POST['search']."%'";
            //$OR[]="last_name LIKE '%".$_POST['search']."%'";
            $WHERE[]="(".implode(" OR ", $OR).")";
        }
        /*
        switch($_POST['status']) {
            
            case 'active':
                $WHERE[]="is_active=1";
                break;
            
            case 'inactive':
                $WHERE[]="is_active=0";
                break;

            case 'staff':
                $WHERE[]="is_staff=1";
                break;
            
            case 'superuser':
                $WHERE[]="is_superuser=1";
                break;
            
            default:
                break;
        }
        */
        $sql="SELECT * FROM edxcrm.companies WHERE 1;";
        $q=$admin->db()->query($sql) or die("Error : $sql");
        $list=[];
        while($r=$q->fetch(PDO::FETCH_ASSOC)){
            $list[]=$r;
        }
        //$list=$edxCrm->userList($WHERE, $_POST['limit']);
        echo json_encode($list);
        
        exit;
        break;



    /**
     * Show company info
     */
    case 'getCompInfo':
        print_r($_POST);
       

        // More info button
        //echo "<hr />";
        //echo "<a href='../user/?id=".$user['id'].">' class='btn btn-primary'><i class='fa fa-arrow-circle-right'></i> More about ".$user['username']."</a>";
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