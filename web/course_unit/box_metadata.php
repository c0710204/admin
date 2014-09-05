<?php
// metadata
$body=[];
$body[]="<pre>";
$body[]=print_r($unit['metadata'], 1);
$body[]="</pre>";

$foot=[];

$box=new Admin\SolidBox;
//$box->type("primary");
$box->icon('fa fa-save');
$box->title('Metadata');
$box->body($body);
echo $box->html();
