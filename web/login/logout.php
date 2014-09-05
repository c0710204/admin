<?php
// log out
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte();
$admin->title("Logout");
$admin->printPrivate();
?>

<section class="content-header">
    <h1 class='text-center'><i class="fa fa-sign-out"></i> Logout</h1>
</section>

<!-- Main content -->
<section class="content">


<?php
if ($admin->django->logout()) {
    //echo "logout ok\n";
    //echo "please log in";
    $msg=$admin->callout("danger", "done", "Bye! <a href='index.php'>Login</a>");
    echo $admin->box("danger", "Logout", $msg);
    echo "<script>document.location.href='index.php';</script>";
} else {
    echo "logout error!";
    echo "<script>document.location.href='index.php';</script>";
}
