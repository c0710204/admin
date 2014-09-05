<?php
//admin :: datepicker
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Datepicker");
echo $admin->printPrivate();
?>

<section class="content-header">
    <h1 class='text-center'><i class="fa fa-users"></i> Users</h1>
</section>

<!-- Main content -->
<section class="content">

<p>Date: <input type="text" id="datepicker"></p>

<script>
$(function() {
    $( "#datepicker" ).datepicker();
  });
</script>