<?php
//admin BACKUP
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte();
$admin->title("Backup");
echo $admin->printPrivate();//
$edxapp = new EdxApp();


if (!is_writable("./archives")) {
    echo "<pre>Permission error for ./archives</pre>";
}

if (!is_writable("./dump")) {
    echo "<pre>Permission error for ./dump</pre>";
}


?>

<section class="content-header">
<h1><i class='fa fa-database'></i> Backup <?php echo $admin->config()->mongo->host?></h1>
</section>

<!-- Tiles -->
<?php include "tiles.php";?>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        include "box_mysql.php";
        //include "box_mysql_stats.php";
        ?>
    </section>

    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
        <?php
        include "box_mongo.php";
        include "box_mongostats.php";
        ?>
    </section>
</div>

<script>
$(function(){
    $("table").tablesorter();
});
</script>