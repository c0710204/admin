//sessions.js


function getSessionData(){
	
	$("#boxlist .overlay, #boxlist .loading-img").show();
	
	var p={
		'do':'getList',
		'search':$('#searchStr').val(),
		'date_from':$('#date_from').val(),
		'date_to':$('#date_to').val(),
		'limit':$('#limit').val()
	};
	
	$.cookie('search', $('#searchStr').val());
	$.cookie('date_from', $('#date_from').val());
	$.cookie('date_to', $('#date_to').val());
	$.cookie('limit', $('#limit').val());

	var r=$.ajax({
  		type: "POST",
  		url: "ctrl.php",
  		dataType: "json",
  		data: p
	});

	r.done(function(json){
		//console.log(json);//alert(x);
		$.each(json,function(k,v){
            json[k].date_from=new Date(v.date_from);
            json[k].date_to=new Date(v.date_to);
        });
		
		renderSessions(json, $("#sessionList"));
		
		$("#boxSessions .overlay, #boxSessions .loading-img").hide();
	});

	r.fail(function(a,b,c){
		console.log(a,b,c);
		$("#more").html(a.responseText);
		//$("#boxSessions .overlay, #boxSessions .loading-img").hide();
	});
	
}


function renderSessions(json, target){
	
	console.log('renderSessions()', json);
	
	var htm=[];

	htm.push('<table id="sessionTable" class="table table-condensed">');
	
	htm.push("<thead>");
	htm.push("<th>Session</th>");
	htm.push("<th>User_id</th>");
	htm.push("<th>Date</th>");
	htm.push("</thead>");
	
	htm.push("<tbody>");
	for(var i=0;i<json.length;i++)
    {
        o=json[i];

		var date_from=$.datepicker.formatDate('yy-mm-dd', o.date_from);
		var date_to=$.datepicker.formatDate('yy-mm-dd', o.date_to);

        htm.push("<tr>");
        htm.push("<td><a href='../session/?id="+o.session+"'>"+o.session+"</a>");//
        htm.push("<td>"+o.username);
        htm.push("<td>"+date_from);
        //htm.push("<td>"+date_to);
    }

	htm.push("</tbody>");
	htm.push("</table>");

	//$('#more').html("<table class=table><tr><td>Hello world of table</table>");
	$(target).html(htm.join(''));
	$('#sessionTable').tablesorter();
}


$(function(){
	console.log('ready');
	$('#searchStr, #date_from, #date_to, #limit').change(function(){
		getSessionData();	
	});
	getSessionData();
});