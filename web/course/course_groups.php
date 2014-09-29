<?php
// course groups (betauser|instructor|staff)
    
$box=new Admin\SolidBox;
$box->icon("fa fa-users");
$box->title("Groups <small>$course_id</small>");

$groups=$edxapp->courseGroups($course_id);

$htm=[];



if (isset($groups['instructor'])) {
    
    $group=$edxapp->courseGroup($groups['instructor']['id']);
    
    
    $box = new Admin\SolidBox;
    $box->icon("fa fa-users");
    $box->title("Instructor(s) <small>".count($group)." users</small>");
    
    $htm=[];
    $htm[]="<table class='table table-condensed'>";
    foreach ($group as $g) {
        $htm[]="<tr>";
        //$htm[]="<td width=30>".$g['id'];
        $htm[]="<td><a href='../user/?id=".$g['user_id']."'>".$edxapp->userName($g['user_id']);
        $htm[]="<i class='fa fa-eraser pull-right'></i>";
    }
    $htm[]="</table>";
   
    //$box->collapsed(true);
    echo $box->html($htm);
}



if (isset($groups['staff'])) {
    

    $group=$edxapp->courseGroup($groups['staff']['id']);
    
    
    $box = new Admin\SolidBox;
    $box->icon("fa fa-users");
    $box->title("Staff <small>".count($group)." users</small>");
    $htm=[];
    $htm[]="<table class='table table-condensed'>";
    foreach ($group as $g) {
        $htm[]="<tr>";
        //$htm[]="<td width=30>".$g['id'];
        $htm[]="<td><a href='../user/?id=".$g['user_id']."'>".$edxapp->userName($g['user_id']);
        $htm[]="<i class='fa fa-eraser pull-right'></i>";
    }
    $htm[]="</table>";

    //$box->collapsed(true);
    echo $box->html($htm);
}

/*
foreach ($groups as $type => $data) {
    
    
    
    $htm[]="<h4>".ucfirst($type)." group <i class='fa fa-question-circle pull-right'></i></h4>";
    $htm[]="<table class='table table-condensed table-striped'>";
    foreach ($group as $g) {
        //$htm[]=print_r($group, true);
        $htm[]="<tr>";
        $htm[]="<td>".$g['id'];
        $htm[]="<td><a href='../user/?id=".$g['user_id']."'>".$edxapp->userName($g['user_id']);
        $htm[]="<td>del</td>";
    }
    $htm[]="</table>";
    $htm[]="<hr />";
}
    
echo $box->html($htm);
*/
