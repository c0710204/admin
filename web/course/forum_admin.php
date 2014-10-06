<?php
// course forum 
// - administrators
// - moderators
// - student ta's 

$htm=[];


// Forum admin and moderators
$Roles=$edxapp->clientRoles($course_id);
//echo "<pre>".print_r($Roles, true)."</pre>";


// Forum Admnistrators
// Forum Admnistrators
// Forum Admnistrators

$users=$edxapp->clientRoleUsers($Roles['Administrator']);
$htm=[];
if (count($users)) {
    $htm[]="<table class='table table-condensed table-striped'>";
    foreach ($users as $k => $user_id) {
        $htm[]="<tr>";
        $htm[]="<td>";
        $htm[]="<i class='fa fa-user'></i> ";
        $htm[]="<a href='../user/?id=$user_id'>".ucfirst($edxapp->userName($user_id))."</a>";//nothin
        $htm[]="<i class='fa fa-times pull-right' style='cursor:hand' onclick=delRole($k) ></i>";//
    }
    $htm[]="</table>";
} else {
    $htm[]="<pre>No forum administrator</pre>";
}


$box=new Admin\Box;
$box->id('box-admins');
$box->type('success');
$box->icon('fa fa-comments-o');
$box->title("Forum Administrator(s)");

$footer=[];
$footer="<input type=text class='form-control' id='admins' placeholder='Username to add as forum admin' autocomplete=off>";
echo "<input type='hidden' id='role_admin' value='".$Roles['Administrator']."'>";//
echo $box->html($htm, $footer);




// Forum Moderators
// Forum Moderators
// Forum Moderators

$users=$edxapp->clientRoleUsers($Roles['Moderator']);
$htm=[];
if (count($users)) {
    $htm[]="<table class='table table-condensed table-striped'>";
    foreach ($users as $k => $user_id) {
        $htm[]="<tr>";
        $htm[]="<td>";
        $htm[]="<i class='fa fa-user'></i> ";
        $htm[]="<a href='../user/?id=$user_id'>".ucfirst($edxapp->userName($user_id))."</a>";//nothin
        $htm[]="<i class='fa fa-times pull-right' style='cursor:hand' onclick=delRole($k)></i>";//
    }
    $htm[]="</table>";
} else {
    $htm[]="<pre>No forum moderator</pre>";
}

$box=new Admin\Box;
$box->id('box-moderator');
$box->type('success');
$box->icon('fa fa-comments-o');
$box->title("Forum Moderator(s)");
//$box->loading(true);
$footer=[];
$footer="<input type=text class='form-control' id='moders' placeholder='Username to add as forum moderator' autocomplete=off>";
echo "<input type='hidden' id='role_moderator' value='".$Roles['Moderator']."'>";//
echo $box->html($htm, $footer);



?>
<script>
function delRole(userroleid)
{
    if(!confirm("Delete role #"+userroleid+" ?"))return false;
    
    var p={
        'do':'delRole',
        'course_id':$('#course_id').val(),
        'id':userroleid,
    };
    $("#box-admins .box-footer").load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

function addRole(roleId, userId)
{
    console.log("addRole("+roleId+", "+userId+")");
    if(!roleId)return false;
    if(!userId)return false;
    if(!confirm("Add role for user "+userId+" ?"))return false;
    
    //$('#box-admins .loading-img, #box-admininistrator .overlay').show();
    var p={
        'do':'addRole',
        'course_id':$('#course_id').val(),
        'role_id':roleId,
        'user_id':userId
    };
    
    $("#box-admins .box-footer").load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
        //$('#box-admininistrator .loading-img, #box-admininistrator .overlay').hide();
    });
}

$(function(){
        
    autocomplete( $('#admins'), 'username', '../typeahead/', function(x){
        console.log(x);
        addRole($('#role_admin').val(), x.id);// add role user
    });

    autocomplete( $('#moders'), 'username', '../typeahead/', function(x){   
        console.log(x);
        addRole($('#role_moderator').val(), x.id);// add role user
    });
    
    //console.log("ready");
});
</script>