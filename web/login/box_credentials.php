<?php

$body=[];
$body[]="<form id=f role=form method='post' action='login_check.php'>";


//get config profiles
$configs=glob('../config/profiles/*.json');

$body[]="<div class='form-group'>";
$body[]="<select name=configfile id='configs' class='form-control'>";
$body[]="<option value=''>Select profile</option>";
foreach ($configs as $conf) {
    $conf=basename($conf);
    $body[]="<option value=$conf>".explode(".json", $conf)[0]."</option>";
}
$body[]="</select>";
$body[]="</div>";

$body[]="<div class='form-group'>";
$body[]="<div class='input-group'>";
$body[]="<span class=input-group-addon>@</span>";
$body[]="<input type=email id='email' name='email' class=form-control placeholder='Email'>";
$body[]="</div></div>";


$body[]="<div class=form-group>";
$body[]="<div class=input-group>";
$body[]="<span class=input-group-addon><i class='fa fa-sign-in'></i></span>";
$body[]="<input type=password id=password name=password class=form-control placeholder='Password'>";
$body[]="</div></div>";
//$body[]="</form>";

$foot=[];
$foot[]="<button type=submit class='btn btn-primary'><i class='fa fa-sign-in'></i> Login</button>";
$foot[]="</form>";

$box=new Admin\SolidBox;
$box->id("boxlogin");
$box->type("danger");
$box->icon('fa fa-sign-in');
$box->title('Enter your credentials');
$box->loading(true);
//$box->footer($foot);
echo $box->html($body, $foot);

?>
<div id='more'>more</div>
<script>

function getProfile(){
	var conf=$('#configs').val();
	if(!conf){
		$('#more').html("<pre>Select a profile</pre>");
		$("#email, #password").prop('disabled', true);
		return false;
	}
	$("#email, #password").prop('disabled', false);
	$('#more').html("Loading profile...");
	$('#more').load("ctrl.php",{'do':'testProfile','conf':conf});
}

$(function(){
	$("#boxlogin .loading-img, #boxlogin .overlay").hide();
    
    $('#configs').change(function(x){
		getProfile();
	});
    /*
    $('#email').change(function(x){
    	checkMail();
    }
	*/
	getProfile();
    $('#configs').focus();
    console.log("ready");
});


function checkMail(){
	var email=$('email').val();
}

</script>