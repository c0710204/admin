
function getEnrollData(){
    
    //console.log('getEnrollData()');
    
    $("#boxenroll .overlay, #boxenroll .loading-img").show();//loading
    
    var r=$.ajax({
        type: "POST",
        url: "ctrl.php",
        dataType: "json",
        data: {
            'do':'listEnroll',
            'course_id':$('#course_id').val(),
            'search':$('#searchStr').val(),
            'limit':$('#limit').val()
        }
    });

    r.done(function(json){
        
        //console.log(json);
        //alert(json);
        
        /*
        $.each(json,function(k,v){
            //json[k].start=new Date(v.start);
            //json[k].end=new Date(v.end);
        });
        */
        
        dispEnroll(json, $("#boxenroll .box-body"));
        $("#boxenroll .overlay, #boxenroll .loading-img").hide();
    });

    r.fail(function(a,b,c){
        console.log('fail',a,b,c);
        $("#boxenroll .box-body").html(a.responseText);
        $("#boxenroll .overlay, #boxenroll .loading-img").hide();
    });
}

function dispEnroll(json, target){
    //console.log('dispEnroll()');
    
    var h=[];
    h.push("<table class='table table-striped table-condensed'>");
    h.push("<thead>");
    h.push("<th><i class='fa fa-user'></i> User</th>");
    
    //h.push("<th>First name</th>");
    //h.push("<th>Last name</th>");
    h.push("<th><i class='fa fa-envelope'></i> Email</th>");
    h.push("<th>Progress</th>");

    h.push("<th><i class='fa fa-calendar'></i> Joined</th>");
    h.push("</thead>");
    h.push("<tbody>");
    $.each(json,function(k,v){
        h.push('<tr>');
        h.push('<td><a href=../user/?id='+v.user_id+'>'+v.username);
        //h.push('<td>'+v.first_name);
        //h.push('<td>'+v.last_name);
        h.push('<td>'+v.email);
        h.push('<td><a href="../progress/?user_id='+v.user_id+'">'+v.progress);
        h.push('<td>'+v.created);
        h.push('</tr>');
    });
    h.push("</tbody>");
    h.push("</table>");

    target.html(h.join(''));
    
    $('table').tablesorter();
}


$(function(){
    
    console.log('ready');

    //$("#boxenroll .overlay, #boxenroll .loading-img").hide();
    $('#searchStr, #limit').change(function(){
        getEnrollData();
    });
    getEnrollData();
});