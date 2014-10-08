<?php
// course enrollment :: enroll info

$meta = $edxCourse->metadata($course_id);

//print_r($meta);

//$start=@strtotime($meta['start']);
//$end=@strtotime($meta['end']);
$enrollment_start=@strtotime($meta['enrollment_start']);
$enrollment_end=@strtotime($meta['enrollment_end']);


$body=$foot=[];


//Dates
$body[]='<div class=row>';

// Enroll start
$startDates=date("d/m/Y", $enrollment_start)." - ".date("d/m/Y", $enrollment_end);
$body[]='<div class="col-sm-6">';
$body[]='<label>Enrollment start</label>';
$body[]='<div class="input-group">';
$body[]='<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';
$body[]='<input type="text" class="form-control" value="'.date("d/m/Y", $enrollment_start).'">';
$body[]='</div>';
$body[]='</div>';

// Enroll end
$body[]='<div class="col-sm-6">';
$body[]='<label>Enrollment end</label>';
$body[]='<div class="input-group">';
$body[]='<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';
$body[]='<input type="text" class="form-control" value="'.date("d/m/Y", $enrollment_end).'">';
$body[]='</div>';
$body[]='</div>';

$body[]='</div>';


$box=new Admin\Box;
$box->type("danger");
$box->title("Course enrollment info");
$box->icon("fa fa-info");
echo $box->html($body, $foot);

