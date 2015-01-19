<?php
// admin :: CRM company
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new Admin\AdminLte();
$admin->title("Company");
echo $admin->printPrivate();

$edxCrm = new Admin\EdxCrm();
$comp=$edxCrm->company($_GET['id']);
//print_r($comp);
?>

<section class="content-header">
    <h1><i class="fa fa-home"></i> Company <small><a href='../companies/'>Companies</a></small></h1>
</section>

<!-- Main content -->
<section class="content">

<div class="row">
  
  <section class="col-sm-6 connectedSortable">
  <?php
  include "box_compinfo.php";
  ?>
  </section>

  <section class="col-sm-6 connectedSortable">
  <?php
  include "box_students.php";
  ?>
  </section>

</div>

<!-- Main row -->
<div class="row">
   
</div>


<div id='compList'></div>


<!-- Modal New Company -->
<div class="modal fade" id="newModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-file'></i> New users</h4>
      </div>

      <div class="modal-body">
        List of users to create :<br />
        <textarea id='emails' placeholder='Paste emails here, one email per line' style='width:100%;height:100px;'></textarea>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-file'></i> Close</button>
        <button type="button" class="btn btn-primary" onclick='createComp()'><i class='fa fa-save'></i> Create company</button>
      </div>

    </div>
  </div>
</div>


<!-- Modal Alert -->
<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-info'></i> Alert</h4>
      </div>

      <div class="modal-body" id='modal-body'>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-file'></i> Close</button>
      </div>

    </div>
  </div>
</div>


<script src='company.js'></script>