<?php
//admin test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new Admin\AdminLte();
$admin->printPublic();
?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-home'></i> Typeahead </h1>
</section>

<br />

<!-- Main row -->
<div class="row">

<!-- Left col -->
<section class="col-lg-6 connectedSortable">
<?php

$box=new Admin\SolidBox;
$box->title("Typeahead test field");
$box->icon("fa fa-users");

$html[]="<input type=text class='form-control' id='username' placeholder='Username' autocomplete=off>";
$footer="<a href=#test class='btn btn-default'>Test</a>";
echo $box->html($html, $footer);
?>
</section>

</div>


<script>
$(function(){
	autocomplete( $('#username'), 'username', '../typeahead/', function(x){console.log(x);} );
	$('#username').focus();
	console.log("ready");
});
</script>