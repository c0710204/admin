<?php
//admin test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte();

//$db=$admin->db();
//$q=$admin->db()->query("SELECT COUNT(*) FROM edxapp.student_courseenrollment WHERE course_id LIKE '$course_id';");
//$count=$q->fetch()[0];
$query="bill";

$sql="SELECT id, username as value FROM edxapp.auth_user WHERE 1;";
$q=$admin->db()->query($sql) or die("<pre>$sql</pre>");

$data = array();
$packet=$strict=$first=[];

while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
    $r['value'] = utf8_encode($r['value']);
    if (preg_match('/^'.preg_quote($query).'$/i', $r['value'])) {
        $strict[] = $r;
    } elseif (preg_match('/^'.preg_quote($query).'/i', $r['value'])) {
        $first[] = $r;
    } else {
        $data[] = $r;//
    }
}

// Now, we should process those data a little bit,
$packet = $strict + $first + $data;


echo json_encode($data);
