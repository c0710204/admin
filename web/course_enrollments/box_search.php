<?php
// search

$htm=[];// form
$htm[]='<div class=row>';

$htm[]='<div class="col-xs-6">';
$htm[]='<div class="input-group">';
//$htm[]='<label>Search</label>';
$htm[]='<span class="input-group-addon"><i class="fa fa-search"></i></span>';
$htm[]='<input type="text" class="form-control" id="searchStr" placeholder="Search username or email address" value="">';
$htm[]='</div>';
$htm[]='</div>';


// joined
$htm[]='<div class="col-xs-2">';
$htm[]='<div class="input-group">';
$htm[]='<span class="input-group-addon"><i class="fa fa-calendar"></i></span>';
$htm[]='<input type="text" class="form-control" id="date">';
$htm[]='</div>';
$htm[]='</div>';


$htm[]='<div class="col-xs-1">';
$htm[]='<div class="form-group">';
//$htm[]='<label>Search</label>';
$htm[]='<input type="text" class="form-control" id="limit" placeholder="Limit" value="100">';
$htm[]='</div>';
$htm[]='</div>';


// Button download
$htm[]='<div class="col-xs-2">';
$htm[]='<div class="form-group">';
$htm[]='<a href="download.php?course_id='.$course_id.'" class="btn btn-default"><i class="fa fa-file-excel-o"></i> Download Xls</a>';
$htm[]='</div>';
$htm[]='</div>';



$htm[]='</div>';//end rows


$foot=[];
//$foot[]="<a href='download.php?course_id=$course_id' class='btn btn-default'><i class='fa fa-file'></i> Download as csv</a>";

$box=new Admin\SolidBox;

$count=$edxApp->enrollCount($course_id);

$box->title("Search enrollments <small>".number_format($count)." enrollments</small>");
$box->icon("fa fa-search");
echo $box->html($htm, $foot);
