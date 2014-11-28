<?php
// Profiles //

$configs=glob('../config/profiles/*.json');

$body=[];
$body[]="<select id='configs' class='form-control'>";
$body[]="<option value=''>Select profile</option>";

$footer=[];
$footer="<button class='btn'>Apply</button>";

foreach ($configs as $conf) {
    $conf=basename($conf);
    $body[]="<option value=$conf>$conf</option>";
}

$body[]="</select>";

echo $admin->box("danger", "<i class='fa fa-sign-in'></i> Profile", $body);

?>
<script>
$(function(){
	$('#configs').change(function(x){
		var conf=$('#configs').val();
		$('#more').html("Loading profile...");
		$('#more').load("ctrl.php",{'do':'testProfile','conf':conf});
	});
});
</script>