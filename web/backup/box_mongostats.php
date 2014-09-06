<?php
// mongo backup
// http://docs.mongodb.org/v2.4/tutorial/backup-with-mongodump/
$body=[];
//$body[]="<pre>db.printCollectionStats()</pre>";
$stat['cs_comments_service_development']=$edxapp->mgdb()->cs_comments_service_development->command(['dbStats' => 1]);
$stat['edxapp']=$edxapp->mgdb()->edxapp->command(['dbStats' => 1]);
$stat['log']=$edxapp->mgdb()->log->command(['dbStats' => 1]);


$dbs=['cs_comments_service_development', 'edxapp', 'log'];

$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
$body[]="<th>Name</th>";
$body[]="<th width=60 title='Collections'>Col.</th>";
$body[]="<th width=60>Obj.</th>";
$body[]="<th width=100>Storage size</th>";
$body[]="</thead>";
$body[]="<tbody>";
foreach ($dbs as $db) {
    $body[]= "<tr>";
    $body[]= "<td><i class='fa fa-database' title='$db'></i> ".$stat[$db]['db'];
    $body[]= "<td width=60 class='text-right'>".$stat[$db]['collections'];// collections
    $body[]= "<td width=60 class='text-right'>".number_format($stat[$db]['objects']);// objects
    $size=$stat[$db]['storageSize'];
    $size/=1024;
    $body[]= "<td class='text-right'>".number_format($size)."k";// sizeMb
    $body[]= "</tr>";
}
$body[]="</tbody>";
$body[]="</table>";

//$body[]="<pre>".print_r($stat, true)."</pre>";


$foot=[];

$box=new Admin\Box;
$box->icon('fa fa-bar-chart-o');
$box->title('Mongo stats');
$box->body($body);
$box->footer($foot);
echo $box->html();

//echo $admin->box("primary", "<i class='fa fa-bar-chart-o'></i> Mongo stats <small>".$admin->config()->mongo->host."</small>", $body, $foot);
