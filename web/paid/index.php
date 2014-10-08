<?php
// Paid //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$edxapp = new Admin\EdxApp();
$edxCourse = new Admin\EdxCourse();

echo $admin->printPrivate();
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-user'></i> Paid <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php

// paid
$sql = "SELECT * FROM edxapp.paid;";
echo "<pre>$sql</pre>";
$q=$admin->db()->query($sql) or die("<pre>Error:$sql</pre>");
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}


// paid_chapter_misc
$sql = "SELECT * FROM edxapp.paid_chapter_misc;";
echo "<pre>$sql</pre>";
$q=$admin->db()->query($sql);
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}

// paid_group
$sql = "SELECT * FROM edxapp.paid_group;";
echo "<pre>$sql</pre>";
$q=$admin->db()->query($sql);
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}

// paid_student
$sql = "SELECT * FROM edxapp.paid_student;";
echo "<pre>$sql</pre>";
$q=$admin->db()->query($sql);
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    print_r($r);
}

die("ok");