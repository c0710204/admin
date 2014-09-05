<?php

$body=[];


$body[]="<div class=row>";

// host
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group>";
$body[]="<label>Host</label>";
$body[]="<input type=text class=form-control id='pdo_host' value=".$cnf->pdo->host.">";
$body[]="</div>";
$body[]="</div>";

// port
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group>";
$body[]="<label>Port</label>";
$body[]="<input type=text class=form-control id='pdo_port' value=".$cnf->pdo->port." placeholder='3306'>";
$body[]="</div>";
$body[]="</div>";

$body[]="</div>";
$body[]="<div class=row>";

// user
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group>";
$body[]="<label>Username</label>";
$body[]="<input type=text class=form-control id='pdo_user' value=".$cnf->pdo->user.">";
$body[]="</div>";
$body[]="</div>";
// password
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group>";
$body[]="<label>Password</label>";
$body[]="<input type=password class=form-control id='pdo_pass' value=".$cnf->pdo->pass.">";
$body[]="</div>";
$body[]="</div>";
$body[]="</div>";

$footer=[];
$footer[]="<button class=btn onclick='testPdo()'><i class='fa fa-bolt'></i> Test PDO connection</button>";

echo $admin->box("danger", "<i class='fa fa-cog'></i> Pdo", $body, $footer);
?>
<div id='morepdo'></div>
<script>
function testPdo(){

	if(!$('#pdo_host').val())return false;
	if(!$('#pdo_user').val())return false;

	$('#morepdo').html("testing...");
	var p={
		'do':'testPdo',
		'host':$('#pdo_host').val(),
		'port':$('#pdo_port').val(),
		'user':$('#pdo_user').val(),
		'pass':$('#pdo_pass').val()
	};

	$('#morepdo').load("ctrl.php",p,function(x){

	});
}
$(function(){
	$('#pdo_host, #pdo_host, #pdo_user, #pdo_pass').change(function(){
		testPdo();
	});
});
</script>