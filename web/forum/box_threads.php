<?php
// Forum threads

$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title("Forum threads");
$box->icon("fa fa-bolt");
$box->body_padding(false);
$box->loading(true);

echo $box->html("body", "<div id=recentmsg>recent</div>");
