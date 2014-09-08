<?php
// chapter info

// MYCOMP/WS/permanent
$course_id=$ID['org'].'/'.$ID['course'].'/permanent';

$body=$foot=[];

/*
$body[]="";
$body[]='<div class="form-group">';
$body[]='<label>Course</label>';
$body[]='<div><a href=../course/?course_id='.$course_id.'>Course name</a></div>';
$body[]='</div>';
*/

$body[]='<div class=row>';

// Course Name
/*
$body[]='<div class="col-lg-12">';
$body[]='<div class="form-group">';
$body[]='<label>Course :</label> ';
$body[]='<a href="../course/?id='.$course_id.'">'.$edxapp->courseName($course_id).'</a>';
//$body[]='<input type="text" class="form-control" id="course_name" value="'.$course_id.'">';
$body[]='</div>';
$body[]='</div>';
*/

// Chapter Name
/* 
$body[]='<div class="col-lg-12">';
$body[]='<div class="form-group">';
$body[]='<label>Chapter name :</label> ';
$body[]=$unit['metadata']['display_name'];
$body[]='</div>';
$body[]='</div>';
*/
//echo "<pre>edxCourse->chapters($course_id)</pre>";
$chapters=$edxCourse->chapters($course_id);

if (is_array($chapters) && count($chapters)) {
    $body[]='<div class="col-lg-12">';
    $body[]='<i class="fa fa-book"></i> <a href="../course/?id='.$course_id.'">'.$edxapp->courseName($course_id).'</a>';
   
    $body[]="<ol>";
    foreach ($chapters as $chapter) {
        $body[]="<li>";
        if ($_GET['unit_id'] == $chapter[0]) {
            $body[]="<b>".$chapter[1]."</b>";
        } else {
            $body[]="<a href=../course_chapter/?unit_id=".$chapter[0].">".$chapter[1]."</a>";
        }
        $body[]="</li>";
    }
    $body[]="</ol>";
    $body[]='</div>';
} else {
    $body[]='<div class="col-lg-12">';
    $body[]="<label>Error: </label> no chapter found";
    $body[]='</div>';
}


// Start
if (isset($unit['metadata']['start'])) {
    $body[]='<div class="col-lg-6">';
    $body[]='<div class="form-group">';
    $body[]='<label>Start date : </label> ';
    $body[]=date("Y-m-d", strtotime($unit['metadata']['start']));
    $body[]='<input type="text" class="form-control" id="start" value="'.$unit['metadata']['start'].'">';
    $body[]='</div>';
    $body[]='</div>';
}
$body[]='</div>';

$footer=[];
$footer[]='<a href=# class="btn btn-default"><i class="fa fa-arrow-left"></i> Prev.</a> ';
$footer[]='<a href=# class="btn btn-default"><i class="fa fa-arrow-right"></i> Next</a> ';

$box=new Admin\Box;
$box->type("danger");
$box->title("Course chapter info");
$box->icon('fa fa-info');
echo $box->html($body, $footer);

//echo "<pre>"; print_r($ID); echo "</pre>";
?>
<style>
ul.location {list-style-type: none;}
</style>