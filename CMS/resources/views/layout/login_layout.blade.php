@extends('layout.logintop')
@section('content')
	<section style="float:left;width:100%;height:100%">
		<link href="/css/admin_setting.css" rel="stylesheet">
		<div id="setting_div" style="margin-top:50px;width:auto;">
			
			<div id="">
				<div id="setting_sub_content" style="background-color:#00ffffff;">
				@section('setting_nav')
					<div style="clear:both;margin-top:50px;positive:relative">
						@yield('setting_content')								
					</div>	
				@show	
				
				</div>
			
			</div>	
		</div>	
	</section>
	
@stop