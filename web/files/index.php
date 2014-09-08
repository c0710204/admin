<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte();
$admin->title("Files");

$edxapp = new EdxApp();
echo $admin->printPrivate();
?>

<section class="content-header">
    <h1><i class='fa fa-folder'></i> EdxFiles <small>MongoDbFs</small></h1>
</section>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        include "files_filter.php";
        include "files_details.php";
        include "files_upload.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        $box=new Admin\SolidBox;
        $box->id("boxfiles");
        $box->type("success");
        $box->title("Results");
        $box->loading(true);
        echo $box->html("<div id='more'></div>");
        ?>
    </section>
</div>


