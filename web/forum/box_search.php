<?php
// Forum Search

$body=[];
$body[]="<div class='row'>";

// courses
$body[]="<div class='col-lg-2'>";
$body[]="<div class='form-group'>";
$body[]="<label>Organisation</label>";
$body[]="<select class='form-control' id='org'>";
$body[]="<option value=''>Select organisation</option>";

$list=$edxapp->orgs();
// echo "<pre>"; print_r($list); echo "</pre>";

foreach ($list as $org) {
    $selected='';
    $body[]="<option value='$org' $selected>$org</option>";
}

$body[]="</select>";
$body[]="</div>";
$body[]="</div>";

// search
$body[]="<div class='col-lg-6'>";
$body[]="<div class='form-group'>";
$body[]="<label>Search</label>";
$body[]="<input type=text class=form-control id='searchStr' placeholder='Display name ...'>";
$body[]="</div></div>";

$body[]="</div>";//end row


$box= new Admin\SolidBox;
$box->type("success");
$box->icon("fa fa-search");
$box->title("Filter");
echo $box->html($body);
?>
<script>

function getThreads(){
	//console.log('getThreads()');
    $("#box-threads .overlay, #box-threads .loading-img").show();//loading
	
    var r=$.ajax({
  		type: "POST",
  		url: "ctrl.php",
  		dataType: "json",
  		data: {
			'do':'getThreads',
            'org':$('#org').val(),
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
	htm.push('<th><i class="fa fa-book"></i> Course</th>');
	htm.push('<th><i class="fa fa-user"></i> Author</th>');
	htm.push('<th>Thread title</th>');
	htm.push('<th><i class="fa fa-comments-o" title=Comments></i></th>');
	//htm.push('<th>Created</th>');
	htm.push('<th>Last activity</th>');
	htm.push('</thead>');
	htm.push('<tbody>');

	for(var i=0;i<json.length;i++)
    {
        o=json[i];
        console.log(o);
        var date_start=$.datepicker.formatDate('yy-mm-dd', o.start);
        var date_end=$.datepicker.formatDate('yy-mm-dd', o.end);        
        //if(!isValidDate(o.start)||/1970/.test(date_start))date_start='';
        //if(!isValidDate(o.end)||/1970/.test(date_end))date_end='';
        htm.push("<tr id=" + o.course + ">");
        htm.push("<td>" + o.org);
        htm.push("<td><a href='../course/?id="+o.course_id+"'>" + o.course_id);
        htm.push("<td><a href='../user/?id="+o.author_id+"'>" + o.author_username);
        htm.push("<td><a href='../forumthread/?id="+o.id+"'>" + o.title);
        htm.push("<td>" + o.comment_count);
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
	console.log('ready');
	$("#org, #searchStr").change(function(){
		getThreads();
	});
	getThreads();
});
</script>