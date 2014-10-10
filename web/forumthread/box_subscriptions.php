<?php
// box thread subscribtions
$body=[];

// get subscribers
$cursor = $forum->subscriptions->find(["source_id"=>"$mongoId"]);

if ($cursor->count()>0) {
    
    $body[] = "<table class=table>";
    foreach ($cursor as $r) {
        $body[]="<tr>";
        $body[]="<td><a href='../user/?id=".$r['subscriber_id']."'>" . $edxapp->userName($r['subscriber_id']) . "</a></td>";
        $body[]="<td>".date("Y-m-d", $r['updated_at']->sec);
        //echo "<pre>";print_r($r);exit;
        //echo "</pre>";
    }
    $body[] = "</table>";

} else {
    $body[]="No subscriber";
}

$box=new Admin\SolidBox;
$box->icon('fa fa-sign-in');
$box->title($cursor->count()." subscription(s)");
$box->collapsed(true);

echo $box->html($body);

