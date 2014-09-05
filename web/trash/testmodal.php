<?php
//admin :: list courses
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;
use Admin\EdxApp;
use Admin\EdxCourse;

$admin = new AdminLte("../config.json");
$admin->path("../");
$admin->title("Courses");

echo $admin->printPrivate();

$edxapp= new EdxApp("../config.json");
$edxCourse= new EdxCourse("../config.json");

?>

<section class="content-header">
    <h1><i class="fa fa-book"></i> Courses <small>Random text</small></h1>
</section>



<!-- Edit vessel name window -->
<div class="modal show" id="editNameModal">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3 id='vp_title'>Edit vessel name</h3>
  </div>

  <div class="modal-body">


	<fieldset class='form-horizontal'>
	<div class="control-group">
	<label class="control-label">#</label>
	<div class="controls">
		<input id="vn_id" class='input-mini' type="text" readonly>
	</div>
	</div>


	<div class="control-group">
	<label class="control-label">Name</label>
	<div class="controls docs-input-sizes">
		<input id="vn_name" type="text">
	</div>
	</div>

	<div class="control-group">
	<label class="control-label">Dates</label>
	<div class="controls">
		<input id="vn_from" style='width:80px' type="text" placeholder='Date from'>
		<input id="vn_to" style='width:80px' type="text" placeholder='Date to'>
	</div>
	</div>



	<div class="control-group">
	<label class="control-label">Comment admin</label>
	<div class="controls docs-input-sizes">
		<input id="vn_comment_admin" type="text">
	</div>
	</div>

	</fieldset>

  </div>
</div>




<script>
function testModal(){
	$('#editNameModal').modal('show');
}
</script>