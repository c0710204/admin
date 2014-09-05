<?php

$body=[];
$body[]="<pre>";
$body[]=print_r($cnf->lte,true);
$body[]="</pre>";

$foot=[];
//$footer[]="<button class='btn' onclick='testMongo()'><i class='fa fa-bolt'></i> Test mongo connection</button>";

echo $admin->box("danger", "<i class='fa fa-cog'></i> LTE", $body, $foot);
