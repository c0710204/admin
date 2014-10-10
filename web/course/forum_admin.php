<?php
// course forum 
// - administrators
// - moderators
// - student ta's 



// Forum admin and moderators
$Roles=$edxapp->clientRoles($course_id);
//echo "<pre>".print_r($Roles, true)."</pre>";


// Forum Admnistrators
// Forum Admnistrators
// Forum Admnistrators

$users=$edxapp->clientRoleUsers(@$Roles['Administrator']);
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
$box->collapsed(true);

if (isset($Roles['Administrator'])) {
    $htm[]="<input type=text class='form-control' id='admins' placeholder='Username to add as forum admin' autocomplete=off>";
    echo "<input type='hidden' id='role_admin' value='".$Roles['Administrator']."'>";//
} else {
    $htm[]="<pre>Warning: No administrator role</pre>";
}

// administrator permissions
$permList=$edxapp->forumClientPermissions();// list of forum permissions

$foot=[];
$foot[]="<b>Administrator permissions:</b><br />";
foreach ($edxapp->clientPermissions($Roles['Administrator']) as $k => $perm) {
    $v = str_replace("_", " ", ucfirst($perm));
    $foot[]="<a href=#del class='btn btn-default' onclick=delPerm($k)>$v <i class='fa fa-times'></i></a> ";
    if (($key = array_search($perm, $permList)) !== false) {
        unset($permList[$key]);
    }
}

// add permission
if (count($permList)) {
    $foot[]='<br />';
    $foot[]='<br />';
    $foot[]='<div class=row>';
    $foot[]='<div class="col-xs-12">';
    $foot[]="<select class='form-control' onchange=addPerm('".$Roles['Administrator']."',this);>";
    $foot[]="<option>Select permission to add</option>";
    foreach ($permList as $value) {
        $foot[]= "<option value='$value'>".str_replace('_', ' ', ucfirst($value))."</option>";
    }
    $foot[]= "</select>";
    $foot[]= "</div>";
    $foot[]= "</div>";//end row
}

echo $box->html($htm, $foot);




// Forum Moderators
// Forum Moderators
// Forum Moderators

$users=$edxapp->clientRoleUsers(@$Roles['Moderator']);
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
$box->collapsed(true);
if (isset($Roles['Moderator'])) {
    $htm[]="<input type=text class='form-control' id='moders' placeholder='Username to add as forum moderator' autocomplete=off>";
    echo "<input type='hidden' id='role_moderator' value='".$Roles['Moderator']."'>";//
} else {
    $htm[]="<pre>Warning: No moderator role</pre>";
}

// moderator permissions

$permList=$edxapp->forumClientPermissions();// list of forum permissions

$foot=[];
$foot[]="<b>Moderator permissions:</b><br />";
foreach ($edxapp->clientPermissions($Roles['Moderator']) as $k => $perm) {
    $v = str_replace("_", " ", ucfirst($perm));
    $foot[]="<a href=#del class='btn btn-default' onclick=delPerm($k)>$v <i class='fa fa-times'></i></a> ";
    if (($key = array_search($perm, $permList)) !== false) {
        unset($permList[$key]);
    }
}

// add permission
if (count($permList)) {
    $foot[]='<br />';
    $foot[]='<br />';
    $foot[]='<div class=row>';
    $foot[]='<div class="col-xs-12">';
    $foot[]="<select class='form-control' onchange=addPerm('".$Roles['Moderator']."',this);>";
    $foot[]="<option>Select permission to add</option>";
    foreach ($permList as $value) {
        $foot[]= "<option value='$value'>".str_replace('_', ' ', ucfirst($value))."</option>";
    }
    $foot[]= "</select>";
    $foot[]= "</div>";
    $foot[]= "</div>";//end row
}

echo $box->html($htm, $foot);




// Forum Teacher Assistant's
// Forum Teacher Assistant's
// Forum Teacher Assistant's

