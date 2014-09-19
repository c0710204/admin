<?php
//admin :: canvas users
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

$edxapp= new Admin\EdxApp();
$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-user"></i> Canvas emails<small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php


$sql="SELECT workflow_state, count(workflow_state) FROM communication_channels GROUP BY workflow_state ORDER BY count(workflow_state) DESC;";
$q=$canvas->db()->query($sql) or die("error $sql");
echo "<pre>$sql</pre>";

echo "<table class='table table-condensed'>";
echo "<thead>";
echo "<th>workflow_state</th>";
echo "<th>count</th>";
echo "</thead>";
echo "<tbody>";
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    //print_r($r);
    echo "<tr>";
    echo "<td>".$r['workflow_state'];
    echo "<td>".number_format($r['count']);
}
echo "</tbody>";
echo "</table>";


// list unconfirmed
function unconfirmed()
{
    global $canvas;
    $sql="SELECT DISTINCT user_id FROM communication_channels WHERE workflow_state='unconfirmed';";
    $q=$canvas->db()->query($sql) or die("error $sql");
    $dat=[];
    while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
        $dat[]=$r['user_id'];
        //echo "<tr>";
        //echo "<td>".$r['workflow_state'];
        //echo "<td>".number_format($r['count']);
    }
    return $dat;
}

/*
echo "-------------\n";
//echo "unconfirmed()\n";
$unconfirmed=unconfirmed();
//print_r($unconfirmed);
foreach($unconfirmed as $user_id){
    $enr=$canvas->userEnrollments($user_id);
    print_r($enr);
}
*/


?>
<script>
$(function(){
    $("table").tablesorter();
    console.log("ready");
});
</script>
