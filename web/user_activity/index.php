<?php
//admin :: User activity
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;

$admin = new AdminLte();
$admin->title("User activity");
echo $admin->printPrivate();

$edxapp = new EdxApp();

$user_id=$_GET['user_id']*1;

if (!$user_id) {
    die('error');
} else {
    $usr=$edxapp->user($user_id);
}

echo "<input type='hidden' id='user_id' value='$user_id'>";
?>

<section class="content-header">
    <h1><i class='fa fa-stethoscope'></i> <?php echo "<a href='../user/?id=$user_id'>".$usr['username']."</a> activity"?></h1>
</section>


<!-- Main content -->
<section class="content">


<?php

include "box_filter.php";
$box = new Admin\SolidBox;
$box->id('boxlist');
$box->title("Activity <small>".$box->id()."</small>");
$box->body("<div id='results'></div>");
echo $box->html();
?>

</section>


<script src='user_activity.js'></script>