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
    $htm[]="<a href='../user/?id=$user_id'>".$edxapp->userName($user_id);//nothin
    $htm[]="<a href=#del class='pull-right'><i class='fa fa-eraser'></i>";//
    //print_r($usr);
}

$htm[]="</table>";



$footer=[];
$footer="<a href=# class='btn btn-default'>Add</a>";

$box=new Admin\SolidBox;
$box->id('box-admininistrator');
$box->icon('fa fa-comments-o');
$box->title(count($users)." forum Administrator(s)");
$box->loading(true);

echo $box->html($htm, $footer);

?>
<script>
function deleteRole(userid)
{
	if(!confirm("Delete this role ?"))return false;
}

$(function(){
	$('#box-admininistrator .loading-img, #box-admininistrator .overlay').hide();
	console.log("ready");
});
</script>