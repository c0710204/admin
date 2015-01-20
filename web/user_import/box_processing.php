<?php
// admin :: User import -> box processing

// if some user are in the process of being imported, we show it here


$sql="SELECT * FROM edxcrm.student_bulk_tmp WHERE 1;";
$q=$admin->db()->query($sql) or die($db->error);
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
	$html[]="<td>".$r['sbt_id'];
	$html[]="<td>".$r['sbt_email'];
	$html[]="<td>".$r['sbt_login'];
	$html[]="<td>".$r['sbt_first_name'];
	$html[]="<td>".$r['sbt_last_name'];
	$html[]="<td>".$r['sbt_password'];
	$html[]="<td>".$r['sbt_course_id'];
}
$html[]="</tbody>";
$html[]="</table>";


if (count($data)) {
	
	$box = new Admin\SolidBox;
	$box->id('boxtools');
	$box->icon('fa fa-cog');
	$box->title("Processing");

	$foot=[];
	$foot[]="Please wait...";
	echo $box->html($foot);

	exit;
}