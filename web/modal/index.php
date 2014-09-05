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

<div class="container">


<br />

<!-- Button trigger modal -->
<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  <i class='fa fa-file'></i> Launch demo modal
</button>

<hr />

<pre>
$('#myModal').modal({'show':true});
</pre>


<hr />
Autocomplete:

<input type="text" id='typeahead1' class='form-control' data-provide="typeahead" autocomplete="off" placeholder='Username'>

<pre>
http://twitter.github.io/typeahead.js/
http://twitter.github.io/typeahead.js/examples/
</pre>



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
    $('#myModal').modal({'show':true});
}

$(function(){
  autocomplete( $('#typeahead1'), 'username', './suggest.php', function(x){
    console.log('submit',x);
  });
});

</script>