$users=$edxapp->clientRoleUsers(@$Roles['Community TA']);

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
    $htm[]="<pre>No forum TA's</pre>";
}


if (isset($Roles['Community TA'])) {
    $htm[]="<input type=text class='form-control' id='tas' placeholder='Username to add as forum TA' autocomplete=off>";
    echo "<input type='hidden' id='role_ta' value='".$Roles['Community TA']."'>";//
} else {
    $htm[]="<pre>Warning: No Community TA role</pre>";
}

//ta's permissions
$foot=[];
$foot[]="<b>Permissions:</b><br />";
$permList=$edxapp->forumClientPermissions();
foreach ($edxapp->clientPermissions($Roles['Community TA']) as $k => $perm) {
    $v = str_replace("_", " ", ucfirst($perm));
    $foot[]="<a href=#del class='btn btn-default' title='$k' onclick=delPerm($k)>$v <i class='fa fa-times'></i></a> ";
}


// add permission
$foot[]='<br />';
$foot[]='<br />';
$foot[]='<div class=row>';
$foot[]='<div class="col-xs-12">';
$foot[]="<select class='form-control' onchange=addPerm('".$Roles['Community TA']."',this);>";
$foot[]="<option>Select permission to add</option>";
foreach ($permList as $value) {
    $foot[]= "<option value='$value'>".str_replace('_', ' ', ucfirst($value))."</option>";
}
$foot[]= "</select>";
$foot[]= "</div>";
$foot[]= "</div>";//end row


$box=new Admin\Box;
$box->id('box-ta');
$box->type('success');
$box->icon('fa fa-comments-o');
$box->title("Forum TA's <small>teacher assistant</small>");
$box->collapsed(true);
echo $box->html($htm, $foot);





// Forum Students
// Forum Students
// Forum Students

$box=new Admin\Box;
$box->id('box-students');
$box->type('success');
$box->icon('fa fa-comments-o');
$box->title("Forum Students permissions");


$htm=$foot=[];
$permList=$edxapp->forumClientPermissions();
foreach ($edxapp->clientPermissions($Roles['Student']) as $k => $perm) {
    $v = str_replace("_", " ", ucfirst($perm));
    $htm[]="<a href=#del class='btn btn-default' onclick=delPerm($k) title='Click to delete'>$v <i class='fa fa-times'></i></a> ";
    if (($key = array_search($perm, $permList)) !== false) {
        unset($permList[$key]);
    }
}

// add permission
$foot[]='<div class=row>';
$foot[]='<div class="col-xs-12">';
$foot[]="<select class='form-control' onchange=addPerm('".$Roles['Student']."',this);>";
$foot[]="<option>Select permission to add</option>";
foreach ($permList as $value) {
    $foot[]= "<option value='$value'>".str_replace('_', ' ', ucfirst($value))."</option>";
}
$foot[]= "</select>";
$foot[]= "</div>";
$foot[]= "</div>";//end row

echo $box->html($htm, $foot);

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


function delPerm(permid)
{
    if(!permid)return false;
    if(!confirm("Remove this forum permission #"+permid+" ?"))return false;
    var p={
        'do':'delForumPermission',
        'course_id':$('#course_id').val(),
        'id':permid,
    };
    $("#box-students .box-body").load("ctrl.php",p,function(x){
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


function addPerm(roleId, o){
    console.log(roleId, o);
    if(!roleId)return false;
    if(!confirm("Add permission '"+o.value+"' ?"))return false;
    var p={
        'do':'addForumPermission',
        'role_id':roleId,
        'course_id':$('#course_id').val(),
        'permission':o.value
    };
    $("#box-students .box-footer").html("Please wait...");
    $("#box-students .box-footer").load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
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

    autocomplete( $('#tas'), 'username', '../typeahead/', function(x){   
        console.log(x);
        addRole($('#role_ta').val(), x.id);// add role user
    });
    
    //console.log("ready");
});
</script>