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
/*
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Search</label>";
$body[]="<input type=text class='form-control' id=search placeholder='Search'>";
$body[]="</div>";
$body[]="</div>";
*/



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
/*
$list[]="Chapter";
$list[]="Combinedopenended";
$list[]="Course";
$list[]="Problem";
$list[]="Sequential";
$list[]="Video";
*/
// from edxapp->categoryIcon
$ICON['course']="<i class='fa fa-book' title='Course'></i>";
$ICON['combinedopenended']="<i class='fa fa-book' title='combinedopenended'></i>";
$ICON['chapter']="<i class='fa fa-bookmark' title='Chapter'></i>";
$ICON['discussion']="<i class='fa fa-comments' title='Discussion'></i>";
$ICON['sequential']="<i class='fa fa-caret-square-o-right' title='Sequencial'></i>";
$ICON['textbook']="<i class='fa fa-file-pdf-o' title='Textbook'></i>";
$ICON['vertical']="<i class='fa fa-arrow-down' title='Vertical'></i>";
$ICON['html']="<i class='fa fa-code' title='Html'></i>";
$ICON['video']="<i class='fa fa-film' title='Video'></i>";
$ICON['peergrading']="<i class='fa fa-question' title='Peergrading'></i>";
$ICON['problem']="<i class='fa fa-question-circle' title='Problem'></i>";

foreach ($ICON as $module=>$icon) {
    $body[]="<option value='$module'>".ucfirst($module)."</option>";
}

$body[]="</select>";
$body[]="</div>";
$body[]="</div>";


// limit
$body[]="<div class='col-lg-1'>";
$body[]="<div class='form-group'>";
$body[]="<label>Limit</label>";
$body[]="<input type=text class='form-control' id=limit placeholder=Limit>";
$body[]="</div>";
$body[]="</div>";


// export
/*
$body[]="<div class='col-lg-1'>";
$body[]="<div class='form-group'>";
//$body[]="<label>Export</label>";
$body[]="<a href=# class='btn btn-default'>Excel</a>";
//$body[]="<inout class=btn>Excel</button>";
$body[]="</div>";
$body[]="</div>";
*/

// Button download
$body[]='<div class="col-xs-2">';
$body[]='<div class="form-group">';
$body[]="<label>Export</label><br />";
//$body[]='<a href=# class="btn btn-default"><i class="fa fa-file"></i> Download as xls</a>';
$body[]='<a href=# id=btn_download class="btn btn-default"><i class="fa fa-file"></i> Download as xls</a>';
$body[]='</div>';
$body[]='</div>';



$body[]="</div>";//row

$box=new Admin\SolidBox;
$box->type("danger");
$box->title("Filter");
$box->icon("fa fa-search");
echo $box->html($body);
