<?php
// course info

$shortDesc = $edxCourse->shortDescription($course_id);
$meta = $edxCourse->metadata($course_id);

//echo "<pre>"; print_r($meta); echo "</pre>";

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

//$startDates=date("d/m/Y", $start)." - ".date("d/m/Y", $end);

// course start
$body[]='<div class="col-lg-6">';
$body[]='<label>Course Start</label>';
$body[]='<div class="input-group">';
$body[]='<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';//calendar icon
$body[]='<input type="text" class="form-control" id="courseStart" value="'.date("d/m/Y", $start).'">';
$body[]='</div>';
$body[]='</div>';

// course end
$body[]='<div class="col-lg-6">';
$body[]='<label>Course End</label>';
$body[]='<div class="input-group">';
$body[]='<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';//calendar icon
$body[]='<input type="text" class="form-control" id="courseEnd" value="'.date("d/m/Y", $end).'">';
$body[]='</div>';
$body[]='</div>';

$body[]='</div>';


// enroll start-end
$body[]='<div class=row>';

$body[]='<div class="col-lg-6">';
$body[]='<label>Enrollment Start</label>';
$body[]='<div class="input-group">';
$body[]='<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';//calendar icon
$body[]='<input type="text" class="form-control" id="enrollStart" value="'.date("d/m/Y", $enrollment_start).'">';
$body[]='</div>';
$body[]='</div>';

// course end
$body[]='<div class="col-lg-6">';
$body[]='<label>Enrollment End</label>';
$body[]='<div class="input-group">';
$body[]='<div class="input-group-addon"><i class="fa fa-calendar"></i></div>';//calendar icon
$body[]='<input type="text" class="form-control" id="enrollEnd" value="'.date("d/m/Y", $enrollment_end).'">';
$body[]='</div>';
$body[]='</div>';

$body[]='</div>';



$footer=[];
$footer[]="<button class='btn btn-primary' onclick='saveDesc()''><i class='fa fa-save'></i> Save course info</button> ";
//$footer[]="<a class='btn btn-default' href='export.php'><i class='fa fa-export'></i> Export</a> ";
//$footer[]="<a class='btn btn-default pull-right' title='files' onclick='gotofiles()'><i class='fa fa-folder'></i> Files</a>";

$footer[]="<span id='courseDesc'></span>";

$box=new Admin\Box;
$box->id("boxinfo");
$box->type("danger");
$box->icon("fa fa-info");
$box->title("Course info");// <small><a href=#>$course_id</a></small>
$box->loading(true);// <small><a href=#>$course_id</a></small>
echo $box->html($body, $footer);

?>
<div id='more'></div>
<script>

function saveDesc(){

    var p={
        'do':'saveDesc',
        'course_id':$('#course_id').val(),
        'displayName':$('#displayName').val(),
        'shortDescription':$('#shortDescription').val(),
        'courseStart':$('#courseStart').val(),
        'courseEnd':$('#courseEnd').val(),
        'enrollStart':$('#enrollStart').val(),
        'enrollEnd':$('#enrollEnd').val()
    };

    $('#boxinfo .loading-img, #boxinfo .overlay').show();
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
    
    //$('#courseStart').datepicker();
    //$('#courseEnd').datepicker();

    //Datemask dd/mm/yyyy
    $("#courseStart").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    //Datemask2 mm/dd/yyyy
    $("#courseEnd").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    
    $("#enrollStart").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
    $("#enrollEnd").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});

    $('#boxinfo .loading-img, #boxinfo .overlay').hide();
    console.log("ready");
});
</script>