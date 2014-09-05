<?php
//admin test
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

use Admin\Curl;
use Admin\AdminLte;

$admin = new AdminLte();
$admin->title("Modal");

echo $admin->printPrivate();
?>

<section class="content-header">
<h1><i class='fa fa-sign-in'></i> Modal window exemple</h1>
</section>

<br />

<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  <i class='fa fa-file'></i> Launch demo modal
</button>



<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><i class='fa fa-file'></i> Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-file'></i> Close</button>
        <button type="button" class="btn btn-primary"><i class='fa fa-save'></i> Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>
function showIt(){
    $('#myModal').show();
}
</script>