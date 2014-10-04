<?php
// course forum administrators
$htm=[];


// Forum admin and moderators
$adminGroup=$edxapp->clientRoles($course_id)['Administrator'];

$users=$edxapp->clientRoleUsers($adminGroup);

$htm[]="<table class='table table-condensed table-striped'>";
foreach ($users as $k => $user_id) {
    $htm[]="<tr>";
    $htm[]="<td>";
    $htm[]="<i class='fa fa-user'></i> ";
    $htm[]="<a href='../user/?id=$user_id'>".ucfirst($edxapp->userName($user_id))."</a>";//nothin
    $htm[]="<i class='fa fa-eraser pull-right'></i>";//
}
$htm[]="</table>";


$footer=[];
$footer="<input type=text class='form-control' id='username' placeholder='Username to add' autocomplete=off>";

$box=new Admin\SolidBox;
$box->id('box-admininistrator');
$box->icon('fa fa-comments-o');
$box->title(count($users)." forum Administrator(s)");
$box->loading(true);

echo $box->html($htm, $footer);


?>
<script>
function deleteRole(userroleid)
{
	if(!confirm("Delete this role "+userroleid+" ?"))return false;
}

function addRole(userId)
{
	if(!confirm("Add role for user "+userId+" ?"))return false;
	$('#box-admininistrator .loading-img, #box-admininistrator .overlay').show();
	var p={
		'do':'addRoleAdmin',
		'course_id':$('#course_id').val(),
		'userId':userId
	};
	$("#box-admininistrator .box-body").load("ctrl.php",p,function(x){
		alert(x);
		$('#box-admininistrator .loading-img, #box-admininistrator .overlay').hide();
	});
}

$(function(){
	$('#box-admininistrator .loading-img, #box-admininistrator .overlay').hide();
	autocomplete( $('#username'), 'username', '../typeahead/', function(x){
		// add user
		console.log(x);
		addRole(x.id);
	});
	console.log("ready");
});
</script>