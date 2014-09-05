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
        echo $admin->box("success", "Results", "<div id='more'></div>");
        //include "files_upload.php";
        //include "files_debug.php";
        ?>
    </section>
</div>


