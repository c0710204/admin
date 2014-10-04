<?php
// Group users

$sql="SELECT id, user_id FROM edxapp.auth_user_groups WHERE group_id=$group_id;";
$q = $admin->db()->query($sql) or die(print_r($admini->db()->errorInfo(), true));

$dat=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $dat[]=$r;
}



$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($dat as $r) {
    $htm[]="<tr>";
    //$htm[]="<td width=30>".$r['id'];
    $htm[]="<td><i class='fa fa-user'></i> <a href='../user/?id=".$r['user_id']."'>".ucfirst($edxApp->userName($r['user_id']))."</a>";
    $htm[]="<i class='fa fa-times pull-right' style='cursor:hand' id=".$r['id']."></i>";
}
$htm[]="</table>";

$foot=[];
$foot="<input type=text class='form-control' id='username' placeholder='Username to add to group' autocomplete=off>";


$box=new Admin\SolidBox;
$box->id("box-users");
$box->title("Group users");
$box->icon("fa fa-users");
$box->loading(true);
echo $box->html($htm, $foot);
?>

<script>
$(function(){

	// delete
	$(".fa.fa-times.pull-right").click(function(x){
		
		if(!confirm("Remove this user from group ?"))return false;
		// console.log(x.target.id);
		var p={
			'do':'delUser',
			'group_id':$('#group_id').val(),
			'id':x.target.id
		}
		$('#box-users .overlay,#box-users .loading-img').show();
		$('#box-users .box-footer').load("ctrl.php",p,function(x){
			try{eval(x);}
			catch(e){alert("Error:"+x);}
		});
	});

	autocomplete($('#username'),'username','../typeahead/',function(x){
		console.log(x);
		if(!x.id)return false;
		if(!confirm("Add "+x.value+" to this group ?"))return false;
		var p={
			'do':'addUser',
			'group_id':$('#group_id').val(),
			'user_id':x.id,
		}
		$('#box-users .overlay,#box-users .loading-img').show();
		$('#box-users .box-footer').load("ctrl.php",p,function(x){
			try{eval(x);}
			catch(e){alert("Error:"+x);}
		});
	});
	//console.log('ready');
	$('#box-users .overlay,#box-users .loading-img').hide();
});
</script>