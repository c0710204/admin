<?php
// admin :: file info

$box = new Admin\SolidBox;
$box->type("success");
$box->icon("fa fa-info");
$box->title("File info");
echo $box->html("<div id='fileinfo'></div>");
