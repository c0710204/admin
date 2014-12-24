<?php
// More sessions from the same user
// 

$sessions=$edxApp->sessions([$user_id])[$user_id];
$totaltime=0;
$body=[];
$body[]="<table class='table table-condensed table-striped'>";
$body[]="<thead>";
$body[]="<th><i class='fa fa-calendar'></i> Date</th>";
$body[]="<th style='text-align:right'><i class='fa fa-clock-o'></i> Min</th>";
$body[]="</thead>";

$groups=[];//session groups per day

foreach ($sessions as $k=>$S) {
	$day=substr($S['date_from'], 0, 10);
	$groups["$day"][]=$S;
}

foreach ($groups as $date=>$sess) {
	
	$datestr=date("d M",strtotime($date));//Mon 25 Dec
	
	$body[]="<tr>";
	$body[]="<td>".$datestr;
	$body[]="<td style='text-align:right'>";
	foreach($sess as $k=>$r){
		//print_r($r);
		$length=(strtotime($r['date_to'])-strtotime($r['date_from']));
		$totaltime+=$length;
		$starttime=substr($r['date_from'],11,14);
		$minutes=round($length/60);
		if($session_id==$r['session']){
			$body[]="<a href='?id=$r[session]' class='btn btn-primary btn-xs' title='$starttime'>$minutes</a> ";
		} else {
			$body[]="<a href='?id=$r[session]' class='btn btn-default btn-xs' title='$starttime'>$minutes</a> ";
		}
	}
}

$body[]="<tfoot>";
$body[]="<th style='text-align:right'>Total time</th>";
$body[]="<th style='text-align:right'>".round($totaltime/60/60)." hours</th>";
$body[]="</tfoot>";

$body[]="</table>";

$foot=[];
$foot[]="<i class='text-muted'>".count($sessions)." session(s)</i>";


$box=new Admin\SolidBox;
$box->icon("fa fa-user");
$box->title("<a href='../user/?id=$user_id'>$username</a>");// <small>$session_id</small>
$box->type("danger");//
echo $box->html($body,$foot);
