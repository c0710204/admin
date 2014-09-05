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

$admin->title("Forum");

echo $admin->printPrivate();

?>

<section class="content-header">
    <h1><i class='fa fa-comments-o'></i> Forum <small></small></h1>
</section>



<!-- Main content -->
<section class="content">
<?php include "box_search.php";?>
<?php include "box_threads.php";?>
</section>

<script>
$(function(){
    $('table').tablesorter();
});
</script>