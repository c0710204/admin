<?php

$body=[];
$body[]="<pre>";
$body[]=print_r($unit['metadata']['markdown'], 1);
$body[]="</pre>";

$foot=[];
$foot="<a href=# class='btn btn-default'><i class='fa fa-save'></i> Save markdown<a>";

echo $admin->box("primary", "<i class='fa fa-save'></i> Markdown", $body, $foot);
