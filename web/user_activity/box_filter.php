<?php
// filter


$body=[];
$body[]="<div class='row'>";

// user search
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Student</label>";
$body[]="<input type=text class='form-control' id=student_id placeholder='Student' value='$user_id'>";
$body[]="</div>";
$body[]="</div>";


// free search
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Search</label>";
$body[]="<input type=text class='form-control' id=search placeholder='Search'>";
$body[]="</div>";
$body[]="</div>";




// get distinct courses for this user
$sql="SELECT DISTINCT course_id FROM edxapp.courseware_studentmodule WHERE student_id=$user_id;";
$q=$admin->db()->query($sql) or die("<pre>error: $sql</pre>");
$list=[];
while ($r=$q->fetch()) {
    //print_r($r);
    $list[]=$r[0];
}

// courses
//
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Select course</label>";
$body[]="<select class='form-control' id='course_id'>";
$body[]="<option value=''>Select course</option>";
//$list=$edxapp->courseids();
foreach ($list as $courseid) {
    $body[]="<option value='$courseid'>".$edxapp->coursename($courseid)."</option>";
}
$body[]="</select>";
$body[]="</div>";
$body[]="</div>";





// module type
//
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Module type</label>";
$body[]="<select class='form-control' id='module_type'>";
$body[]="<option value=''>Select module type</option>";

$list=[];
$list[]="Chapter";
$list[]="Combinedopenended";
$list[]="Course";
$list[]="Problem";
$list[]="Sequential";
$list[]="Video";
foreach ($list as $module) {
    $body[]="<option value='$module'>".$module."</option>";
}

$body[]="</select>";
$body[]="</div>";
$body[]="</div>";





// limit
//
$body[]="<div class='col-lg-1'>";
$body[]="<div class='form-group'>";
$body[]="<label>Limit</label>";
$body[]="<input type=text class='form-control' id=limit placeholder=Limit>";
$body[]="</div>";
$body[]="</div>";


$body[]="</div>";//row

$box=new Admin\SolidBox;
$box->type("danger");
$box->title("Filter");
$box->icon("fa fa-search");
$box->body($body);
echo $box->html();
