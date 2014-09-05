
<?php

$body=[];


$body[]="<div class=row>";

// host
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group><label>Host</label>";
$body[]="<input type=text class='form-control' id='mongo_host' value=".$cnf->mongo->host.">";
$body[]="</div>";
$body[]="</div>";

// port
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group><label>Port</label>";
$body[]="<input type=text class='form-control' id='mongo_port' value='".$cnf->mongo->port."' placeholder='27017'>";
$body[]="</div>";
$body[]="</div>";


$body[]="</div>";//row
$body[]="<div class=row>";


// user
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group><label>User</label>";
$body[]="<input type=text class='form-control' id='mongo_user' value=".$cnf->mongo->user.">";
$body[]="</div>";
$body[]="</div>";
// pass
$body[]="<div class=col-lg-6>";
$body[]="<div class=form-group><label>Pass</label>";
$body[]="<input type=text class='form-control' id='mongo_pass' value=".$cnf->mongo->pass.">";
$body[]="</div>";
$body[]="</div>";


$body[]="</div>";//row


$footer=[];
$footer[]="<button class='btn' onclick='testMongo()'><i class='fa fa-bolt'></i> Test mongo connection</button>";

echo $admin->box("danger", "<i class='fa fa-cog'></i> MongoDb config", $body, $footer);

?>
<div id='moremongo'></div>
<script>
function testMongo(){


	if(!$('#mongo_host').val())return false;
	//if(!$('#mongo_user').val())return false;

	var p={
		'do':'testMongo',
		'host':$('#mongo_host').val(),
		'port':$('#mongo_port').val(),
		'user':$('#mongo_user').val(),
		'pass':$('#mongo_pass').val()
	};
	$('#moremongo').html("testing...");
	$('#moremongo').load("ctrl.php",p,function(x){

	});
}

$(function(){
	console.log('ready');
	$('#mongo_host').change(function(){
		console.log("change");
	});
})
</script>