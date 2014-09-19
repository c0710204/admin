<?php
//admin :: canvas user import
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Canvas");

echo $admin->printPrivate();

//$edxapp= new Admin\EdxApp();
//$canvas= new Admin\Canvas();
?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Canvas tools<small></small></h1>
</section>

<?php
if (!@($_SESSION['canvas']['connected'])) {
    include "canvas_config.php";
    exit;
}
?>


<!-- Main content -->
<section class="content">


<a href='canvas_courses.php' class='btn btn-default'><i class='fa fa-book'></i> Canvas courses</a> 
<a href='canvas_users.php' class='btn btn-default'><i class='fa fa-users'></i> Canvas users</a> 
<a href='canvas_duplicate_names.php' class='btn btn-default'><i class='fa fa-users'></i> Canvas duplicate names</a> 
<a href='canvas_emails.php' class='btn btn-default'><i class='fa fa-mail'></i> Canvas emails</a> 
<a href='import.php' class='btn btn-default'><i class='fa fa-retweet'></i> User migration</a> 

</section>