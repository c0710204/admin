<?php
//admin :: static tab
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxCourse;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Static tab");

//$edxapp = new EdxApp("../config.json");
$course = new EdxCourse("../config.json", @$_GET['org'], @$_GET['course']);

echo $admin->printPrivate();

?>


<section class="content-header">
    <h1><i class='fa fa-book'></i> Static Tab <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<?php

$id='80074d8417cf4d40af55b06359b0b408';

$data=$course->staticTab($id);
$title=$data['metadata']['display_name'];
$body=$data['definition']['data']['data'];


$HTM[]='<div class="form-group">';
$HTM[]='<label>Display name</label>';
$HTM[]='<input type="text" class="form-control" id="displayName" value="'.$data['metadata']['display_name'].'">';
$HTM[]='</div>';

$HTM[]='<textarea id="editor1" placeholder="Enter text ..." style="width:100%;height:240px">'.$body.'</textarea>';

// FOOTER //
$footer=[];
$footer[]="<button class='btn btn-primary' onclick='saveTab()'><i class='fa fa-save'></i> Save</button>";
$footer[]="<button class='btn btn-danger pull-right' onclick='trashTab()'><i class='fa fa-trash-o'></i></button>";
$footer[]="<span id='more'></span>";

echo $admin->box("primary", "<i class='fa fa-edit'></i> Static Tab", $HTM, $footer);

?>
<script>
function saveTab(){
	var p={
		'do':'saveOverview',
		'org':$('#org').val(),
		'coursename':$('#coursename').val(),
		'html':$('#editor1').val()
	}
	$('#more').html("Saving...");
	$('#more').load("ctrl.php",p,function(x){
		try{eval(x);}
		catch(e){alert(x);}
	});
}


function trashTab(){
	if(!confirm("Delete this tab ?"))return false;
	var p={};
}


$('#editor1').ckeditor( function( textarea ) {
   console.log("textarea is ready", textarea);
});

</script>