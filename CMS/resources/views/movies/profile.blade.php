@extends('layout.setting_layout')
@section('setting_content')

<input type="hidden" id="id" value="-1"/>

{!! Html::style('css/iCheck/all.css') !!}
{!! Html::script('js/iCheck/icheck.min.js') !!}
<div class="container" style="width:100%;"> 
	<div class="row"> 
		<div class="col-sm-offset-1 col-md-10"> 
			<div class="panel panel-primary" style="background: rgba(183, 216, 183, 0.74902);"> 
				<div style="background:#2c7796;height:50px;padding-top:5px;">                            
					<h3 class="modal-title" style="color:#fff" id="addModalLabel">Admin Profile</h3> 
				</div>     
				{!! Form::open(['route' => 'post-admin-update', 'class'=>'form-horizontal']) !!}	          
				<div class="modal-body"> 
					<br> 
						{!! csrf_field() !!}
						
						@if(Session::has('invalid_login'))
							<div class="alert alert-danger col-md-12">
								<p>{{ Session::get('invalid_login') }}</p>
							</div>
						@endif 
						@if(Session::has('success'))
							<div class="alert alert-success col-md-12">
								<p>{!! Session::get('success') !!}</p>
							</div>
						@endif  
						
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">Admin Name : </label>
							<div class="col-sm-5">
								<input type="text" class="form-control" id="name" name="name" required placeholder="admin name" value="{{ $profile->username }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">Old Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" required id="opassword" name="opassword" placeholder="Old password" value="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">New Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" required id="npassword" name="npassword" placeholder="New password" value="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">Confirm Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" required id="cpassword" name="cpassword" placeholder="Confirm password" value="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">Admin Email : </label>
							<div class="col-sm-5">
								<input type="text" class="form-control" required id="email" name="email" placeholder="Admin email" value="{{ $profile->email }}">
							</div>
						</div>                         
				</div>                         
				<div class="modal-footer " id="createButton">
					<button type="submit" class="btn btn-success1 btn-sm" data-dismiss="modal">
						<span class="glyphicon glyphicon-ok"></span>
						<b> Update</b>
					</button>
				</div>
				{!! Form::close() !!}   
			</div>                     
			
			
								 
		</div>                 
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
			
</script>    


@stop	