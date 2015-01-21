<?php
// user sessions
// echo __FILE__;
// var_dump($sessions);exit;

$body=[];
/*
if (count($user_sessions)) {

    $body[]="<table class='table table-condensed'>";
    $body[]="<thead>";
    $body[]="<th>Session start";
    $body[]="<th>Session start";
    $body[]="<th>Length";
    $body[]="</thead>";
    //echo "<pre>".print_r($sessions,true)."</pre>";
    $body[]="<tbody>";
    foreach ($user_sessions as $session) {
        
        $session_id=$session['session'];
        
        $body[]="<tr>";
        $body[]="<td>";
        $body[]="<a href='../session/?id=$session_id'>";
        $body[]=date("D d M Y ",strtotime($session['date_from'])) . "</a>";
        $body[]="<td>".substr($session['date_from'],0,16);
        $length=strtotime($session['date_to']) - strtotime($session['date_from']);
        $minutes=round($length/60);
        $body[]="<td>".$minutes." min";
    }
    $body[]="</tbody>";
    $body[]="</table>";
} else {
    $body[]="<i class='fa fa-warning' style='color:c00'></i> No session data";
}
*/

$box=new Admin\Box;
$box->id("boxusersession");
$box->icon("fa fa-bolt");
$box->type("primary");
$box->title("Sessions");
$box->body_padding(false);
$box->loading(true);
$foot=[];
$foot[]="<a href='../user_calendar/?user_id=$USERID' class='btn btn-default'><i class='fa fa-calendar'></i> User calendar</a> ";
$foot[]="<a href=#reload onclick=getSessions() class='btn btn-default'><i class='fa fa-retweet'></i> Refresh</a>";
echo $box->html($body,$foot);
?>
<script>
function getSessions(){

    console.log('getSessions');

    var p={
        'do':'sessionList',
        'user_id':$('#userid').val()
    }

    $("#boxusersession .overlay, #boxusersession .loading-img").show();
    $("#boxusersession .box-body").load("ctrl.php",p,function(x){
        try{
            var dat=eval(x);
            displaySession(dat);
        }
        catch(e){
            console.log("error",e);
        }
        $("#boxusersession .overlay, #boxusersession .loading-img").hide();
    });
}

function displaySession(dat){

    //console.log('displaySession');

    var htm=[];
    htm.push("<table class='table table-condensed'>");
    htm.push("<thead>");
    htm.push("<th>Date</th>");
    htm.push("<th>Session</th>");
    htm.push("</thead>");
    htm.push("<tbody>");
    var lastdate='';

    for (var i=0;i<dat.length;i++) {
        var date=dat[i].date_from.substring(0,10);
        var time=dat[i].date_from.substr(11,5);
        //console.log(date,time);
        if (date!=lastdate) {
            htm.push("<tr>");
            htm.push("<td><i>"+date+"</i>");
            htm.push("<td>");
        }
        htm.push("<a href='../session/?id="+dat[i].session+"' class='label label-info'>"+time+"</a> ");
        //htm.push("<td>"+dat[i].date_to);
        //var minutes=math.round(dat[i].length/60);
        //htm.push("<td>" + minutes + " minutes");
        //htm.push("<td>"+dat[i].);
        lastdate=date;
    }
    htm.push("</tbody>");
    htm.push("</table>");
    
    if(dat.length>0){
        htm.push("<i class=muted>"+dat.length+" session(s)</i>");
    }else{
        htm.push("<br />&nbsp;<i class='fa fa-warning' style='color:#c00'></i> no session data<br /><br />");
    }
    $("#boxusersession .box-body").html(htm.join(''));
    $("#boxusersession .box-title").html("<i class='fa fa-bolt'></i> "+dat.length+" session(s)");
    $("#tilesession h3").text(dat.length);
}

$(function(){
    console.log('user_session.php');
    getSessions();
});
</script>