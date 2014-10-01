<?php
// Forum threads

$box=new Admin\SolidBox;
$box->id("box-threads");
$box->title("Forum threads");
$box->icon("fa fa-bolt");
$box->body($body);
$box->loading(true);
echo $box->html("body", "<div id=recentmsg>recent</div>");
