<?php
/*
 * admin :: edx files debug
 */
$body=[];
$body[]='<form action="upload.php" id=fileform method=POST enctype="multipart/form-data" target=new>';//uploadframe
//$body[]='<label>File input</label>';
$body[]='<input type="file" name=file id="file">';//file
$body[]='<input type="hidden" id="destcourse_id" name="course_id" value="">';//org
$body[]='</form>';
$body[]='<iframe name="uploadframe" width=10 height=10></iframe>';


$footer=[];
$footer="<button class='btn' onclick=uploadFile()><i class='fa fa-upload'></i> Upload</button>";
$box = new Admin\SolidBox;
$box->type('success');
$box->icon('fa fa-upload');
$box->title('Upload');
echo $box->html($body, $footer);
?>
<script>
function uploadFile()
{
	var course_id=$
	$('#destcourse_id').val($('#course_id').val());

	if(!$('#destcourse_id').val()){
		alert("Select a course first");
		return false;
	}

	$('#fileform').submit();
}
</script>