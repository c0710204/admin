<?php
// admin :: User import -> box processing
// This show the final step of the bulk user import
// if some user are in the process of being imported, we show it here !


$sql="SELECT * FROM edxcrm.student_bulk_import WHERE sbi_course_id <> '';";
$q=$admin->db()->query($sql) or die($db->error);

//echo "<pre>$sql</pre>";

$data=[];
while($r=$q->fetch()){
	$data[]=$r;
}


$html=[];
$html[]="<table class='table table-condensed'>";
$html[]="<thead>";
$html[]="<th>#</th>";
$html[]="<th>email</th>";
$html[]="<th>login</th>";
$html[]="<th>first name</th>";
$html[]="<th>last name</th>";
$html[]="<th>password</th>";
$html[]="<th>course_id</th>";
$html[]="</thead>";

$html[]="<tbody>";
foreach($data as $r){
	$html[]="<tr>";
	$html[]="<td>".$r['sbi_id'];
	$html[]="<td>".$r['sbi_email'];
	$html[]="<td>".$r['sbi_login'];
	$html[]="<td>".$r['sbi_first_name'];
	$html[]="<td>".$r['sbi_last_name'];
	$html[]="<td>".$r['sbi_password'];
	$html[]="<td>".$r['sbi_course_id'];

}
$html[]="</tbody>";
$html[]="</table>";


if (count($data)) {

	$box = new Admin\SolidBox;
	$box->id('boxprocessing');
	$box->icon('fa fa-cog');
	$box->title("Processing import");
	$box->loading(true);

	$foot=[];
	$foot[]="Please wait...";
	echo $box->html($html,$foot);
?>
<div id='moreProcessing'></div>
<script>
$('#moreProcessing').load('ctrl.php',{'do':'import'},function(x){
	try{
		eval(x);
	}
	catch(e){
		console.log('error',x);
	}
});
</script>


<?php
	exit;
}

