<?php
// Group users

$sql="SELECT id, user_id FROM edxapp.auth_user_groups WHERE group_id=$group_id;";
$q = $admin->db()->query($sql) or die(print_r($admini->db()->errorInfo(), true));

$dat=[];
while ($r=$q->fetch(\PDO::FETCH_ASSOC)) {
    $dat[]=$r;
}

$box=new Admin\SolidBox;
$box->title("Group users");
$box->icon("fa fa-users");


$htm=[];
$htm[]="<table class='table table-condensed table-striped'>";
foreach ($dat as $r) {
    $htm[]="<tr>";
    $htm[]="<td width=30>".$r['id'];
    $htm[]="<td><a href='../user/?id=".$r['user_id']."'>".$edxApp->userName($r['user_id']);
}
$htm[]="</table>";

$foot=[];
$foot="<a href=# class='btn btn-default'>Add user</a>";
echo $box->html($htm, $foot);
