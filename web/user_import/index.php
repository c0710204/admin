<?php
//admin :: User activity
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCrm;

$admin = new AdminLte();
$admin->title("User import");
echo $admin->printPrivate();

$edxapp = new EdxApp();

?>

<section class="content-header">
    <h1><i class='fa fa-users'></i> User import</h1>
</section>


<!-- Main content -->
<section class="content">


<?php
include "box_tools.php";


$box = new Admin\SolidBox;
$box->id('boxlist');
$box->icon("fa fa-users");
$box->title("Temporary user list");
$box->loading(true);

$foot=[];
$foot[]="<a href=# class='btn btn-default'><i class='fa fa-bolt'></i> Import</a>";

echo $box->html("Please wait...",$foot);

?>

<div id='more'></div>
<div id='results'></div>

</section>


<script src='user_import.js'></script>