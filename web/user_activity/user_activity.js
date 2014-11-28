var dat=[];

function getData(){

	var p={
		'do':'search',
        'user_id':$('#user_id').val(),
		'search':$('#search').val(),
        'course_id':$('#course_id').val(),
        'module_type':$('#module_type').val(),
        'limit':$('#limit').val()
	};
    //console.log('getData()',p);
	$('#results').html("Loading...");
	$('#results').load("ctrl.php",p,function(x){
		dat = jQuery.parseJSON(x);
        //console.log(dat);
        showData($('#results'));
	});
}


function downloadXls(){
    var p={
        'do':'search',
        'user_id':$('#user_id').val(),
        'search':$('#search').val(),
        'course_id':$('#course_id').val(),
        'module_type':$('#module_type').val(),
        'limit':$('#limit').val()
    };
    document.location.href='download_xls.php?';
}


function showData(target){

    var h=[];

    if(dat.length){

        h.push("<table class='table table-condensed table-striped'>");
        h.push("<thead>");
        h.push("<th width=120>Course</th>");
        h.push("<th width=120>Module type</th>");
        //h.push("<th>#</th>");
        h.push("<th>Name</th>");
        h.push("<th>Grade</th>");
        //h.push("<th width=150>Created</th>");
        h.push("<th width=150>Modified</th>");
        h.push("</thead>");

        h.push("<tbody>");
        for(var i=0;i<dat.length;i++){
            var o=dat[i];
            h.push("<tr onclick=info("+i+")>");
            //var ico="<i class='fa fa-file'></i>&nbsp;";
            //h.push("<td>" + o.id);
            h.push("<td width=120><a href='../course/?id="+o.course_id+"'>"+o.course_id.split("/")[1]+"</a>");//course
            h.push("<td title='"+o.module_id+"'><a href='../course_unit/?id="+o.module_id+"'>" + o.module_type + "</a>");
            h.push("<td>"+o.module_name);
            h.push("<td>");//grade
            if(o.grade|o.max_grade)h.push(o.grade+"/"+o.max_grade);
            //h.push("<td width=150>" + o.created);
            h.push("<td width=150>" + o.modified);
            //h.push("<td>" + o.length);

            h.push("</tr>");
        }
        h.push("</tbody>");
        h.push("</table>");
    }
    if(dat.length==0){
        h.push("<div class='alert'><pre>No data</pre></div>");
    }

    $(target).html(h.join(''));
    $('table').tablesorter();
}

function info()
{
    //
	console.log('info()');
}

$(function(){
	
    getData();
    
    $('#btn_download').click(function(){
        var params ='&user_id='+$('#user_id').val();
            params+='&course_id='+$('#course_id').val();
            params+='&module_type='+$('#module_type').val();
            params+='&limit='+$('#limit').val();
        
        document.location.href='download_xls.php?'+params;
    });

	$('#student_id, #course_id, #module_type, #limit').change(function(){
		getData();
	});
	console.log('ready');
});