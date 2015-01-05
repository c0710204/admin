<?php
// User calendar
// Box sessions

$sessions=@$edxApp->sessions([$USERID])[$USERID];

$body=[];

/*
if (count($sessions)) {

	$body[]="<table class='table table-condensed'>";
	$body[]="<thead>";
	$body[]="<th>Date</th>";
	$body[]="<th>Length</th>";
	$body[]="</thead>";
	$body[]="<tbody>";
	foreach($sessions as $k=>$session){
		$body[]="<tr>";
		$body[]="<td><a href='../session/?id=".$session['session']."'>".$session['date_from']."</a>";
		$body[]="<td>Length";
	}
	$body[]="</tbody>";
	$body[]="</table>";
} else {
	$body[]="<i class='fa fa-warning' style='color:#c00'></i> No session";
}
*/

$box = new Admin\SolidBox;
$box->id("boxSessions");
$box->icon("fa fa-bolt");
$box->title(count($sessions)." sessions");
$box->loading(true);

echo $box->html($body);//,"<a href=# class='btn btn-default'><i class='fa fa-arrow-right'></i> Ok</a>"
?>
<script>
var sessions=[];

$(function(){

	$('#boxSessions .box-body').load('ctrl.php',{'do':'list','user_id':$('#user_id').val()},function(x){
		try{
			var data=eval(x);
			sessions=data;
			//console.log('ok',data);
			$('#boxSessions .box-body').html(data.length+' session(s)');
			$("#boxSessions .overlay, #boxSessions .loading-img").hide();
			displaySessions('#boxSessions .box-body');
		}
		catch(e){
			alert(e);
		}
	});
});


function displaySessions(target){
	//console.log('displaySessions(target)');
	var htm=[];
	for(var i=0;i<sessions.length;i++){
		//console.log(sessions[i]);
		htm.push("<li><i class='text-muted'>"+sessions[i].date_from+"</i>");
		var start=sessions[i].date_from;
		var end=sessions[i].date_to;
		var title="sessions["+i+"]";
		var color='#27a0c9';
		addCalendarEvent(sessions[i].session, start, end, title, color);
	}
	
	htm.push("<table class=table>");
	htm.push("</table>");
	htm.push("<i class='text-muted'>"+sessions.length+" sessions</i>");
	
	$(target).html(htm.join(''));
}

// remove everything :
// $('#calendar').fullCalendar('removeEvents');

// add one event
// http://fullcalendar.io/docs/event_data/events_function/
// 

function addCalendarEvent(id, start, end, title, colour)
{
	//console.log('addCalendarEvent',id,start,end,title,colour);
    var eventObject = {
    	allDay:false,
    	title: title,
    	start: start,
    	end: end,
    	id: id,
    	url: '../session/?id='+id,
    	color: colour
    };

    $('#calendar').fullCalendar('renderEvent', eventObject, true);
    return eventObject;
}
</script>