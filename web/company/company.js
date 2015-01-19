

$(function(){
	
	$('#btnSave').click(function(){
		
		console.log('save');
		
		var p={
			'do':'save',
			'id':$('company_id').val()
		};
		
		$("#boxinfo .overlay, #boxinfo .loading-img").show();
		$('#boxinfo .box-body').load('ctrl.php',p,function(x){
			try{
				eval(x);
			}
			catch(e){
				console.log('error',x);
				$("#boxinfo .overlay, #boxinfo .loading-img").hide();
			}
		});
	});

	$('#btnDelete').click(function(){
		
		if(!confirm("Delete this company and associated data ?"))return false;
		
		$("#boxinfo .overlay, #boxinfo .loading-img").show();	
		$('#boxinfo .box-body').load('ctrl.php',{'do':'delete','id':$('company_id').val()},function(x){
			try{
				eval(x);
			}
			catch(e){
				console.log('error',x);
				$("#boxinfo .overlay, #boxinfo .loading-img").hide();
			}
		});
	});
	
	$("#boxinfo .overlay, #boxinfo .loading-img").hide();

	console.log('ready');
});