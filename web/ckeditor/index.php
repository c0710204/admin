<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("CKEditor");

echo $admin->printPrivate();
?>

<section class="content-header">
    <h1><i class='fa fa-edit'></i> CKEditor <small></small></h1>
</section>

<!-- Main content -->
<section class="content">

<form>



</form>

<?php

$body=[];
$body[]="<textarea name='editor1' id='editor1' rows=10 cols=80></textarea>";

$footer=[];
$footer="<a href=# onclick='saveCK()' class='btn btn-primary'>Save</a>";

echo $admin->box("primary", "Course overview", $body, $footer);

?>
<script>
//CKEDITOR.replace( 'editor1' );
//$('textarea').ckeditor();

 $('#editor1').ckeditor( function( textarea ) {
   // Callback function code.
   console.log("textarea is ready", textarea);
 });


function isDirty(){
	var dirty = $('#editor1').ckeditor().editor.checkDirty();
	console.log( dirty );
}

function getData(){
	// Get the editor data.
	//var data = $( 'textarea.editor' ).val();
	console.log($('#editor1').val());
}

function saveCK()
{
	var data=$('#editor1').val();
	console.log('saveCK()', data);
}

$(function(){
	console.log("ready");
});


</script>
