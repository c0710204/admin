<?php
//user profile

$body=[];


// Name / Email
$body[]='<div class="row">';

//name
$body[]='<div class="col-sm-6">';
$body[]='<div class=form-group><label>Username</label>';
$body[]='<input type="text" class="form-control" id="username" placeholder="Username" value="'.$usr['username'].'">';
$body[]='</div>';
$body[]='</div>';

//email
$body[]='<div class="col-sm-6">';
$body[]='<div class=form-group><label>Email</label>';
$body[]='<input type="text" class="form-control" id="email" placeholder="Email" value="'.$usr['email'].'">';
$body[]='</div>';
$body[]='</div>';

$body[]='</div>';


///////////////////////////////
// First name - Last name
///////////////////////////////
$body[]='<div class="row">';

$body[]='<div class="col-sm-6">';
$body[]='<div class=form-group><label>First name</label>';
$body[]='<input type="text" class="form-control" id="first_name" value="'.$usr['first_name'].'">';
$body[]='</div>';
$body[]='</div>';

$body[]='<div class="col-sm-6">';
$body[]='<div class=form-group><label>Last name</label>';
$body[]='<input type="text" class="form-control" id="last_name" value="'.$usr['last_name'].'">';
$body[]='</div>';
$body[]='</div>';

$body[]='</div>';



///////////////////////////////
// Date joined - Last login
///////////////////////////////
$body[]='<div class="row">';

$body[]='<div class="col-sm-6">';
$body[]='<div class=form-group><label>Last login :</label> ';
if (preg_match("/0000/", $usr['last_login'])) {
    $body[]="<i class=text-muted>No login</i>";
} else {
    $body[]=substr($usr['last_login'], 0, 10);
}
$body[]='</div></div>';

$body[]='<div class="col-sm-6">';
$body[]='<div class=form-group><label>Date joined :</label> ' . substr($usr['date_joined'], 0, 10);
$body[]='</div></div>';

$body[]='</div>';



///////////////////////////////
// Last activity
///////////////////////////////
$data=$edxApp->studentCourseActivity($USERID, [], 1);

if (count($data[0])) {
    //print_r($data[0]);//debug

    $data[0]['modified']=str_replace(date("Y-m-d"), "", $data[0]['modified']);
    $courseName=$edxApp->courseName($data[0]['course_id']);
    
    $body[]='<div class="row">';

    $body[]='<div class="col-sm-12">';
    $body[]='<div class=form-group><label>Last activity : </label> ' . substr($data[0]['modified'],0,16);
    $body[]=" on <a href='../course/?id=".$data[0]['course_id']."'>$courseName</a>";
    $body[]='</div></div>';

    
    $body[]='</div>';
}




// checkboxes //
$body[]='<div class="row">';
$body[]='<div class="col-lg-6">';
$body[]='<label>';
if ($usr['is_active']==1) {
    $checked='checked';
} else {
    $checked='';
}
$body[]="<input type=checkbox id=is_active $checked> Active";//.$usr['is_active'];
//$body[]=$usr['is_active'];//debug
$body[]='</label>';
$body[]='</div>';
$body[]='</div>';



$footer=[];
$footer[]="<button class='btn btn-primary' onclick='saveUserInfo()'><i class='fa fa-save'></i> Save</button> ";
$footer[]="<button class='btn pull-right' onclick='resetPassword()'><i class='fa fa-lock'></i> Reset password</button>";


$title="<i class='fa fa-user'></i> User profile <small>".$usr['username']."</small>";

$box=new Admin\Box;
$box->id("boxuserinfo");
$box->type("primary");
$box->title($title);
echo $box->html($body, $footer);

echo "<div id=more></div>";

?>
<script>
function saveUserInfo(){
    var userid=$('#userid').val();

    var p={
        'do':'saveUserInfo',
        'username':$('#username').val(),
        'email':$('#email').val(),
        'first_name':$('#first_name').val(),
        'last_name':$('#last_name').val(),
        'is_active':$('#is_active:checked').val(),
        'user_id':userid
    };

    $("#more").load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

function resetPassword(){
    var p=prompt("Set new password");
    if(!p)return false;
    var userid=$('#userid').val();
    $("#more").load("ctrl.php",{'do':'resetPassword','user_id':userid,'pass':p},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

$(function(){
    $('#is_active').click(function(o){
        console.log("click",o);
    });
})
</script>