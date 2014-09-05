<?php
//charts test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
//use Admin\EdxApp;
//use Admin\EdxCourse;
//use Admin\EdxForum;

$admin = new AdminLte();
//$edxapp = new EdxApp();
//$edxcourse = new EdxCourse();
//$forum = new EdxForum();

echo $admin->printPrivate();
$user=$admin->user;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-home'></i> Charts test <small>bim</small></h1>
</section>

http://almsaeedstudio.com/AdminLTE/pages/charts/flot.html

<?php

include "charts.php";