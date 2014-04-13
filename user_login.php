<?php
	session_start();
	if(isset($_SESSION['login'])){
		unset($_SESSION['login']);
	}

?>
<!DOCTYPE html>
<html>
	<head>
		<?php include 'template/head.php' ?>	
		<script type="text/javascript" src="js/jquery.backstretch.min.js"></script>
		<style type="text/css">
		.row
		{
			margin-top: 5%;
		}
		h1.lg{
			font-size: 100px;
			text-align:center;
		}
		h2
		{
			font-style: italic;
		}
		form
		{
			margin-top: 10%;
		}
		div#form
		{
			margin-left: 40%;
			padding: 2% 5% 2% 5%;
			border-radius:10px;
			background-color: #eeeeee;
			opacity: 0.8;
		}
		input
		{
			margin: 3% 0 3% 0;
		}
		#login{
			margin-top: 3%;
		}
		.btn
		{
			background-color: #e23351;
		}
		#login_title
		{
			margin-bottom: 14%;
		}
		</style>
	</head>
	<body>
		<div class="row">
			<div class="col-sm-4 col-sm-offset-7">
				<h1>My heart is, and always will be, yours.</h1>
				<h2>- Sense and Sensibility</h2>
				<form role="form" action="login.php" method="POST">
					<div class="form-group col-lg-6" id="form" >
						<h3 id="login_title">Please login</h3>
						<input type="text" class="form-control" placeholder="Username" name="username">
						<input type="password" class="form-control" placeholder="Password" name="password">
						<button type="submit" class="btn btn-lg btn-default" id="login">Login</button>
					</div>
					
				</form>
				<!--button type="button" class="btn btn-danger btn-lg" onclick="location.href=('gallery.php');"><h2>View without account</h2></button-->
			</div>
		</div>

		<script type="text/javascript">
			//background image
			$.backstretch("img/love.jpg");
			//set container height
			$(".container").css("height",$(window).height());
			//set the button postion 
		</script>
	</body>
</html>