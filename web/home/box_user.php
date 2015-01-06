<?php
// Home :: New Users
$user=$admin->user;

$db=$admin->db();
$sql="SELECT * FROM edxapp.auth_user ORDER BY date_joined DESC LIMIT 10;";
$q=$db->query($sql) or die("<pre>".print_r($db->errorInfo(), true)."</pre>");

$body=[];
//$body[]="<pre>".print_r($user, true)."</pre>";
$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
//$body[]="<th>#</th>";
//$body[]="<th>Username</th>";
$body[]="<th><i class='fa fa-envelope-o'></i> Email</th>";
$body[]="<th><i class='fa fa-calendar'></i> Joined</th>";
$body[]="</thead>";
$body[]="<tbody>";

while ($r=$q->fetch()) {
    //print_r($r);
    $class="";
    if (!$r['is_active']) {
        $class="text-muted";
    }
    $body[]="<tr class=$class>";
    //$body[]="<td>".$r['id'];
    //$body[]="<td><a href='../user/?id=".$r['id']."'>".$r['username'];
    $body[]="<td><a href='../user/?id=".$r['id']."'>".strtolower($r['email']);
    //$body[]="<td>".$r['is_active'];

    $body[]="<td>".$admin->dateRelative($r['date_joined']);
}

$body[]="</tbody>";
$body[]="</table>";
$foot=[];
$foot[]="<a href=../users/ class='btn btn-primary'><i class='fa fa-arrow-circle-right'></i> See all users</a> ";
$foot[]="<a href=../users/stats.php class='btn btn-primary'><i class='fa fa-bar-chart-o'></i> Registration stats</a> ";

$box=new Admin\SolidBox;
$box->type("primary");
$box->icon('fa fa-users');
$box->title("New users");
$box->body_padding(false);

echo $box->html($body,$foot);


