<?php
//admin :: statistics
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";
use Admin\AdminLte;

$admin = new AdminLte();
$admin->ctrl();

switch ($_POST['do']) {

    case 'getData':
        //print_r($_POST);
        $db=$admin->db();
        $q=$db->query("SELECT id, date(date_joined) as date FROM edxapp.auth_user WHERE 1 ORDER BY date_joined DESC;");

        $data=[];
        while ($r=$q->fetch()) {
            @$data[$r['date']]++;
        }

        $JS=[];
        foreach ($data as $date => $value) {
            $JS[]=array("date"=>$date, "n"=>$value);
        }
        echo "data=" . json_encode($JS) . ";\n";
        exit;
        break;

    default:
        print_r($_POST);
        break;
}

print_r($_POST);
