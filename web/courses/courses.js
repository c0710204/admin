//courses.js

/*
function trashCourse(o){
	if(!confirm("Are you sure you want to delete this course ?"))return false;
	console.log('trashCourse()',o);
}
*/



function getList(){

    $("#boxlist .overlay, #boxlist .loading-img").show();//loading
    
    $.cookie('org', $('#org').val());
    
    var r=$.ajax({
  		type: "POST",
  		url: "ctrl.php",
  		dataType: "json",
  		data: {
			'do':'list',
            'org':$('#org').val(),
			'search':$('#searchStr').val(),
			'limit':$('#limit').val()
		}
	});

	r.done(function(json){
		//console.log(json);//alert(x);
		$.each(json,function(k,v){
            json[k].start=new Date(v.start);
            json[k].end=new Date(v.end);
        });
		renderList(json,$("#boxlist .box-body"));
        $("#boxlist .overlay, #boxlist .loading-img").hide();
	});

	r.fail(function(a,b,c){
		console.log(a,b,c);
		$("#moreCourse").html(a.responseText);
	});
}




function renderList(json,target){
	
	//console.log('renderList(json,target)');

	var htm=[];
	htm.push('<table id=courselist class="table table-condensed table-striped">');
	
    htm.push('<thead>');
	htm.push('<th><i class="fa fa-home"></i> Org</th>');
	
    htm.push('<th>Display name</th>');
	htm.push('<th title="Enrollments">Enr.</th>');
    htm.push('<th title="Chapters">Chpt.</th>');
	
	htm.push('<th><i class="fa fa-calendar"></i> Start</th>');
	htm.push('<th><i class="fa fa-calendar"></i> End</th>');
	htm.push('</thead>');
	htm.push('<tbody>');

	for(var i=0;i<json.length;i++)
    {
        o=json[i];
        //console.log(o);

        var date_start=$.datepicker.formatDate('yy-mm-dd', o.start);
        var date_end=$.datepicker.formatDate('yy-mm-dd', o.end);
        
        if(!isValidDate(o.start)||/1970/.test(date_start))date_start='';
        if(!isValidDate(o.end)||/1970/.test(date_end))date_end='';

        htm.push("<tr id=333>");
        htm.push("<td>" + o.org);
        htm.push("<td><a href='../course/?id="+o.id+"'>" + o.display_name);
        /*
        if(o.youtube){
            htm.push(" <i class='fa fa-youtube' title='"+o.youtube+"'></i>");
        }
        */
       
       
        //htm.push("<td>" + o.short_desc);
        //if(o.is_staff)htm.push(" <span class='label label-success'>Staff</span>");
        //if(o.is_superuser)htm.push(" <span class='label label-danger'>SU</span>");
        htm.push("<td style='text-align:right'>" + o.enroll);
        
        if(o.chapters>1){
            htm.push("<td>" + o.chapters);
        } else {
            htm.push("<td>");
        }
        
        htm.push("<td>" + date_start);
        htm.push("<td>" + date_end);
    }

	htm.push('</tbody>');
	htm.push('</table>');
    htm.push("<h4><i>"+json.length+" course(s)</i></h4>");
	target.html(htm.join(''));
    $("#courselist").tablesorter();
}

function isValidDate(d) {
  if ( Object.prototype.toString.call(d) !== "[object Date]" )
    return false;
  return !isNaN(d.getTime());
}

$(function(){
    console.log("ready");

    $("#org, #searchStr").change(function(){
        //console.log('change');
        getList();
    });

    $("table").tablesorter();

    $('#org').val($.cookie('org'));
    $('#searchStr').val($.cookie('searchStr'));

    getList();
});