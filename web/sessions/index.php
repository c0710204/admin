<?php
// admin :: Sessions (Edx Sessions)
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Sessions");
echo $admin->printPrivate();

$edxApp = new EdxApp();
$edxCourse = new EdxCourse();
//$session_id=$_GET['id'];
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-bolt'></i> Sessions </h1>
    
</section>

<?php
//sessions
?>

<!-- Main content -->
<section class="content">


<!-- Main row -->
<div class="row">

    <section class="col-sm-12 connectedSortable">
    <?php
    include "box_search.php";
    ?>
    </section><!-- /.Col -->

</div>

<!-- Main row -->
<div class="row">

    <!-- Left col -->
    <section class="col-sm-12 connectedSortable">
    <!-- Userinfo -->
    <?php
    //include "box_userinfo.php";
    
    $box=new Admin\SolidBox;
    //$box->id("");
    $box->title("Sessions");
    $box->icon("fa fa-bolt");
    $box->id("boxSessions");
    $box->loading(true);
    echo $box->html("<div id=sessionList>Please wait</div>");

    ?>
    </section>
</div>

<div id='more'></div>

<script src='sessions.js'></script>
