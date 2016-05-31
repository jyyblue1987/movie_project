@extends('layout.layout')
@section('content')
	<section style="float:left;width:100%;height:100%">
		<link href="/css/admin_setting.css" rel="stylesheet">
		<div id="setting_div">
			
			<div id="setting_sidebar" class="sidebar_back" style="background:#4B8445;">
				@include('layout.sidebar')
			</div>
			<div id="setting_content">
				<div id="setting_sub_content" style="    border-color: #4B8445;    border-style: solid;">
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