<?php
//<h1>Session</h1>

$body=[];
$body[]="<pre>".print_r($_SESSION, true)."</pre>";
$body[]="<pre>".print_r($admin->session(), true)."</pre>";

echo $admin->box("default", "Session", $body);
