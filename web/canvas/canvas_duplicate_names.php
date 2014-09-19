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
    <h1><i class="fa fa-user"></i> Canvas duplicate names<small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
<pre>
<?php

echo date('c')."\n";
echo "<hr />";

// Duplicate user names //

$sql = "SELECT name, count(name) as count FROM users GROUP BY name ORDER BY count DESC;";
$q = $canvas->db()->query($sql) or die("error $sql");

while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    if($r['count']<2)continue;
    //print_r($r);
    autorename($r['name']);
    //die("done");
}

die("done");



function autorename($username = '')
{
    global $canvas;
    
    echo "autorename($username);\n";

    $sql = "SELECT id FROM users WHERE name LIKE ".$canvas->db()->quote($username).";";
    $q = $canvas->db()->query($sql) or die("error: $sql");
    
    $i=1;

    while($r=$q->fetch(PDO::FETCH_ASSOC)){
        
        //print_r($r);
        $id=$r['id'];
        
        $newName="$username $i";
        //echo "$newName\n";
        $sql = "UPDATE users SET name = ".$canvas->db()->quote($newName)." WHERE id=$id;";
        $canvas->db()->query($sql) or die("error: $sql");
        $i++;
    }
}


/*
// find the longest user names
$sql="SELECT name, LENGTH(name) as len FROM users ORDER BY len DESC LIMIT 100;";
$q = $canvas->db()->query($sql) or die("error $sql");
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}
*/


?>
<script>
$(function(){
    $("table").tablesorter();
    console.log("ready");
});
</script>
