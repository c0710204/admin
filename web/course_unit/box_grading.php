<?php
// course unit - grading

$body=[];


if (isset($definition['data'])) {
    $body[]="<pre>";
    $body[]=print_r($definition['data']['grading_policy']);
    $body[]="</pre>";
}

$foot=[];
//$foot[]="<button class='btn'><i class='fa fa-save'></i> Save</button>";

echo $admin->box("primary", "Grading", $body, $foot);
