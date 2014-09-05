<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../vendor/autoload.php";

//use Admin\Curl;
use Admin\AdminLte;
use Admin\UserDjango;
use Admin\EdxApp;

$admin = new AdminLte("config.json");//admin interface

//$edx = new EdxApp();//edx admin functions

echo $admin->printPublic();
?>

<section class="content-header">
    <h1>
        Test page <small>small</small>
    </h1>
</section>

<!-- Main content -->
<section class="content">

<?php
echo "<pre>";
echo "sid=".session_id()."\n";
echo "user=".print_r($admin->user, true)."\n";

//print_r($_SESSION);

//$sess=$admin->django->djangoSession();

if (!$admin->session) {
    echo "<li>error:no django session";
}

//print_r($admin->session);

//$user=$admin->django->user($_SESSION['userid']);

print_r($admin->config());
echo "</pre>";
?>

<div class="box box-info">
    <div class="box-header">
        <i class="fa fa-bullhorn"></i>
        <h3 class="box-title">Callouts</h3>
    </div><!-- /.box-header -->
    <div class="box-body">
        <div class="callout callout-danger">
            <h4>I am a danger callout!</h4>
            <p>There is a problem that we need to fix. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
        </div>
        <div class="callout callout-info">
            <h4>I am an info callout!</h4>
            <p>Follow the steps to continue to payment.</p>
        </div>
        <div class="callout callout-warning">
            <h4>I am a warning callout!</h4>
            <p>This is a yellow callout.</p>
        </div>
    </div><!-- /.box-body -->
</div>

<div class="callout callout-danger">
            <h4>I am a danger callout!</h4>
            <p>There is a problem that we need to fix. A wonderful serenity has taken possession of my entire soul, like these sweet mornings of spring which I enjoy with my whole heart.</p>
        </div>