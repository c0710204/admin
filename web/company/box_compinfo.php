<?php
// box company info

$box=new Admin\SolidBox();
$box->id('boxinfo');
$box->icon('fa fa-home');
$box->title($comp['c_name']);
$box->loading(true);
$body="<pre>".print_r($comp,true)."</pre>";

$footer=[];
$footer[]="<a href=# class='btn btn-default' id='btnSave'><i class='fa fa-save'></i> Save company info</a>";
$footer[]="<a href=# class='btn btn-danger pull-right' id=btnDelete><i class='fa fa-trash-o'></i> Delete</a>";
echo $box->html($body, $footer);

/*
<div class="col-sm-6">
<div class="form-group">
<label>Username</label>
<input type="text" class="form-control" id="username" placeholder="Username" value="jambonbill">
</div></div>
*/
