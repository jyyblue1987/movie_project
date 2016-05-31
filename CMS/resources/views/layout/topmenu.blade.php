@section('topmenu')
<link href="/css/topmenu.css" rel="stylesheet">
<header>
	<div id = "topbar" style="width:100%;height:70px;background: #2c7796;border-radius: 2px 2px 0 0;padding-top:10px;text-align:left;padding-left:20px;">
		
		<i class="fa fa-video-o" style="font-size:45px;font-weight:bold;font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;color:#fff;">		
		Movies
		</i>
		<span style="color:#fff;margin-left:30%;font-size:20px;font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;">
		<?php
		$maintitle = "";
		if(isset($_SESSION['maintitle'])){
			$maintitle = $_SESSION['maintitle'];
		}
		echo $maintitle.' Management';
		?>
		</span>
	</div>
</header>

@show