<!doctype html>
<html lang="en">

	@include('layout.header')

	<body align="center">

		<div id = "total_div" style="display:none">
			@include('layout.topmenu')
			<div id="content_back">				
				@yield('content')				
			</div>
		</div>

	</body>
	
	<script>
	$(function () {
		var screenwidth = window.innerWidth;
		var screenheight = window.innerHeight;	
		var margin = (screenwidth - 1200) / 2;
		//$('#total_div').css('margin-left', margin+'px');
		$('#total_div').css('width', screenwidth-3+'px');
		$('#setting_sidebar').css('width', '200px');
		$('#setting_content').css('width', screenwidth - 203 + 'px');
		$('#setting_sidebar').css('height', screenheight-80+'px');
		$('#setting_content').css('height', screenheight-80+'px');
		$('.panel-primary').css('height', screenheight-200+'px');
		$('.col-sm-12').css('height', screenheight-300+'px');
		$('#total_div').css('display', 'block');
	});
	</script>
</html>