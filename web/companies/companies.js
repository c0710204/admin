

function createCompany(){
    var p=prompt("Company name");
    if(!p)return false;

    $("#boxlist .overlay, #boxlist .loading-img").show();
    $('#boxlist .box-body').load('ctrl.php',{'do':'createCompamy','name':p},function(x){
        try{
            eval(x);
        }
        catch(e){
            console.log("Error",x);
            $("#boxlist .overlay, #boxlist .loading-img").hide();
        }
    });
}

function getCompanyList(){

    console.log('getCompanyList()');
    
    $("#boxlist .overlay, #boxlist .loading-img").show();
    
    var p={
        'do':'getCompanyList',
        'search':$('#searchStr').val(),
        //'date_joined':$('#date_joined').val(),
        //'status':$('#status').val(),
        'limit':$('#limit').val()
    };
    
    //$.cookie('searchStr', $('#searchStr').val());
    //$.cookie('date_joined', $('#date_joined').val());
    //$.cookie('status', $('#status').val());
    //$.cookie('limit', $('#limit').val());

    var r=$.ajax({
        type: "POST",
        url: "ctrl.php",
        dataType: "json",
        data: p
    });

    r.done(function(json){
        /*
        $.each(json,function(k,v){
            json[k].last_login=new Date(v.last_login);
            json[k].date_joined=new Date(v.date_joined);
        });
        */
        //console.log(json);
        $("#boxlist .overlay, #boxlist .loading-img").hide();
        display(json,$('#boxlist .box-body'));
    });

    r.fail(function(a,b,c){
        console.log("Error",a,b,c);
        $("#boxlist .box-body").html(a.responseText);
        $("#boxlist .overlay, #boxlist .loading-img").hide();
    });
}

function display(json,target){
    
    //console.log('display()',json);
    
    var htm=[];
    htm.push("<table class='table table-condensed table-striped'>");
    htm.push("<thead>");
    htm.push("<th>#</th>");
    htm.push("<th>Company name</th>");
    htm.push("<th>Type</th>");
    htm.push("<th>Country</th>");
    htm.push("</thead>");
    htm.push("<tbody>");
    for(var i=0;i<json.length;i++){
        htm.push("<tr>");
        htm.push("<td><a href='../company/?id="+json[i].c_id+"'>"+json[i].c_id);
        htm.push("<td>"+json[i].c_name);
        htm.push("<td>"+json[i].c_type);
        htm.push("<td>"+json[i].c_country);
        htm.push("</tr>");
    }
    htm.push("</tbody>");
    htm.push("</table>");

    target.html(htm.join(''));
}

$(function(){
    console.log("ready");
    
    $('#btnCreateComp').click(function(){
        createCompany();
    });

    getCompanyList();

});
