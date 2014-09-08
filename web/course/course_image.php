<?php
// course image


//$meta = $edxCourse->metadata();
//$shortDesc = $edxCourse->shortDescription();


$body=[];

$body[]='<div class="form-group">';

//course image
if (isset($meta['course_image'])) {
    /*
    $body[]='<div class="form-group">';
    $body[]='<label>Course image</label>';
    $body[]='<input type="text" class="form-control" disabled="" value="'.$meta['course_image'].'">';
    $body[]='</div>';
    */
    $body[]='<div class="form-group" style="text-align:center">';
    $body[]='<div class="cover">';
    $body[]='<img src="thumbnail.php?name='.$meta['course_image'].'" width=180 alt="'.$meta['course_image'].'">';
    $body[]='</div>';
    $body[]='</div>';

} else {
    $body[]='<div class="form-group">No course image</div>';
}


$body[]='<form action="image_upload.php" id=fileform method=POST target=_blank enctype="multipart/form-data">';
//$body[]='<label>File input</label>';
$body[]='<input type="file" name=file id="imageFile">';//file
//$body[]='<p class="help-block">Try to be nice.</p>';
$body[]='<input type="hidden" name="course_id" value="'.$course_id.'">';//course_id
$body[]='</form>';
$body[]='</div>';

// FOOTER
$footer=[];
$footer[]="<button class='btn btn-primary' onclick='uploadImg()''><i class='fa fa-save'></i> Upload</button>";
$footer[]="&nbsp;";
$footer[]="<button class='btn' onclick='updateImg()''><i class='fa fa-save'></i> Update</button>";
$footer[]="&nbsp;";
$footer[]="<button class='btn' title='files' onclick='gotofiles()'><i class='fa fa-folder'></i> Browse</button>";
$footer[]="<span id='courseImg'></span>";
if (isset($meta['course_image'])) {
    $small="<small>".$meta['course_image']."</small>";
} else {
    $small="<small>No image</small>";
}
$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-info');
$box->title("Course image $small");
$box->body($body);
$box->footer($footer);
//'collapse');
echo $box->html();
?>
<script>
function uploadImg(){
    $("#fileform").submit();
}

function updateImg(){
    var p=prompt("Set new filename");
    if(!p)return false;
    var p={
        'do':'updateImage',
        'course_id':$('#course_id').val(),
        'filename':p
    };
    $('#courseImg').load("ctrl.php",p,function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}

function gotofiles(){
    var url='../files/?course_id='+$('#course_id').val();
    window.open(url);
}
</script>