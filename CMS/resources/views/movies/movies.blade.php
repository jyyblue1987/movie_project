@extends('layout.setting_layout')
@section('setting_content')


<div class="container" style="width:100%;"> 
	<div class="row"> 
		<div class="col-sm-offset-1 col-md-10"> 
			<div class="panel panel-primary" style="background: rgba(183, 216, 183, 0.74902);"> 
				<div class="panel-heading" style="background:#2c7796;"> 
					<button type="button" class="btn btn-success1 btn-xs" style="float:right;" data-toggle="modal" data-target="#addModal" onClick="onShowEditRow(-1)">
						<span class="glyphicon glyphicon-plus"></span>
						<b> Add New </b>
					</button>                             
					<span style="font-size:20px;margin-left:0px;">Movie List</span>
				</div>                         
				<div class="panel-body"> 
					<table id="movie_grid" class="table table-hover table-bordered" style="text-align: center;width: 100%;"> 
						<thead> 
							<tr> 
								<th style="text-align: center" style="width:2%">
									<input type="checkbox" id="checkall" />
								</th>
								<th style="text-align: center" style="width:2%">
									<b>ID</b>
								</th>								
								<th style="text-align: center" style="width:8%">
									<b>Category</b>
								</th>							
								<th style="text-align: center" style="width:8%">
									<b>Country</b>
								</th>
								<th style="text-align: center" style="width:20%">
									<b>Movie Name</b>
								</th>

								<th style="text-align: center" style="width:35%">
									<b>Description</b>
								</th>
								<th style="text-align: center" style="width:25%">
									<b>Movie URL</b>
								</th>
								<th style="text-align: center" style="width:25%">
									<b>Thumbnail</b>
								</th>
								<th style="text-align: center" style="width:25%">
									<b>Background</b>
								</th>

								<th style="text-align: center" style="width:7%">
									<b>Updated Date</b>
								</th>

								<th style="text-align: center" style="width:5%">Edit</th>
								<th style="text-align: center" style="width:5%">Delete</th>
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
				{!! Form::open(['url'=>url('/movies/moviesgrid/updatedata'),'class'=>'form-horizontal', 'id'=>'movieform','enctype'=>'multipart/form-data']) !!}                      
				
					<input type="hidden" id="id" name="id" value="-1"/>
			<div class="modal-body"> 
				<br> 
					<div class="form-group">
						<label class="control-label col-sm-4" for="client">Category : </label>
						<div class="col-sm-5">
							<?php echo Form::select('catid', $category, '1', array('class'=>'form-control', 'id' => 'catid', 'name' => 'catid')); ?>	
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="client">Country : </label>
						<div class="col-sm-5">
							<?php echo Form::select('cid', $country, '1', array('class'=>'form-control', 'id' => 'cid', 'name' => 'cid')); ?>	
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="client">Movie Name : </label>
						<div class="col-sm-5">
							<input type="text" class="form-control" id="name" name="name" placeholder="Movie name" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="description">Description : </label>
						<div class="col-sm-5" style="    width: 350px;">
							<textarea class="form-control" rows="3" id="desc"  name="desc" size="40" placeholder="Description"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="path">Movie URL : </label>
						<div class="col-sm-5" style="    width: 350px;">
							<input type="text" class="form-control" id="path" name="path" placeholder="Movie url" value="" size="40">
							<span style="float:left">OR</span>
							<input type="file" class="form-control" id="videofile" name="videofile" placeholder="Video file" value="" size="40">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-4" for="thumb">Thumbnail : </label>
						<div class="col-sm-5" style="    width: 350px;">
							<input type="file" class="form-control" id="thumb" name="thumb" placeholder="thumbnail" value="" size="40">
						</div>
					</div>    
					<div class="form-group">
						<label class="control-label col-sm-4" for="thumb">Background : </label>
						<div class="col-sm-5" style="    width: 350px;">
							<input type="file" class="form-control" id="background" name="background" placeholder="Background" value="" size="40">
						</div>
					</div>                       
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
				<h3 class="modal-title" style="color:#2691d9" id="Heading">Delete a Movie</h3>
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
<style>
.col-sm-12 {
	width: 100%;	
	height:500px;
	overflow-y:scroll;
}
</style>
<script>
	$('.col-sm-12').css('max-hgeight','500px ! important');
	$('.col-sm-12').css('overflow-y','scroll');
	var $grid = $('#movie_grid').dataTable( {
		processing: true,
		serverSide: true,
		ajax: '/movies/moviesgrid/get',
		//"lengthMenu": [[1, 2, 5, -1], [1, 2, 5, "All"]],
		columns: [
			{ data: 'checkbox', orderable: false, searchable: false},
			{ data: 'id', name: 'm.id' },
			{ data: 'catname', name: 'cat.name' },
			{ data: 'cname', name: 'c.name' },
			{ data: 'name', name: 'm.name' },
			{ data: 'desc', name: 'm.desc' },
			{ data: 'path', name: 'm.path' },
			{ data: 'thumb', name: 'm.thumb' },
			{ data: 'background', name: 'm.background' },
			{ data: 'created_at', name: 'm.created_at' },
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
	
	function onShowEditRow(id)
	{	
		$("#id").val(id);
					
		$('#cid').val("");
		$('#catid').val("");
		$('#name').val("");
		$("#desc").val("");
		$("#path").val("");
		$("#thumb").val("");
		$("#videofile").val("");
		$("#background").val("");
		
		if( id > 0 )	// Update
		{
			$('#createButton').hide();
			$('#updateButton').show();
			$('#addModalLabel').text("Update Movie");
			
			$.ajax({
				url: "/movies/movies/" + id,
				success:function(data){
					console.log(data);
					$('#cid').val(data.cid);
					$('#catid').val(data.catid);
					$('#name').val(data.name);
					$('#desc').val(data.desc);	
					$('#path').val(data.path);			
				},			
				error:function(request,status,error){
					//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	
		}
		else
		{
			$('#addModalLabel').text("Add Movie");
			$('#createButton').show();
			$('#updateButton').hide();
		}		
	}
	
	function onUpdateRow()
	{
		var id = $("#id").val();		
		if( id >= 0 )	// Update
		{
			document.getElementById('movieform').action="/movies/moviesgrid/updatedata";
			$('#movieform').submit();
			/* $.ajax({
				type: "POST",
				url: "/movies/moviesgrid/updatedata",
				data: data,
				success:function(data){
					
					refreshCurrentPage();					
				},			
				error:function(request,status,error){
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	 */
		}
		else			// Add
		{
			document.getElementById('movieform').action="/movies/moviesgrid/createdata";
			$('#movieform').submit();
			/* $.ajax({
				type: "POST",
				url: "/movies/moviesgrid/createdata",
				data: data,
				success:function(data){
					$grid.fnPageChange( 'last' );
				},			
				error:function(request,status,error){
					alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
				}
			});	 */
		}
	}	
	
	function onDeleteRow(id)
	{
		$("#id").val(id);
		
		if( id >= 0 )
		{
			$.ajax({
				url: "/movies/moviesgrid/" + id,
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
				url: "/movies/moviesgrid/delete/" + id,
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