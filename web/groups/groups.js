

function getList(){// search groups

	console.log('getList()');
    
    $("#grouplist .overlay, #grouplist .loading-img").show();//loading
	
    var r=$.ajax({
  		type: "POST",
  		url: "ctrl.php",
  		dataType: "json",
  		data: {
			'do':'list',
            'org':$('#org').val(),
			'type':$('#grouptype').val(),
			'search':$('#searchStr').val(),
			'limit':$('#limit').val()
		}
	});

	r.done(function(json){
		//console.log(json);//alert(x);
		renderList(json,$("#grouplist .box-body"));
        $("#grouplist .overlay, #grouplist .loading-img").hide();
	});

	r.fail(function(a,b,c){
		console.log(a,b,c);
		$("#grouplist .box-body").html(a.responseText);
	});
}



function renderList(json,target){
	
	//console.log('renderList()',json);

	var htm=[];
	htm.push('<table id=courselist class="table table-condensed table-striped">');
	
	htm.push('<thead>');
	//htm.push('<th>#</th>');

	htm.push('<th>Group name</th>');
	htm.push('<th>Type</th>');
	//htm.push('<th>Users</th>');
	htm.push('<th>Course</th>');
	htm.push('</thead>');
	
	htm.push('<tbody>');

	for(var i=0;i<json.length;i++)
    {
        o=json[i];
        //console.log(o);
        
        htm.push("<tr>");
        //htm.push("<td><a href='../group/?id="+o.id+"'>" + o.id);
        
        htm.push("<td><a href='../group/?id="+o.id+"'>"+o.name+"</a>");
        htm.push("<td>" + o.type);
        htm.push("<td><a href='../course/?id="+o.course_id+"'>"+o.courseName+"</a>");
        /*
        htm.push("<td>" + o.course);
        htm.push("<td><a href='../course/?id="+o.id+"'>" + o.display_name);
        */
    }

	htm.push('</tbody>');
	htm.push('</table>');

    htm.push("<h4><i>"+json.length+" groups(s)</i></h4>");
	target.html(htm.join(''));
    
    $("table").tablesorter();
}

$(function(){

	console.log('groups.js');

	//$('#grouplist .loading-img, #grouplist .overlay').hide();
    $("#org,#grouptype,#searchStr").change(function(){
    	getList();
    });

    getList();

});


