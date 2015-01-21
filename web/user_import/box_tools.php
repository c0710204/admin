<?php
// admin :: User import -> box tools


$box = new Admin\SolidBox;
$box->id('boxtools');
$box->icon('fa fa-cog');
$box->title("Tools");

$foot=[];
$foot[]="<a href=# class='btn btn-default' id='btnAdd'><i class='fa fa-plus'></i> Add temporary user</a> ";
$foot[]="<a href='upload.php' class='btn btn-default' id='btnUpload'><i class='fa fa-upload'></i> Upload xls</a> ";
//$foot[]="<a href=# class='btn btn-default' id='btnPaste'><i class='fa fa-clipboard'></i> Paste clipboard</a> ";
$foot[]="<a href=#clear class='btn btn-danger pull-right' id='btnTrash'><i class='fa fa-trash-o'></i> Clear list</a> ";
echo $box->html($foot);
