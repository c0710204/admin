<?php
// course groups (betauser|instructor|staff)
    
$groups=$edxapp->courseGroups($course_id);// list of course groups 

//echo "<pre>".print_r($groups, true)."</pre>";// debug


// Instructors
// Instructors
// Instructors

$group=$edxapp->courseGroup(@$groups['instructor']['id']);


$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($group as $g) {
    $htm[]="<tr>";
    $htm[]="<td>";
    $htm[]="<i class='fa fa-user'></i> ";
    $htm[]="<a href='../user/?id=".$g['user_id']."'>".ucfirst($edxapp->userName($g['user_id']))."</a>";
    $htm[]="<i class='fa fa-times pull-right' style='cursor:hand' onclick=delGroupUser($g[id])></i>";
}
$htm[]="</table>";


$box = new Admin\SolidBox;
$box->id("box-instructor");
$box->icon("fa fa-users");

if (isset($groups['instructor']['id'])) {
    echo "<input type=hidden id='instructor_group_id' value=".$groups['instructor']['id'].">";// instructor group id
    $small="<small><a href='../group/?id=".$groups['instructor']['id']."'>group #".$groups['instructor']['id']."</a></small>";
    $box->footer("<input type=text class='form-control' id='instructors' placeholder='User name to add to instructor' autocomplete=off>");
} else {
    $small='';
    $box->footer("<pre>Warning: no instructor group</pre>");
}

$box->title("Instructor(s) $small");
$box->collapsed(true);
echo $box->html($htm);






// Staff
// Staff
// Staff
    
$group=$edxapp->courseGroup(@$groups['staff']['id']);


$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($group as $g) {
    $htm[]="<tr>";
    $htm[]="<td>";
    $htm[]="<i class='fa fa-user'></i> ";
    $htm[]="<a href='../user/?id=".$g['user_id']."'>".ucfirst($edxapp->userName($g['user_id']))."</a>";
    $htm[]="<i class='fa fa-times pull-right' style='cursor:hand' onclick=delGroupUser($g[id])></i>";
}
$htm[]="</table>";


$box = new Admin\SolidBox;
$box->id("box-staff");
$box->icon("fa fa-users");

if (isset($groups['staff']['id'])) {
    echo "<input type=hidden id='staff_group_id' value=".$groups['staff']['id'].">";// staff group id
    $small="<small><a href='../group/?id=".$groups['staff']['id']."'>group #".$groups['staff']['id']."</a></small>";
    $footer="<input type=text class='form-control' id='staff' placeholder='Username to add to staff' autocomplete=off>";
} else {
    $small='';
    $footer="<pre>Warning: no staff group</pre>";
}

$box->title("Staff $small");
$box->collapsed(true);


echo $box->html($htm, $footer);






// Beta users
// Beta users
// Beta users
if (isset($groups['Beta ...'])) {
    //more code here
}
?>

<script>

// Remove a user from a group
function delGroupUser(id){

    if(!confirm("Remove from group ?"))return false;
    
    var p = {
        'do':'removeGroupUser',
        'course_id':$('#course_id').val(),
        'id':id
    }
    
    $('#box-instructor .box-footer').load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

$(function(){
    
    // instructors group
    autocomplete($('#instructors'),'username','../typeahead/',function(x){
        
        //console.log(x);
        if(!x.id)return false;
        if(!confirm("Add "+x.value+" as instructor ?"))return false;
        
        var p={
            'do':'addGroupUser',
            'course_id':$('#course_id').val(), 
            'group_id':$('#instructor_group_id').val(), 
            'user_id':x.id
        };
        //console.log(p);
        $('#box-instructor .box-footer').html("Please wait...");
        $('#box-instructor .box-footer').load("ctrl.php",p,function(x){
            try{eval(x);}
            catch(e){alert(x);}
        });
    });


    // staff group
    autocomplete($('#staff'),'username','../typeahead/',function(x){
        console.log(x);
        if(!x.id)return false;
        if(!confirm("Add "+x.value+" as staff ?"))return false;
        var p={
            'do':'addGroupUser',
            'course_id':$('#course_id').val(), 
            'group_id':$('#staff_group_id').val(), 
            'user_id':x.id
        };
        $('#box-staff .box-footer').html("Please wait...");
        $('#box-staff .box-footer').load("ctrl.php",p,function(x){
            try{eval(x);}
            catch(e){alert(x);}
        });
    });

    console.log("autocomplete ready");
});

</script>