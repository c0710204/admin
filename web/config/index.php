<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte("../config.json");//admin interface
$edxapp = new EdxApp("../config.json");//admin interface

$admin->path("../");//admin interface
echo $admin->printPublic();

// get conf as object
$cnf=$admin->config();
?>

<section class="content-header">
    <h1><i class="fa fa-gears"></i> Config page <small>just so you know</small></h1>
</section>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">

    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        //include "config_selector.php";
        echo "<pre>".print_r($_SESSION['configfile'], true)."</pre>";
        //echo "<pre>".print_r($admin->config(), true)."</pre>";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        //include "config_mongo.php";
        ?>
    </section>

</div>



<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php 
        include "config_lte.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php 
        include "config_pdo.php";
        include "config_mongo.php";
        ?>
    </section>
</div>

<?php
//echo "<pre>";
//print_r($admin->config());

