<?php
/** 
 * course unit - user detail
 * for a given user, we try o get every piece of info
 */

//$user_id=19;//jambonbill

$db=$admin->db();
$sql="SELECT * FROM edxapp.courseware_studentmodule WHERE module_id='$unit_id' AND student_id=$user_id;";
$q=$db->query($sql) or die("<pre>".print_r($db->errorInfo(), true)."</pre>");

echo "<pre>$sql</pre>";

$cs = $q->fetch(PDO::FETCH_ASSOC);

//print_r($cs);exit;
$module_id=$cs['id'];

// action history //
$sql="SELECT * FROM edxapp.courseware_studentmodulehistory WHERE student_module_id='$module_id' ORDER BY id DESC;";
$q=$db->query($sql) or die("<pre>".print_r($db->errorInfo(), true)."</pre>");
$dat=[];
while ($r=$q->fetch(PDO::FETCH_ASSOC)) {
    $dat[]=$r;
}

$body=[];
$body[]="<h4>Base</h4>";
$body[]="<pre>".print_r($cs, true)."</pre>";
$body[]="<h4>History</h4>";
$body[]="<pre>".print_r($dat, true)."</pre>";


$box=new Admin\Box;
$box->type("primary");
$box->icon('fa fa-list');
$box->title('User jambonbill');
echo $box->html($body);

