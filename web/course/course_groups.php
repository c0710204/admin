<?php
// course groups (betauser|instructor|staff)
    
$groups=$edxapp->courseGroups($course_id);// list of course groups 

//echo "<pre>".print_r($groups, true)."</pre>";// debug


// Instructors
// Instructors
// Instructors
if (isset($groups['instructor'])) {
    
    $group=$edxapp->courseGroup($groups['instructor']['id']);
    
    
    $box = new Admin\SolidBox;
    $box->id("box-instructor");
    $box->icon("fa fa-users");
    $box->title("Instructor(s) <small><a href='../group/?id=".$groups['instructor']['id']."'>group #".$groups['instructor']['id']."</a></small>");
    
    $htm=[];
    $htm[]="<table class='table table-condensed table-striped'>";
    foreach ($group as $g) {
        $htm[]="<tr>";
        //$htm[]="<td width=30>".$g['id'];
        $htm[]="<td>";
        $htm[]="<i class='fa fa-user'></i> ";
        $htm[]="<a href='../user/?id=".$g['user_id']."'>".ucfirst($edxapp->userName($g['user_id']))."</a>";
        $htm[]="<i class='fa fa-times pull-right' onclick=delCG($g[id])></i>";
    }
    $htm[]="</table>";
   
    $footer="<input type=text class='form-control' id='instructors' placeholder='User name to add to instructor' autocomplete=off>";
    echo $box->html($htm, $footer);
}


// Staff
// Staff
// Staff
if (isset($groups['staff'])) {
    
    $group=$edxapp->courseGroup($groups['staff']['id']);
    
    $box = new Admin\SolidBox;
    $box->id("box-staff");
    $box->icon("fa fa-users");
    $box->title("Staff <small><a href='../group/?id=".$groups['staff']['id']."'>group #".$groups['staff']['id']."</a></small>");
    $htm=[];
    $htm[]="<table class='table table-condensed table-striped'>";
    foreach ($group as $g) {
        $htm[]="<tr>";
        //$htm[]="<td width=30>".$g['id'];
        $htm[]="<td>";
        $htm[]="<i class='fa fa-user'></i> ";
        $htm[]="<a href='../user/?id=".$g['user_id']."'>".ucfirst($edxapp->userName($g['user_id']))."</a>";
        $htm[]="<i class='fa fa-times pull-right' onclick=delCG($g[id])></i>";
    }
    $htm[]="</table>";

    $footer="<input type=text class='form-control' id='staff' placeholder='Username to add to staff' autocomplete=off>";
    echo $box->html($htm, $footer);
}


// Beta users
// Beta users
// Beta users
if (isset($groups['Beta ...'])) {
    //more code here
}
?>

<script>

// Remove a user from a group
function delCG(id){

    if(!confirm("delCG("+id+")"))return false;
    
    var p = {
        'do':'delCG',
        'id':id
    }
    
    $("#moregroups").load("ctrl.php",p,function(){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

$(function(){
    
    // instructors group
    autocomplete($('#instructors'),'username','../typeahead/',function(x){
        console.log(x);
        if(!x.id)return false;
        if(!confirm("Add "+x.value+" as instructor ?"))return false;
        var p={
            'do':'addInstructor',
            'course_id':$('#course_id').val(), 
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
    });
    console.log("autocomplete ready");
});

</script>