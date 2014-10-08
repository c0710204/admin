
function getThreads(){
	//console.log('getThreads()');
    $("#box-threads .overlay, #box-threads .loading-img").show();//loading
	
	$.cookie('org', $('#org').val());//  set cookie

    var r=$.ajax({
  		type: "POST",
  		url: "ctrl.php",
  		dataType: "json",
  		data: {
			'do':'getThreads',
            'org':$('#org').val(),
            'course_id':$('#course').val(),
			'search':$('#searchStr').val()
		}
	});

	r.done(function(json){
		//console.log(json);//alert(x);
		$.each(json,function(k,v){
            //json[k].start=new Date(v.start);
            //json[k].end=new Date(v.end);
        });
		renderList(json,$("#box-threads .box-body"));
        $("#box-threads .overlay, #box-threads .loading-img").hide();
	});

	r.fail(function(a,b,c){
		console.log(a,b,c);
		$("#box-threads .box-body").html("Error: " + a.responseText);
	});
}


function renderList(json,target){
	
	//console.log('renderList(json,target)');

	var htm=[];
	var id='tablelist';

	htm.push('<table id='+id+' class="table table-condensed table-striped">');
	htm.push('<thead>');
	htm.push('<th>Org</th>');
	//htm.push('<th><i class="fa fa-user"></i> Author</th>');
	htm.push('<th>Thread title</th>');
	htm.push('<th><i class="fa fa-comments-o" title=Comments></i></th>');
	//htm.push('<th>Created</th>');
	htm.push('<th>Course</th>');

	htm.push('<th>Last activity</th>');
	htm.push('</thead>');
	htm.push('<tbody>');

	for(var i=0;i<json.length;i++)
    {
        o=json[i];
        //console.log(o);
        var date_start=$.datepicker.formatDate('yy-mm-dd', o.start);
        var date_end=$.datepicker.formatDate('yy-mm-dd', o.end);        
        //if(!isValidDate(o.start)||/1970/.test(date_start))date_start='';
        //if(!isValidDate(o.end)||/1970/.test(date_end))date_end='';
        htm.push("<tr id=" + o.course + ">");
        htm.push("<td>" + o.org);
        
        
        htm.push("<td><a href='../forumthread/?id="+o.id+"'>" + o.title);
        
        htm.push(" <i class='text-muted'>"+o.author_username+"</i>");//author
        
        if (o.comment_count>0) {
        	htm.push("<td>" + o.comment_count);
        } else {
        	htm.push("<td>");
        }
        
        htm.push("<td><a href='../course/?id="+o.course_id+"'>" + o.courseName);
        
        //htm.push("<td>" + o.created_at);
        htm.push("<td>" + o.last_activity);
    }
	htm.push('</tbody>');
	htm.push('</table>');

	if(json.length==0){
		htm=[];
		htm.push("<h2>No thread</h2>");
	}

	target.html(htm.join(''));
    $("#"+id).tablesorter();
}

$(function(x){

	//console.log('ready');

	$("#org, #course, #searchStr").change(function(){
		getThreads();
	});

	$('#org').val($.cookie('org'));

	getThreads();
});