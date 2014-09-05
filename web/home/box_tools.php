<?php
// tools
$body=[];
$body[]="<pre>".`php --version`."</pre>";
$body[]="<pre>".`mysqldump --version`."</pre>";
$body[]="<pre>".`mongodump --version`."</pre>";
$body[]="<pre>".`gzip --version`."</pre>";
//$body[]="<pre>".print_r($admin->config(), true)."</pre>";

echo $admin->box("primary", "<i class='fa fa-linux'></i> Tools", $body, [], 'collapse');
