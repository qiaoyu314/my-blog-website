<?php

session_start();
if(!(isset($_SESSION['login']))){
	$_SESSION['prev_page'] = "answerquestions.php";
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
	<style type="text/css">
	table{

		margin: 2%;
	}
	td.answer{
		padding-left: 5%;
		padding-right: 5%;
	}
	</style>
</head>
<body>
	<?php 
		set_navi(4); 
	?>
	<div class="container">
		<?php 
		//generate HTML form of questions
		$con = createConnection();
		$friend = getFriend($con, $_SESSION['login']);
		$_SESSION['friend'] = $friend;
		getHTMLQuestions($con, $friend);
		?>

	</div>
<script type="text/javascript">
	$("tr").hover(function(){
		$(this).css("background-color", "#d8ecd5");
	}, function(){
		$( this ).css("background-color", "transparent")
	});
</script>
</body>
</html>
