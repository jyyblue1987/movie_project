@section('sidebar')
<div class="left_menu" style="background:#048cb1 !important;">
<?php
	$select_option1 = "#fff";
	$select_option2 = "#fff";
	$select_option3 = "#fff";
	$select_option4 = "#fff";
	$confirm = explode('movies/category', URL::to('/').'/'.Route::getCurrentRoute()->getPath());	
	if(count($confirm) > 1){
		$select_option1 = "#98D4EC";
	}
	$confirm = "";
	$confirm = explode('movies/movies', URL::to('/').'/'.Route::getCurrentRoute()->getPath());	
	if(count($confirm) > 1){
		$select_option2 = "#98D4EC";
	}
	
	$confirm = "";
	$confirm = explode('movies/profile', URL::to('/').'/'.Route::getCurrentRoute()->getPath());	
	if(count($confirm) > 1){
		$select_option3 = "#98D4EC";
	}
	$confirm = "";
	$confirm = explode('movies/country', URL::to('/').'/'.Route::getCurrentRoute()->getPath());	
	if(count($confirm) > 1){
		$select_option4 = "#98D4EC";
	}
?>	

	<style>
	.fa-list-alt:hover{
		color:#aaa;
	}
	.fa-file-video-o:hover{
		color:#aaa;
	}
	.fa-user:hover{
		color:#aaa;
	}
	.fa-sign-out:hover{
		color:#aaa;
	}
	</style>
	<div class="eachmenu" style="margin-top:47px;margin-left:0px;">		
		<p id="setup_wizard"><i class="fa fa-gear" style="width:25px;font-size:25px;color:#fff"></i><span style="margin-top:-5px;font-size:25px;font-weight:bold;color:#fff">&nbsp;&nbsp;MENU<span></p>
	</div>
	<div class="eachmenu" style="margin-top:27px;">		
		<a href="/movies/category" style="color:<?php echo $select_option1;?>">
		<i id="menuitem1" class="fa fa-list-alt" style="font-size:20px;">&nbsp;&nbsp;&nbsp;Category</i>
		</a>
	</div>
	<div class="eachmenu" style="margin-top:27px;">	
		<a href="/movies/country" style="color:<?php echo $select_option4;?>">
		<i id="menuitem5" class="fa fa-file-video-o" style="font-size:20px;">&nbsp;&nbsp;&nbsp;Country</i>
		</a>
	</div>
	<div class="eachmenu" style="margin-top:27px;">	
		<a href="/movies/movies" style="color:<?php echo $select_option2;?>">
		<i id="menuitem2" class="fa fa-file-video-o" style="font-size:20px;">&nbsp;&nbsp;&nbsp;Movies</i>
		</a>
	</div>
	<div class="eachmenu" style="margin-top:27px;">
		<a href="/movies/profile" style="color:<?php echo $select_option3;?>">
		<i id="menuitem3" class="fa fa-user" style="font-size:20px;">&nbsp;&nbsp;&nbsp;Admin Setup</i>
		</a>
	</div>
	<div class="eachmenu" style="margin-top:27px;">
		<a href="/logout" style="color:#fff;">
		<i id="menuitem4" class="fa fa-sign-out" style="font-size:20px;">&nbsp;&nbsp;&nbsp;Log out</i>
		</a>
	</div>
</div>
@show