<?php
//admin :: test modal window
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\AdminLte;

$admin=new AdminLte("../config.json");
$admin->path("../");
$admin->printPrivate();
?>
<section class="content-header">
<h1><i class='fa fa-sign-in'></i> Modal test <small>marche pas</small></h1>
</section>

<!-- Main content -->
<section class="content">


<pre>$('#myModal').modal('show');</pre>

<div class="modal hide" id="myModal">

  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">×</button>
    <h3>Country selector</h3>
  </div>

	<div class="modal-body">

		<table class='table table-condensed table-striped'>
		<thead>
		<th>Id</th>
		<th>Name</th>
		<th>Code</th>
		</thead>
		<tbody>

		<tr>
		<td><a href=#>33</a></td>
		<td>r['c_name']</td>
		<td>r['c_code']</td>
		</tr>

		</tbody>
		</table>

	</div>

  <div class="modal-footer">
    <a href="#close" class="btn" data-dismiss="modal">Cancel</a>
  </div>

</div>

<script>
$(function(){
    //$('#myModal').modal();
    //$('#myModal').modal({ keyboard: false });
    //$('#myModal').modal('show');
    console.log("Ready");
});
</script>