<?php
// Course overview

//echo "<br />";
$body = $edxCourse->overview();

$HTM[]='<textarea id="editor1" placeholder="Enter text ..." style="width:100%;height:240px">'.$body.'</textarea>';

$footer=[];
$footer[]="<button class='btn btn-primary' onclick='saveOverview()'><i class='fa fa-save'></i> Save</button>";
$footer[]="<span id='courseOverview'></span>";


echo $admin->box("primary", "<i class='fa fa-edit'></i> Course overview", $HTM, $footer);
?>
<script>
function saveOverview(){

	var p={
		'do':'saveOverview',
		'course_id':$('#course_id').val(),
		'html':$('#editor1').val()
	}

	$('#courseOverview').html("Saving...");
	$('#courseOverview').load("ctrl.php",p,function(x){
		try{ eval(x); }
		catch(e){ alert(x); }
	});
}

$('#editor1').ckeditor( function( textarea ) {
   //console.log("textarea is ready", textarea);
});
</script>