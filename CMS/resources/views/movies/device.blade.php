@extends('layout.setting_layout')
@section('setting_content')

<input type="hidden" id="id" value="-1"/>

<div class="container" style="width:100%;"> 
	<div class="row"> 
		<div class="col-sm-offset-1 col-md-10"> 
			<div class="panel panel-primary" style="background: rgba(183, 216, 183, 0.74902);"> 
				<div class="panel-heading" style="background:#2c7796;"> 
					<button type="button" class="btn btn-success1 btn-xs" style="float:right;" data-toggle="modal" data-target="#addModal" onClick="onShowEditRow(-1)">
						<span class="glyphicon glyphicon-plus"></span>
						<b> Add New </b>
					</button>   
					<button type="button" class="btn btn-success1 btn-xs" style="float:right;margin-right:20px;" data-toggle="modal" data-target="#importModal" onClick="onShowEditRow(-1)">
						<span class="glyphicon glyphicon-plus"></span>
						<b> Import Device </b>
					</button>  					
					<span style="font-size:20px;margin-left:0px;">Device List</span>
				</div>                         
				<div class="panel-body"> 
					<table id="category_grid" class="table table-hover table-bordered" style="width:100%;text-align: center"> 
						<thead> 
							<tr> 
								<th style="text-align: center">
									<input type="checkbox" id="checkall" />
								</th>
								<th style="text-align: center">
									<b>ID</b>
								</th>
								
								<th style="text-align: center">
									<b>MAC Address</b>
								</th>

								<th style="text-align: center">
									<b>Serial Number</b>
								</th>

								<th style="text-align: center">
									<b>Updated Date</b>
								</th>

								<th style="text-align: center">Edit</th>
								<th style="text-align: center">Delete</th>
							</tr>                                     
						</thead>                    
					</table>                             
				</div>
			</div>                     
			
			
								 
		</div>                 
	</div>   
</div>		
	
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog" role="document"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
					<span aria-hidden="true">&times;</span> 
				</button>                             
				<h3 class="modal-title" style="color:#2691d9" id="addModalLabel">Add Time slab</h3> 
			</div>                         
			<div class="modal-body"> 
				<br> 
				<form class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-sm-4" for="client">MAC Address : </label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="macaddress" placeholder="MAC Address" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="description">Serial Number : </label>
						<div class="col-sm-5" style="    width: 350px;">
							<input type="text" class="form-control" id="serialno" placeholder="Serial Number" value="">
						</div>
					</div>
				</form>                             
			</div>                         
			<div class="modal-footer " id="createButton">
				<button type="button" class="btn btn-success1 btn-sm" data-dismiss="modal" onClick="onUpdateRow()">
					<span class="glyphicon glyphicon-ok"></span>
					<b> Save</b>
				</button>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"></span>
					<b> Cancel</b>
				</button>
			</div>
	
			<div class="modal-footer " id="updateButton">
				<button type="button" class="btn btn-warning btn-lg" style="width: 100%;"  data-dismiss="modal" onClick="onUpdateRow()">
					<span class="glyphicon glyphicon-ok-sign"></span> Update
				</button>
			</div>
		</div>                     
	</div>                 
</div>     
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog" role="document"> 
		<div class="modal-content"> 
			<div class="modal-header"> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"> 
					<span aria-hidden="true">&times;</span> 
				</button>                             
				<h3 class="modal-title" style="color:#2691d9" id="addModalLabel">Import Device</h3> 
			</div>
				{!! Form::open(['url'=>url('/movies/devicegrid/importdata'),'class'=>'form-horizontal', 'id'=>'importform','enctype'=>'multipart/form-data']) !!}                                               
			<div class="modal-body"> 
				<br> 
				
					<div class="form-group">
						<label class="control-label col-sm-4" for="client">Device List File : </label>
						<div class="col-sm-5">
							<input type="file" class="form-control" id="devicelist" name="devicelist" placeholder="Device List File" value="">
							<span>File Type : *.csv</span>
						</div>
					</div>                        
			</div>                     
			<div class="modal-footer " id="createButton">
				<button type="button" class="btn btn-success1 btn-sm" data-dismiss="modal" onClick="onImportRow()">
					<span class="glyphicon glyphicon-ok"></span>
					<b> Import</b>
				</button>
				<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
					<span class="glyphicon glyphicon-remove"></span>
					<b> Cancel</b>
				</button>
			</div>
			{!! Form::close() !!}  
	
		</div>                     
	</div>                 
