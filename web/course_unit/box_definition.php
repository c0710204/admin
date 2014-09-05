<?php

$body=[];
$body[]="<pre>";
$body[]=trim($definition['data']['data']);
$body[]="</pre>";
$foot=[];

echo $admin->box("primary", "Definition", $body, $foot);


