<?php
//admin :: paid stuff
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;
use Admin\EdxForum;

$admin = new AdminLte();
$admin->title("Course");
echo $admin->printPrivate();
?>
<section class="content-header">
<h1><i class='fa fa-sign-in'></i> Paid</h1>
</section>

<!-- Main content -->
<section class="content">
<?php
$sql="SELECT * FROM edxapp.paid;";
$q=$admin->db()->query($sql) or die("<pre>error : $sql</pre>");
echo "<pre>$sql</pre>";
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    print_r($r);
}

$sql="SELECT * FROM edxapp.paid_chapter_misc;";
$q=$admin->db()->query($sql) or die("error2");
echo "<pre>$sql</pre>";
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    print_r($r);
}

$sql="SELECT * FROM edxapp.paid_group;";
$q=$admin->db()->query($sql) or die("error3");
echo "<pre>$sql</pre>";
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    print_r($r);
}

$sql="SELECT * FROM edxapp.paid_student;";
$q=$admin->db()->query($sql) or die("<pre>error : $sql</pre>");
echo "<pre>$sql</pre>";
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    print_r($r);
}
