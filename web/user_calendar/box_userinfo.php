<?php
// calendar user info

$user=$edxApp->user($USERID);
$username=$user['username'];

//$body=print_r($user,true);

$box = new Admin\SolidBox;
$box->id("boxleft");
$box->icon("fa fa-user");
$box->title("$username");

$body[]="<i class='fa fa-calendar'></i> Joined : <a href=# class='btn btn-default'>".substr($user['date_joined'],0,10)."</a><br />";
$body[]="<i class='fa fa-calendar'></i> Last login : ".substr($user['last_login'],0,10)."<br />";




// Courses //

$courses=$edxApp->studentCourseEnrollment($USERID);

$body[]="<hr />";
$body[]="<i class='fa fa-book'></i> ".count($courses)." course enrollment(s)<br />";

//$body[]="<table class='table table-condensed'>";
foreach($courses as $k=>$r){
	//print_r($r);
	$meta=$edxCourse->metadata($r['course_id']);
	//print_r($meta);
	$start=@substr($meta['start'],0,10);
	$end = @substr($meta['end'], 0,10);

	//$body[]="<tr>";
	$body[]="<a href='../course/?id=".$r['course_id']."' title='$start to $end'>".strtolower($meta['display_name'])."</a><br />";
}
//$body[]="</table>";


$foot="<a href='../user/?id=$USERID' class='btn btn-default'><i class='fa fa-arrow-right'></i> User info</a>";
echo $box->html($body,$foot);
?>

<div id='more'></div>

<span class='label label-primary'>primary</span>
<span class='label label-default'>default</span>
<span class='label label-danger'>danger</span>
<span class='label label-info'>info</span>
<span class='label label-warning'>warning</span>
<span class='label label-success'>success</span>

<script>
$(function(){
	var p ={'do':'getEnrollments', 'user_id':$('#user_id').val()};
	$('#more').load("ctrl.php",p, function(x){
		try{
			eval(x);
			$('#more').html("ok");
		}
		catch(e){
			alert(x);
		}
	});
});
</script>

