<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxForum;

$admin = new AdminLte();
$edxapp = new EdxApp();
$forum = new EdxForum();

$admin->title("Forum thread");

echo $admin->printPrivate();

//print_r($_GET);
if (!isset($_GET['id'])) {
    die("Error: no thread id");
}
?>

<section class="content-header">
    <h1><a href='../forum/'><i class='fa fa-comments-o'></i></a> Forum thread <small><?php echo $_GET['id'];?></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php
try {
    $mongoId=new MongoId($_GET['id']);
} catch(MongoException $ex) {
    echo $admin->callout("danger", "Invalid Thread Id");
    exit;
    die("Error :: $ex");
}

echo "<input type=hidden id=id value='".$_GET['id']."'>";

?>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    include "box_info.php";
    ?>
    </section>
    <!-- Right col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    include "box_thread.php";
    ?>
    </section>

</div>

<div id='moreInfo'></div>

<script src='forumthread.js'></script>
<script>
$(function(){
    $('table').tablesorter();
});
</script>

