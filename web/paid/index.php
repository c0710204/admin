<?php
// Paid //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxApp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

echo $admin->printPrivate();
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-money'></i> Paid <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<!-- Main row -->
<div class="row">
    <!-- Col -->
    <section class="col-sm-6 connectedSortable">
    <?php
    // box courses
    include "box_courses.php";
    
    // table paid
    include "products.php";
    ?>
    </section>

    <!-- Col -->
    <section class="col-sm-6 connectedSortable">
    <?php
    include "paid_group.php";
    include "paid_users.php";
    ?>
    </section>

</div>



<?php


// paid_chapter_misc (text)
/*
echo "<h1>Chapter misc </h1>";

$sql = "SELECT * FROM edxapp.paid_chapter_misc;";
$q=$admin->db()->query($sql);

echo "<pre>$sql</pre>";

echo "<table class='table table-condensed table-striped'>";
echo "<thead>";
echo "<th>pcm_id</th>";
echo "<th>pcm_text_desc</th>";
echo "</thead>";
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    //print_r($r);
    echo "<tr>";
    echo "<td>".$r['pcm_id'];
    echo "<td>".$r['pcm_text_desc'];
}
echo "</table>";
*/





die("ok");