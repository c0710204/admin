<?php
// Group users

$sql="SELECT id, user_id FROM edxapp.auth_user_groups WHERE group_id=$group_id;";
$q = $admin->db()->query($sql) or die(print_r($admini->db()->errorInfo(), true));

$dat=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $dat[]=$r;
}

$box=new Admin\SolidBox;
$box->id("box-users");
$box->title("Group users");
$box->icon("fa fa-users");


$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($dat as $r) {
    $htm[]="<tr>";
    //$htm[]="<td width=30>".$r['id'];
    $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$r['user_id']."'>".$edxApp->userName($r['user_id']);
    $htm[]="<td><a href=#del class='btn pull-right'><i class='fa fa-eraser'></i></a>";
}
$htm[]="</table>";

$foot=[];
$foot="<input type=text class='form-control' id='username' placeholder='Username to add to group' autocomplete=off>";
$box->loading(true);
echo $box->html($htm, $foot);
?>

<script>
$(function(){
	autocomplete($('#username'),'username','../typeahead/',function(x){
		console.log(x);
		if(!x.id)return false;
		if(!confirm("Add "+x.value+" to this group ?"))return false;
		//$()
	});
	//console.log('ready');
	$('#box-users .overlay,#box-users .loading-img').hide();
});
</script>