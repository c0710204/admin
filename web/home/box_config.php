<?php

//<h1>Config</h1>
$body=[];
$body[]="<pre>".realpath($_SESSION['configfile'])."</pre>";
//$body[]="<pre>".print_r($admin->config(), true)."</pre>";

echo $admin->box("default", "<i class='fa fa-cogs'></i> Config", $body);
