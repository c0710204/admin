
//var dbug;
function getUserData(){

    $("#boxlist .overlay, #boxlist .loading-img").show();
	var p={
		'do':'getlist',
		'search':$('#searchStr').val(),
		'date_joined':$('#date_joined').val(),
		'status':$('#status').val(),
		'limit':$('#limit').val()
	};
	
	$.cookie('searchStr', $('#searchStr').val());
	$.cookie('date_joined', $('#date_joined').val());
	$.cookie('status', $('#status').val());
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
            json[k].last_login=new Date(v.last_login);
            json[k].date_joined=new Date(v.date_joined);
        });
		renderUsers(json,$("#userList"));
		$("#boxlist .overlay, #boxlist .loading-img").hide();
	});

	r.fail(function(a,b,c){
		console.log(a,b,c);
		$("#userList").html(a.responseText);
		$("#boxlist .overlay, #boxlist .loading-img").hide();
	});
}

function renderUsers(json, target){

	//console.log('renderUsers');
	var htm=[];
	htm.push('<table id=usertable class="table table-condensed table-striped">');
	htm.push('<thead>');
	htm.push('<th>id</th>');
	htm.push('<th>Username</th>');
	htm.push('<th>Email</th>');
	htm.push('<th>Last login</th>');
	//htm.push('<th>Date joined</th>');
	htm.push('</thead>');
	htm.push('<tbody>');

	for(var i=0;i<json.length;i++)
    {
        o=json[i];
        //console.log(o);

        clas='';
        if(o.is_active==0){clas="text-muted";}

        var date_last_log=$.datepicker.formatDate('yy-mm-dd', o.last_login);
        if(!isValidDate(o.last_login))date_last_log='';

        htm.push("<tr onclick=getUserInfo("+o.id+") class="+clas+">");
        htm.push("<td>"+o.id);//<a href='../user/?id="+o.id+"'>
        htm.push("<td><a href='../user/?id="+o.id+"'>" + o.username);
        if(o.is_staff)htm.push(" <span class='label label-success'>Staff</span>");
        if(o.is_superuser)htm.push(" <span class='label label-danger'>SU</span>");
        htm.push("<td>" + o.email);
        //htm.push("<td>" + o.last_login);
        htm.push("<td>" + date_last_log);
        //htm.push("<td>" + o.date_joined);

    }

	htm.push('</tbody>');
	htm.push('</table>');

	if(json.length==0){
		var htm=[];
		htm.push("<h3>No data</h3>");
	}else{
		getUserInfo(json[0].id);
	}

	target.html(htm.join(''));
    $("#usertable").tablesorter();
}

function isValidDate(d) {
  if ( Object.prototype.toString.call(d) !== "[object Date]" )
    return false;
  return !isNaN(d.getTime());
}

function getUserInfo(uid){
	//console.log('getUserInfo(uid)',uid);
	$("#boxdetails .overlay, #boxdetails .loading-img").show();
	//$('#details').html("loading");
	$('#boxdetails .box-body').load("ctrl.php",{'do':'getUserInfo','uid':uid},function(x){
		$("#boxdetails .overlay, #boxdetails .loading-img").hide();
	});
}

function addUser(){

	var p=prompt("Enter user email");
	if(!p)return false;

	if(!confirm("Confirm create user "+p+" ?"))return false;

	$('#details').html("loading");
	$('#details').load("ctrl.php",{'do':'createUser','email':p},function(x){
		try{eval(x);}
		catch(e){alert(x);}
	});
}


function showNewUsers(){
	$('#newModal').modal({'show':true});
}

function createUsers(){
	var emails=$('#emails').val();
	$('#details').html("loading");
	$('#details').load("ctrl.php",{'do':'createUsers','emails':emails},function(x){
		alert(x);
	});
}

// bang //
$( document ).ready(function() {
    console.log( "ready" );
    $('#searchStr, #date_joined, #status, #limit').change(function(){
    	getUserData();
    });
    
    $('#searchStr').val($.cookie('searchStr'));
	$('#date_joined').val($.cookie('date_joined'));
	$('#status').val($.cookie('status'));
	$('#limit').val($.cookie('limit'));
	
	getUserData();
    
	$("#userList").focus();

});
