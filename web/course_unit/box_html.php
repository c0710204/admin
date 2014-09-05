<?php
// course unit - html editor

//$unit=$edxCourse->unit($unit_id);
//$metadata=$unit['metadata'];
//print_r($unit);

$html='bob';
$html=$unit['definition']['data']['data'];

$body=$foot=[];

$body[]='<textarea id="editor1" placeholder="Enter text ..." style="width:100%;height:350px">'.$html.'</textarea>';

$foot[]="<a href=# class='btn btn-default'><i class='fa fa-save'></i> Save html</a>";

$box=new Admin\SolidBox;
$box->type("primary");
$box->icon("fa fa-code");
$box->title("Html");
$box->body($body);
$box->footer($foot);
echo $box->html();
?>

<script>
function saveHtml(){
	/*
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
	*/
}

$('#editor1').ckeditor( function( textarea ) {
   //console.log("textarea is ready", textarea);
});
</script>