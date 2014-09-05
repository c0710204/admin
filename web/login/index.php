<?php
//admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$_SESSION['configfile']='';

use Admin\AdminLte;

$admin = new AdminLte(false);
$admin->title("Login");
echo $admin->printPublic();
?>

<section class="content-header">
<h1><i class='fa fa-sign-in'></i> Admin login</h1>
</section>

<!-- Main content -->
<section class="content">

<div class="row">
<section class="col-lg-6 connectedSortable">
    <?php
    //include "box_profile.php";
    include "box_credentials.php";
    ?>
</section>

<!-- Right box -->
<section class="col-lg-6 connectedSortable">
    <div id='more'></div>
    <?php
    //print_r($_SESSION);
    ?>
</section>

</div>


</section>

<script>
/*
$(function(){
    console.log("ready");
    $('#email').focus();
});
*/
</script>
