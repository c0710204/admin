<?php
// List of courses :
// echo "<h2>Distinct Courses</h2>";



//print_r($meta);
$footer=[];
//$footer[]="<button class='btn'><i class='fa fa-refresh'></i></button> ";
//$footer[]="<a href='new.php' class='btn btn-default'><i class='fa fa-plus'></i> New course</a> ";
//$footer[]="<a href='duplicate.php' class='btn btn-danger'><i class='fa fa-copy'></i> Copy</a> ";
//$footer[]="<a href='export.php' class='btn btn-danger'><i class='fa fa-upload'></i> Export</a> ";

//echo $admin->box("danger", "<i class='fa fa-book'></i> Courses", "Hello", $footer);
$box=new Admin\SolidBox;
$box->id('boxlist');
//$box->type('');
$box->icon('fa fa-list');
$box->title('Courses');
$box->body('<div>'.$box->id().'</div>');
$box->body_padding(false);
$box->loading(true);
echo $box->html();

?>
<div id='moreCourse'></div>