<?php
// paid_group

//echo "<h1>Paid group</h1>";

echo "<pre>".print_r($edxCourse->chapterName('0014122f43e44ce686e7c126110e39a1'), true)."</pre>";

$sql = "SELECT * FROM edxapp.paid_group;";
$q=$admin->db()->query($sql);

//echo "<pre>$sql</pre>";
$body=[];
$body[]="<table class='table'>";
$body[]="<thead>";
$body[]="<th>#</th>";
$body[]="<th>pg_chapter</th>";
$body[]="<th>pg_paid_id</th>";
$body[]="<th>pp_usd</th>";
$body[]="<th>pp_eur</th>";
$body[]="<th>pp_hkd</th>";
$body[]="<th>hkd</th>";
$body[]="<th>usd</th>";
$body[]="<th>eur</th>";
$body[]="<th>pg_only_text</th>";
$body[]="</thead>";

while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    //print_r($r);
    $body[]="<tr>";
    $body[]="<td>".$r['pg_id'];
    $body[]="<td><a href='../course_chapter/?id=".$r['pg_chapter']."'>".$r['pg_chapter'];
    $body[]="<td>".$r['pg_paid_id'];
    $body[]="<td>".$r['pg_paypal_usd'];
    $body[]="<td>".$r['pg_paypal_eur'];
    $body[]="<td>".$r['pg_paypal_hkd'];
    $body[]="<td>".$r['pg_price_hkd'];
    $body[]="<td>".$r['pg_price_usd'];
    $body[]="<td>".$r['pg_price_eur'];
    $body[]="<td>".$r['pg_only_text'];
}
$body[]="</table>";

$box=new Admin\SolidBox();
$box->icon("fa fa-money");
$box->title("Paid group <small>edxapp.paid_group</small>");
echo $box->html($body);
