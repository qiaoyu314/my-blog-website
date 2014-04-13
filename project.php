<?php
session_start();
if(isset($_SESSION['login'])){
	$currentUser = $_SESSION['login'];
}

include 'template/navi.php';
require "include/dbConnection.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'template/head.php' ?>
</head>
<body>
	<?php 
		set_navi(2);
	?>
	<div class="container">
		<h2>Under Construction...</h2>
	<div id="footer">
	<!--button type="button" class="btn btn-primary" id="load_More">Load More</button>
	<img src="img/loading.jpg" id="load_More"-->
	</div>
	</div>
	<script type="text/javascript">



		
	</script>
	<!--audio controls autoplay>
  	<source src="audio/1.mp3" type="audio/mpeg">
  	Your browser does not support the audio element.
	</audio-->

</body>
</html>