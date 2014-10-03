<?php
// typeahead php script
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$admin->ctrl();

//print_r($_GET);

$query = trim(@$_POST['query']);


if (@$_GET['query']) {
    $query = trim(@$_GET['query']);
}


if (strlen($query) < 2) {
    die();
}

switch($_GET['type'])
{
    case 'username':
        $sql = "SELECT id as id, username as value FROM edxapp.auth_user ";
        $sql.= " WHERE username LIKE \"%" . $query . "%\"  ";
        $sql.= " ORDER BY username LIMIT 30;";
        break;

    default:
        print_r($_GET);
        break;
}

$q = $admin->db()->query($sql) or die($admin->db()->error . "<hr />$sql");
//$nr= $q->num_rows;

//die("$sql");

$strict = array();//for the 'perfect' matches
$first = array();//for the 'perfect%' matches
$data = array();

while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
    
    //print_r($r);

    $r['value'] = utf8_encode($r['value']);
    
    if (preg_match('/^' . preg_quote($query) . '$/i', $r['value'])) {
        $strict[] = $r;
    } elseif (preg_match('/^' . preg_quote($query) . '/i', $r['value'])) {
        $first[] = $r;
    } else {
        $data[] = $r;//
    }
}

// Now, we should process those data a little bit,
// To make sure that the short names appear first
$packet = $strict + $first + $data;


echo json_encode($packet);
