<!doctype html>
<html lang="en">

	@include('layout.header')

	<body align="center" style="    width: 100%;
    height: 100%;
    background: url('images/covers.jpg');
    background-size: cover;">

		<div id = "total_div" style="display:none;">
			<div id="content_back">				
				@yield('content')				
			</div>
		</div>

	</body>
	
	<script>
	$(function () {
		var screenwidth = window.innerWidth;
		var screenheight = window.innerHeight;	
		var margin = (screenwidth - 700) / 2;
		$('#total_div').css('margin-left', margin+'px');
		$('#total_div').css('width', '700px');
		$('#total_div').css('display', 'block');
	});
	</script>
</html>