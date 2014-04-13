<?php
session_start();
if(!(isset($_SESSION['login']))){
	$_SESSION["prev_page"] = "gallery.php";
	header("Location: user_login.php");
}else{
	$currentUser = $_SESSION['login'];
}

include 'template/navi.php';
include 'include/image.php';
require "include/dbConnection.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'template/head.php' ?>
	<script src="js/jquery.masonry.min.js"></script>
	<script src="js/jquery.waitforimages.min.js"></script>
	<style type="text/css">
	.container
	{
		height: auto;
	}
	.item 
	{
		width: 200px;
		margin: 20px;
		padding: 5px;
		background: #D8D5D2;
		
		font-size: 11px;
		line-height: 1.4em;
		float: left; 
		-webkit-border-radius: 5px;
		-moz-border-radius: 5px;
		border-radius: 5px;
		
	}
	.item img{
		display: none;
	}
	#footer{
		margin-left: auto;
		margin-right: auto;
		width: 20%;
	}
	//button#load_More{
		width: 100%;
	}
	img#load_More{
		margin-left: 30%;
		display: none;
	}
	</style>
</head>
<body>
	<?php 
		set_navi(3);
	?>
	<div class="container">
	<div id="img_container">
		<?php
			loadImage("img/test/", 0);
		?>
	</div>
	<div id="footer">
	<button type="button" class="btn btn-primary btn-round" id="load_More">Load More</button>
	<img src="img/loading.jpg" id="load_More">
	</div>
	</div>

	<script type="text/javascript" src="js/waterfall.js"></script>

</body>
</html>