</div>            

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				</button>
				<h3 class="modal-title" style="color:#2691d9" id="Heading">Delete a Device</h3>
			</div>
			<br>
			<div class="modal-body">
				<div class="alert alert-danger">
					<span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete?                   
				</div>
			</div>
			<div class="modal-footer ">
				<div class="modal-footer ">
					<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" onClick="deleteRow()">
						<span class="glyphicon glyphicon-ok"></span>
						<b> Yes</b>
					</button>
					<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">
						<span class="glyphicon glyphicon-remove"></span>
						<b> No</b>
					</button>
				</div>
			</div>
			<!-- /.modal-content -->                     
		</div>
		<!-- /.modal-dialog -->                 
	</div>
</div>	

<script>
	$('.col-sm-12').css('max-hgeight','500px ! important');
	$('.col-sm-12').css('overflow-y','5scroll');
	var $grid = $('#category_grid').dataTable( {
		processing: true,
		serverSide: true,
		ajax: '/movies/devicegrid/get',
		//"lengthMenu": [[1, 2, 5, -1], [1, 2, 5, "All"]],
		columns: [
			{ data: 'checkbox', orderable: false, searchable: false},
			{ data: 'id', name: 'id' },
			{ data: 'macaddress', name: 'macaddress' },
			{ data: 'serialno', name: 'serialno' },
			{ data: 'created_at', name: 'created_at' },
			{ data: 'edit', orderable: false, searchable: false},
			{ data: 'delete', orderable: false, searchable: false}
		]
	});	
	
	function refreshCurrentPage()
	{
		var oSettings = $grid.fnSettings();
		var page = Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength);
		$grid.fnPageChange(page);
	}
	function onImportRow(){
		$('#importform').submit();
	}
	function onShowEditRow(id)
	{	
		$("#id").val(id);
				
		$('#macaddress').val("");
		$("#serialno").val("");
		
		if( id > 0 )	// Update
		{
			$('#createButton').hide();
			$('#updateButton').show();
			$('#addModalLabel').text("Update Device");
			
			$.ajax({
				url: "/movies/device/" + id,
				success:function(data){
					console.log(data);
					$('#macaddress').val(data.macaddress);
					$('#serialno').val(data.serialno);				
				},			
				error:function(request,status,error){
					//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	
		}
		else
		{
			$('#addModalLabel').text("Add Device");
			$('#createButton').show();
			$('#updateButton').hide();
		}		
	}
	
	function onUpdateRow()
	{
		var id = $("#id").val();
		
		var macaddress = $("#macaddress").val();
		var serialno = $("#serialno").val();
		var data = {
			id : id,
			macaddress: macaddress,
			serialno: serialno
			};

					
		if( id >= 0 )	// Update
		{
			$.ajax({
				type: "POST",
				url: "/movies/devicegrid/updatedata",
				data: data,
				success:function(data){
					
					refreshCurrentPage();					
				},			
				error:function(request,status,error){
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	
		}
		else			// Add
		{
			$.ajax({
				type: "POST",
				url: "/movies/devicegrid/createdata",
				data: data,
				success:function(data){
					$grid.fnPageChange( 'last' );
				},			
				error:function(request,status,error){
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	
		}
	}	
	
	function onDeleteRow(id)
	{
		$("#id").val(id);
		
		if( id >= 0 )
		{
			$.ajax({
				url: "/movies/devicegrid/" + id,
				success:function(data){
					$("#delete_item").text("\"" + data.section + "\"");		
				},			
				error:function(request,status,error){
					//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	
		}
		
	}
	
	function  deleteRow()
	{
		var id  = $("#id").val();
		
		if( id >= 0 )
		{
			$.ajax({
				url: "/movies/devicegrid/delete/" + id,
				success:function(data){					
					refreshCurrentPage();					
				},			
				error:function(request,status,error){
					//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	
		}
	}
			
</script>    


@stop	