
function trashThread(id){
    
    if(!confirm("Delete this thread ?")){
        return false;
    }

    $('#recentmsg').html('Please wait...');
    $('#recentmsg').load('ctrl.php',{'do':'trashThread','id':id},function(x){
        try{eval(x);}
        catch(e){alert(x);}
    });
}
