var dat=[];

function getData(){
    
    //console.log('getData()');
	var p={
		'do':'list',
        'limit':$('#limit').val()
	};

    $("#boxlist .overlay, #boxlist .loading-img").show();
    $('#boxlist .box-body').html("Loading...");
	$('#boxlist .box-body').load("ctrl.php",p,function(x,error){
		
       // console.log(x,error);
        try{
            //console.log('x:',x);
            dat = jQuery.parseJSON(x);
            showData($('#boxlist .box-body'));
            $("#boxlist .overlay, #boxlist .loading-img").hide();
        }
        catch(e){
            console.log('error',dat);
            $("#boxlist .overlay, #boxlist .loading-img").hide();
        }        
	});
}

var warnings=0;
function showData(target){
    
    //console.log('showData(target)');
    var h=[];
    if(dat.length){

        h.push("<table class='table table-condensed table-striped'>");
        h.push("<thead>");
        //h.push("<th>#</th>");
        h.push("<th width=120><i class='fa fa-envelope-o'></i> Email</th>");
        h.push("<th width=120>Login</th>");        
        h.push("<th>First name</th>");
        h.push("<th>Last name</th>");
        h.push("<th>Password</th>");
        h.push("<th>x</th>");
        h.push("</thead>");

        h.push("<tbody>");
        warnings=0;
        for(var i=0;i<dat.length;i++){
            
            var o=dat[i];
            
            if (o.warning_mail||o.warning_name) {
                var className='text-muted';
            }else{
                var className='';
            }
            
            h.push("<tr ondblclick=editRecord("+o.sbi_id+") class="+className+">");


            h.push("<td>");//email            
            
            if(o.warning_mail){
                h.push("<i class='fa fa-warning' style='color:#c00' title='Email already registered'></i> ");
                h.push("<a href='../user/?id="+o.warning_mail+"'>"+o.sbi_email+"</a>");
                warnings++;
            }else{
                h.push(o.sbi_email);
            }

            h.push("<td>");//login
            if(o.warning_name){
                h.push("<i class='fa fa-warning' style='color:#c00' title='Username already registered'></i> ");
                h.push("<a href='../user/?id="+o.warning_name+"' title='Login already registered'>"+o.sbi_login+"</a>");
                warnings++;
            } else {
                h.push(o.sbi_login);
            }


            h.push("<td>" + o.sbi_first_name);
            h.push("<td>" + o.sbi_last_name);
            h.push("<td>" + o.sbi_password);
            h.push("<td><a href=# onclick=removeUser("+o.sbi_id+")><i class='fa fa-trash-o'></i></a>");

            h.push("</tr>");
        }
        h.push("</tbody>");
        h.push("</table>");
        h.push("<i class='text-muted'>" + dat.length + " temporary user(s) - Double click to edit tmp user record</i><br />");
        
        if (warnings>0) {
            h.push("<br />");
            h.push("<div class='alert alert-danger'>");
            h.push("<b>" + warnings + " warning(s)</b> : fix warnings before importing !");
            h.push("</div>");
        }
    }
    if(dat.length==0){
        h.push("<i class='fa fa-warning' style='color:#c00'></i> Temporary user list is empty");
    }

    $(target).html(h.join(''));

    $('table').tablesorter();
}

function addUser(){
    
    var p=prompt("Enter email address");
    if(!p)return;
        
    var atpos = p.indexOf("@");
    var dotpos = p.lastIndexOf(".");
    
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=p.length) {
        alert("Not a valid e-mail address !");
        return false;
    }

    $("#boxlist .overlay, #boxlist .loading-img").show();
    $("#boxlist .box-body").load("ctrl.php",{'do':'addUser','email':p},function(x){
        try{
            eval(x);
        }
        catch(e){
            console.log('error',e);
            $("#boxlist .overlay, #boxlist .loading-img").hide();
        }
    });
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

function clearList(){

    if(dat.length==0)return false;
    if(!confirm("Clear temporary user list ?"))return false;
    
    //$("#boxlist .overlay, #boxlist .loading-img").show();
    $('#boxlist .box-body').load("ctrl.php",{'do':'clearList'},function(x,error){
        try{
            console.log(x,error);
            eval(x);
        }
        catch(e){
            console.log('error',x);
            $("#boxlist .overlay, #boxlist .loading-img").hide();
        }
    });
}

function confirmEnroll(course_id){

    if(!course_id)return false;
    if(!confirm("Enroll users to course " + course_id + " ?"))return false;
    
    $('#editModal').modal('hide');

    $('#more').load('ctrl.php',{'do':'confirmEnroll','course_id':course_id},function(x){
        try{
            eval(x);
        }
        catch(e){
            console.log('error',x);
            $("#boxlist .overlay, #boxlist .loading-img").hide();
        }
    });
}

$(function(){
	
    getData();
    
    $('#btnImport').click(function(){
        
        if(dat.length==0){
            alert("Add some users first");
            return false;
        }
        
        if(warnings>0){
            alert("Check warnings and change user records first !");
            return false;
        }

        if(!confirm("Start importing " + dat.length + " user(s) ?")){
            return false;
        }

        $('#myModal').modal(true);
    });

    $('#btnAdd').click(function(){
        addUser();
    });

    $('#btnTrash').click(function(){
        clearList();
    });

    $('a[href="#enroll"]').click(function(o){
        var course_id=o.target.title;
        confirmEnroll(o.target.title);
    });

    console.log('ready');
});