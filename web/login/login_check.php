<?php
// login
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte();
$admin->title("Login");

echo $admin->printPublic();
?>

<section class="content-header">
    <h1><i class="fa fa-sign-in"></i> Login <small>profile : <?php echo basename($_POST['configfile'])?></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php

//echo "<pre>" . print_r($_POST, true) . "</pre>";

$cf=realpath('.')."/../config/profiles/".$_POST['configfile'];
if (is_file($cf)) {
    $_SESSION['configfile']=realpath($cf);
    $admin = new AdminLte();
} else {
    die("File $cf not found");
}

if (isset($_POST['email']) && isset($_POST['password'])) {

    if ($admin->django->login($_POST['email'], $_POST['password'])) {
        // login
        $logstr=date("c")."\tlogin\t".$_POST['email']."\t".basename($_SESSION['configfile'])."\n";
        $log = error_log($logstr, 3, '/var/tmp/admin_login.log');
        $msg=new Admin\Callout("info", "Please wait", "You are being redirected...");
        
        $box=new Admin\Box;
        $box->type("success");
        $box->title("Welcome " . $admin->user['username']);
        $box->icon('fa fa-ok');
        $box->body($msg);
        echo $box->html();

        echo "<script>document.location.href='../home/index.php';</script>";
    
    } else {

        // nope
        $logstr = date("c")."\tlogfail\t".$_POST['email']."\t".basename($_SESSION['configfile'])."\n";
        $log = error_log($logstr, 3, '/var/tmp/admin_login.log');
        
        $msg ="<p>Please try again</p>";

        $callout=new Admin\Callout("danger", "<i class='fa fa-ban'></i> Invalid login and/or password", $msg);
        $foot=[];
        $foot[]="<a href='index.php' class='btn btn-default'><i class='fa fa-sign-in'></i> Try again</a>";
        
        $box=new Admin\Box;
        $box->type("danger");
        $box->title("Login error");
        $box->icon('fa fa-ban');
        $box->body($callout);
        $box->footer($foot);
        echo $box->html();
        
        //echo $admin->box("danger", "<i class='fa fa-sign-in'></i> Login <small>profile</small>", $callout, $foot);
    }
} else {
    echo $admin->box("danger", "<i class='fa fa-ban'></i> Login error", "Hello ?" . print_r($_POST, true));
}
/*
echo $admin->callout("warning", "warning", "Hell yeah");
echo $admin->callout("info", "info", "Hell yeah");
echo $admin->callout("danger", "danger", "Hell yeah, but no... not really");
echo $admin->callout("success", "Im cool", "Hell yeah");
*/
?>

<script>
$(function(){
    console.log("ready");
});
</script>