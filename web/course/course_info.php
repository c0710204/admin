<?php
// course info

$shortDesc = $edxCourse->shortDescription($course_id);
$meta = $edxCourse->metadata($course_id);

//print_r($meta);

$start=@strtotime($meta['start']);
$end=@strtotime($meta['end']);
$enrollment_start=@strtotime($meta['enrollment_start']);
$enrollment_end=@strtotime($meta['enrollment_end']);

$body=[];


// display name
$body[]='<div class="form-group">';
$body[]='<label>Display name</label>';
$body[]='<input type="text" class="form-control" id="displayName" value="'.$edxCourse->displayName($course_id).'">';
$body[]='</div>';

// short description
$body[]='<div class="form-group">';
$body[]='<label>Short description</label>';
$body[]='<input type="text" class="form-control" id="shortDescription" value="'.$edxCourse->shortDescription($course_id).'">';
$body[]='</div>';


//Dates
$body[]='<div class=row>';
// course start-end
$startDates=date("d/m/Y", $start)." - ".date("d/m/Y", $end);
$body[]='<div class="col-lg-6">';
$body[]='<div class="form-group">';
$body[]='<label>Course Start-End</label>';
$body[]='<input type="text" class="form-control" id="courseStartEnd" value="'.$startDates.'">';
$body[]='</div>';
$body[]='</div>';

// enroll start-end
$enrollDates=date("d/m/Y", $enrollment_start)." - ".date("d/m/Y", $enrollment_end);
$body[]='<div class="col-lg-6">';
$body[]='<div class="form-group">';
$body[]='<label>Enroll Start-End</label>';
$body[]='<input type="text" class="form-control" id="enrollStartEnd" value="'.$enrollDates.'">';
$body[]='</div>';
$body[]='</div>';

$body[]='</div>';


$footer=[];
$footer[]="<button class='btn btn-primary' onclick='saveDesc()''><i class='fa fa-save'></i> Save</button> ";
//$footer[]="<a class='btn btn-default' href='export.php'><i class='fa fa-export'></i> Export</a> ";
$footer[]="<a class='btn btn-default pull-right' title='files' onclick='gotofiles()'><i class='fa fa-folder'></i> Files</a>";

$footer[]="<span id='courseDesc'></span>";

$box=new Admin\SolidBox;
$box->type("danger");
$box->icon("fa fa-info");
$box->title("Course info <small><a href=#>$course_id</a></small>");
$box->body($body);
$box->footer($footer);
echo $box->html();

?>
<div id='more'></div>
<script>
function saveDesc(){

    var p={
        'do':'saveDesc',
        'course_id':$('#course_id').val(),
        'displayName':$('#displayName').val(),
        'shortDescription':$('#shortDescription').val(),
        'courseStartEnd':$('#courseStartEnd').val(),
        'enrollStartEnd':$('#enrollStartEnd').val()
    };

    $('#courseDesc').html("Saving...");
    $('#courseDesc').load('ctrl.php',p,function(x){
        try{
            eval(x);
        }
        catch(e){
            console.log(e);
        }
    });

}


$(function() {
    //Date range picker with time picker
    //$('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A'});
    $('#courseStartEnd').daterangepicker();
    $('#enrollStartEnd').daterangepicker();
    console.log("ready");
});
</script>