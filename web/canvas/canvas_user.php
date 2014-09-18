<?php
//admin :: canvas user
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
    <h1><i class="fa fa-book"></i> Canvas user<small></small></h1>
    <ol class="breadcrumb">
        <li><a href="index.php">Canvas Index</a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
//print_r($_GET);

$user=$canvas->user($_GET['id']);

echo "<pre>";
print_r($user);
echo "</pre>";
//print_r($courses);
//$user_ids=$canvas->userIds();
//die("count:".count($user_ids));

?>
<script>
$(function(){
    $("table").tablesorter();
    console.log("ready");
});
</script>
