<?php
// products

$sql = "SELECT * FROM edxapp.paid;";
//echo "<pre>$sql</pre>";
$q=$admin->db()->query($sql) or die("<pre>Error:$sql</pre>");

//echo "<h1>Products</h1>";

$body=[];
$body[]= "<table class='table table-condensed table-striped'>";
$body[]= "<thead>";
$body[]= "<th>#</th>";
$body[]= "<th>name</th>";
$body[]= "<th>course</th>";
$body[]= "<th>usd</th>";
$body[]= "<th>eur</th>";
$body[]= "<th>hkd</th>";
$body[]= "</thead>";

while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    //print_r($r);
    $body[]= "<tr>";
    $body[]= "<td>".$r['p_id'];
    $body[]= "<td>".$r['p_name'];
    //
    $course_id = $edxCourse->exist($r['p_course_id']);
    $body[]= "<td><a href='../course/?id=".$course_id."'>".$course_id;
    $body[]= "<td>".$r['p_price_usd'];
    $body[]= "<td>".$r['p_price_eur'];
    $body[]= "<td>".$r['p_price_hkd'];
    //echo "<td>".$r['p_price_usd'];
}
$body[]= "</table>";

$box=new Admin\SolidBox();
$box->title("Products <small>paid</small>");
$box->icon("fa fa-money");
echo $box->html($body);
