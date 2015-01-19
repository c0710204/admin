var dat=[];

function getData(){

	var p={
		'do':'list',
        'limit':$('#limit').val()
	};
    $("#boxlist .overlay, #boxlist .loading-img").show();
    $('#boxlist .box-body').html("Loading...");
	$('#boxlist .box-body').load("ctrl.php",p,function(x){
		dat = jQuery.parseJSON(x);
        //console.log(dat);
        showData($('#boxlist .box-body'));
        $("#boxlist .overlay, #boxlist .loading-img").hide();
	});
}




function showData(target){
    
    console.log('showData(target)');

    var h=[];

    if(dat.length){

        h.push("<table class='table table-condensed table-striped'>");
        h.push("<thead>");
        h.push("<th>#</th>");
        h.push("<th width=120>Email</th>");
        h.push("<th width=120>Login</th>");        
        h.push("<th>First name</th>");
        h.push("<th>Last name</th>");
        h.push("<th>Password</th>");
        h.push("<th>x</th>");
        h.push("</thead>");

        h.push("<tbody>");
        
        for(var i=0;i<dat.length;i++){
            
            var o=dat[i];
            
            h.push("<tr>");
            
            h.push("<td title='"+o.sbi_id+"'><a href=#>" + o.sbi_id + "</a>");
            h.push("<td>" + o.sbi_email);
            h.push("<td>" + o.sbi_login);
            h.push("<td>" + o.sbi_first_name);
            h.push("<td>" + o.sbi_last_name);
            h.push("<td>" + o.sbi_password);
            h.push("<td><a href=# onclick=removeUser("+o.sbi_id+")><i class='fa fa-trash-o'></i></a>");

            h.push("</tr>");
        }
        h.push("</tbody>");
        h.push("</table>");
    }
    if(dat.length==0){
        h.push("<div class='alert'>Temporary user list is empty. Add some users</div>");
    }

    $(target).html(h.join(''));
    $('table').tablesorter();
}

function removeUser(id)
{
    if(!confirm("Remove this temporary user ?"))return false;

    $("#boxlist .overlay, #boxlist .loading-img").show();
    $('#boxlist .box-body').html("Removing...");
    $('#boxlist .box-body').load("ctrl.php",{'do':'delete','id':id},function(x){
        //dat = jQuery.parseJSON(x);
        //console.log(dat);
        showData($('#boxlist .box-body'));
        $("#boxlist .overlay, #boxlist .loading-img").hide();
        getData();
    });
}

$(function(){
	console.log('ready');
    getData();
    /*
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
	*/
});