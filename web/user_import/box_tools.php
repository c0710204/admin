<?php
// admin :: User import -> box tools


$box = new Admin\SolidBox;
$box->id('boxtools');
$box->icon('fa fa-wrench');
$box->title("Import users");

$foot=[];
$foot[]="<a href=# class='btn btn-default' id='btnAdd'><i class='fa fa-user'></i> Add user</a> ";
$foot[]="<a href=# class='btn btn-default' id='btnUpload'><i class='fa fa-upload'></i> Upload xls</a> ";
$foot[]="<a href=# class='btn btn-default' id='btnPaste'><i class='fa fa-clipboard'></i> Paste clipboard</a> ";
$foot[]="<a href=# class='btn btn-danger pull-right' id='btnTrash'><i class='fa fa-trash-o'></i> Clear list</a> ";
echo $box->html($foot);
?>
<script>
function addUser(){
	
	var p=prompt("Enter email address");
	if(!p)return;
	    
    var atpos = p.indexOf("@");
    var dotpos = p.lastIndexOf(".");
    
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=p.length) {
        alert("Not a valid e-mail address !");
        return false;
    }

	$("#boxlist .overlay, #boxlist .loading-img").show();
	$("#boxlist .box-body").load("ctrl.php",{'do':'addUser','email':p},function(x){
		try{
			eval(x);
		}
		catch(e){
			console.log('error',e);
			$("#boxlist .overlay, #boxlist .loading-img").hide();
		}
	});
}

$(function(){
	
	$('#btnAdd').click(function(){
		addUser();
	});

	$('#btnTrash').click(function(){
		if(!confirm("Clear temporary user list ?"))return false;

		$("#boxlist .overlay, #boxlist .loading-img").show();
		$('#boxlist .box-body').load("ctrl.php",{'do':'clearList'},function(){
			try{
				eval(x);
			}
			catch(e){
				console.log('error',x);
				$("#boxlist .overlay, #boxlist .loading-img").hide();
			}
		});
	});
});
</script>