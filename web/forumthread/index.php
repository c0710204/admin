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
//$_GET['id']='54059ed056c02c8cf1000001';
if (!isset($_GET['id'])) {
    die("Error: no thread id");
} else {
    try {
        $mongoId=new MongoId($_GET['id']);
    } catch(MongoException $ex) {
        echo $admin->callout("danger", "Invalid Thread Id");
        exit;
        die("Error :: $ex");
    }

    $r = $forum->contents->findOne(["_id"=>$mongoId]);
    if (!$r) {
        echo $admin->callout("danger", "Forum thread not found");
        exit;
    }

}
?>

<section class="content-header">
    <h1><a href='../forum/'><i class='fa fa-comments-o'></i></a> Forum thread <small><?php echo $_GET['id'];?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-book"></i><?php echo explode('/', $r['course_id'])[0]?></a></li>
        <li class="active"><?php echo explode('/', $r['course_id'])[1]?></li>
        <li class="active"><?php echo "<a href='../course/?id=".$r['course_id']."'>".explode('/', $r['course_id'])[2]?></a></li>
    </ol>
</section>

<!-- Main content -->
<section class="content">

<?php
echo "<input type=hidden id=id value='".$_GET['id']."'>";
?>

<!-- Main row -->
<div class="row">
    <!-- Left col -->
    <section class="col-lg-6 connectedSortable">
    <?php
    include "box_info.php";
    include "box_subscriptions.php";
    include "box_debug.php";
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

