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
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
	</head>
	<body>
		<div class="container">

      <form class="form-signin" action="login.php" method="POST" onsubmit="return validateForm()">
        <h2 class="form-signin-heading">Please sign in</h2>
        <input type="text" class="input-block-level"  placeholder="Username" name="username">
        <input type="password" class="input-block-level" placeholder="Password" name="password">
        <input type="submit" class="btn btn-large btn-success" name="action" value="Sign In">
        <input type="submit" class="btn btn-large btn-danger" name="action" value="Sign Up">
      </form>
      <h1>My heart is, and always will be, yours.</h1>
		<h2>- Sense and Sensibility</h2>

    </div> <!-- /container -->
		<script type="text/javascript">
			$(document).ready(function(){
				//background image
				$.backstretch("img/love.jpg");
				//set container height
				$(".container").css("height",$(window).height());
	
				$("button#sign-in").click(function(){
					alert("singn");
					var username = $("input#username").val();
					var password = $("input#password").val();
					$.ajax({
						type: "POST",
						url: "login.php",
						data: {username: username, password: password},
					});
				});				

			});
			function validateForm(){
				var username = $("input[name='username']").val().trim();
				if(!username){
					alert("Username is empty.");
					return false;
				}
				var password = $("input[name='password']").val().trim();
				if(!password){
					alert("Password is empty.");
					return false;
				}
				return true;
			}
			
		</script>
	</body>
</html>