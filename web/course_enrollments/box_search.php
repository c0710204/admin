<?php

$htm=[];// form
$htm[]='<div class=row>';

$htm[]='<div class="col-lg-9">';
$htm[]='<div class="input-group">';
//$htm[]='<label>Search</label>';
$htm[]='<span class="input-group-addon"><i class="fa fa-search"></i></span>';
$htm[]='<input type="text" class="form-control" id="searchStr" placeholder="Search" value="">';
$htm[]='</div>';
$htm[]='</div>';


$htm[]='<div class="col-lg-3">';
$htm[]='<div class="form-group">';
//$htm[]='<label>Search</label>';
$htm[]='<input type="text" class="form-control" id="limit" placeholder="Limit" value="100">';
$htm[]='</div>';
$htm[]='</div>';

$htm[]='</div>';//end rows

$foot=[];
$foot[]="<a href='download.php?course_id=$course_id' class='btn btn-default'><i class='fa fa-file'></i> Download as csv</a>";

$box=new Admin\SolidBox;
//$box->type("danger");
$box->title("Search enrollments");
$box->icon("fa fa-search");
echo $box->html($htm, $foot);
