
function closeThread(b){
    
    if(b && !confirm("Close this thread ?"))return false;
    if(!b && !confirm("Re-open this thread ?"))return false;
    
    $('#moreInfo').html("Please wait...");
    $('#moreInfo').load("ctrl.php",{'do':'closeThread','status':b,'id':$('#id').val()},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}


function trashThread(){
	
	console.log('trashThread()', $('#id').val());

    if(!confirm("Delete this thread completely ?"))return false;
    if(!confirm("This is not reversible, are you sure ?"))return false;
    
    if(!$('#id').val()){
    	console.log('error : no threadid');
    	return false;
    }

    $('#moreInfo').html("Please wait...");
    $('#moreInfo').html("Please wait...");
    $('#moreInfo').load("ctrl.php",{'do':'trashThread', 'id':$('#id').val()},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}


function deleteContent(id){
	
	if(!id)return false;
	
	console.log('deleteContent',id);

	if(!confirm("Confirm deletion ?"))return false;	
	
	$('#moreInfo').html("Please wait...");
    $('#moreInfo').load("ctrl.php",{'do':'trash','thread_id':$('#id').val(), 'id':id},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}