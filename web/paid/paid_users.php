<?php

// paid_student
$sql = "SELECT * FROM edxapp.paid_student;";
echo "<pre>$sql</pre>";
$q=$admin->db()->query($sql);

/*
Array
(
    [ps_id] => 1
    [ps_paid_id] => 1
    [ps_joined_date] => 2014-10-06 00:00:00
    [ps_student_id] => 551
    [ps_chapter] => 0014122f43e44ce686e7c126110e39a1
)
 */

// Paid Users
$body=[];
$body[]="<table class='table table-striped table-condensed'>";
$body[]= "<thead>";
$body[]= "<th>#</th>";
$body[]= "<th>ps_paid_id</th>";
$body[]= "<th>User name</th>";
$body[]= "<th>Joined</th>";
$body[]= "<th>Chapter</th>";
$body[]= "</thead>";
$body[]= "<tbody>";
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    //print_r($r);
    $body[]= "<tr>";
    $body[]= "<td>".$r['ps_id'];
    $body[]= "<td>".$r['ps_paid_id'];
    $body[]= "<td><a href='../user/?id=".$r['ps_student_id']."'>".ucfirst($edxApp->userName($r['ps_student_id']));
    $body[]= "<td>".substr($r['ps_joined_date'], 0, 10);
    $body[]= "<td><a href=# title='".$r['ps_chapter']."'>...</a>";//;
}
$body[]= "</tbody>";
$body[]= "</table>";

$box = new Admin\SolidBox;
$box->title("Paid users <small>edxapp.paid_student</small>");
$box->icon("fa fa-users");
echo $box->html($body);