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


<li><a href='canvas_courses.php'>Canvas courses</a>
<li><a href='canvas_users.php'>Canvas users</a>
<li><a href='import.php'>User migration</a>

</section>