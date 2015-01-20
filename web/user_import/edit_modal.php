<!-- Button trigger modal
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
	Launch demo modal
</button>
 -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><i class='fa fa-edit'></i> Edit tmp user record</h4>
			</div>
			<div class="modal-body">
				
			
				<input type="hidden" class="form-control" id="sbi_id" value=''>
				
				<div class="row">
					<div class="form-group">
						<label>Email</label>
						<input type="text" class="form-control" id="email" placeholder="Email" value="">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label>Login</label>
						<input type="text" class="form-control" id="login" placeholder="Username" value="">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label>First name</label>
						<input type="text" class="form-control" id="firstname" placeholder="First name" value="">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label>Last name</label>
						<input type="text" class="form-control" id="lastname" placeholder="Last name" value="">
					</div>
				</div>
				

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class='fa fa-times'></i> Close</button>
				<button type="button" class="btn btn-primary" onclick='saveRecord()'><i class='fa fa-save'></i> Save changes</button>
			</div>
		</div>
	</div>
</div>

<script>

function editRecord(id){
	
	if(!id){
		console.log('error');
		return false;
	}

	$('#editModal').modal(true);
	$('#more').load('ctrl.php',{'do':'getRecord','id':id},function(x){
		try{
			eval(x);
			$('#more').html('');
		}
		catch(e){
			console.log(e);
		}
	});
}

function saveRecord(){
	console.log('saveRecord()');
	var p ={
		'do':'saveSbi',
		'sbi_id':$('#sbi_id').val(),
		'email':$('#email').val(),
        'login':$('#login').val(),
        'firstname':$('#firstname').val(),
        'lastname':$('#lastname').val()
	}
	$('#boxlist .box-body').load("ctrl.php",p,function(x){
		try{
			eval(x);
			$('#editModal').modal('hide');
		}
		catch(e){
			console.log("error:",e);
		}
	})
}
</script>