<?php
// box thread debug

$r = $forum->contents->findOne(["_id"=>$mongoId]);
if (!$r) {
    echo $admin->callout("danger", "Forum thread not found");
    exit;
}

$body="<pre>".print_r($r, true)."</pre>";

$box=new Admin\SolidBox;
$box->icon('fa fa-bug');
$box->title("debug");
$box->collapsed(true);
echo $box->html($body);
