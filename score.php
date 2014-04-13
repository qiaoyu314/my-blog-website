<?php

session_start();
if(!(isset($_SESSION['login']))){
	$_SESSION['prev_page'] = "score.php";
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
	<script src="js/imagesloaded.pkgd.min.js"></script>
	<style type="text/css">
	#socre_title
	{
		margin-top: 10%;
		margin-bottom: 5%; 
	}
	.progress{
		height: 50px;
		width: 80%;
	}
	.jumbotron{
		opacity:1;
	}
	.progress{
		margin: 2%;
	}
	</style>
</head>
<body>
	<?php 
		set_navi(5); 
	?>
	<div class="container">
		

		<div class="jumbotron">
	    <br>
	    <?php
	    	$con = createConnection();
	    	$score = getScore($con, $currentUser);
	    	if ($score == -1){
	    		echo "No score on file.";
	    	}else{
	    		echo "<h1>你的得分是 <span class='label label-warning'>$score</span></h1><br><br>";
	    		getHTMLProcessBar($score);	
	    	}
	    ?>
		</div>
		</div>
</body>
</html>
