@extends('layout.login_layout')
@section('setting_content')

<input type="hidden" id="id" value="-1"/>
{!! Html::style('css/iCheck/all.css') !!}
{!! Html::script('js/iCheck/icheck.min.js') !!}
<div class="container" style="width:100%;border:0px;"> 
	<div class="row"> 
		<div class="col-sm-offset-1 col-md-10"> 
			<div class="panel panel-primary" style="background-color: transparent;border-color: #509449;"> 
				<div style="height:50px;padding-top:5px;">                            
					<h3 class="modal-title" style="color:#fff" id="addModalLabel">MOVIES ADMIN PANEL</h3> 
				</div>     
				{!! Form::open(['route' => 'post-admin-login', 'class'=>'form-horizontal']) !!}				
				<div class="modal-body"> 
					<br> 
					
					
						{!! csrf_field() !!}
						@if (isset($errors) && count($errors) > 0)
							<div class="alert alert-danger col-md-12">
								<ul>
									@foreach ($errors->all() as $error)
										<li>{!! $error !!}</li>
									@endforeach
								</ul>
							</div>
						@endif
						@if(Session::has('invalid_login'))
							<div class="alert alert-danger col-md-12">
								<p>{{ Session::get('invalid_login') }}</p>
							</div>
						@endif    
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">User name : </label>
							<div class="col-sm-5">
								<input type="text" class="form-control" required id="username" name="username" placeholder="User name" value="">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-4" for="client">Password : </label>
							<div class="col-sm-5">
								<input type="password" class="form-control" required id="password" name="password" placeholder="Password" value="">
							</div>
						</div>                          
				</div>                         
				<div class="modal-footer " id="createButton" style="    text-align: center;">
					<button type="submit" class="btn btn-success" data-dismiss="modal">
						<span class="glyphicon "></span>
						<b> Login</b>
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
.panel-primary {
    border-color: #fff;
}
.modal-footer{
	border:0
}
</style>
<script>
			
</script>    


@stop	