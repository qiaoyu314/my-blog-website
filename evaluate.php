<?php

session_start();
if(!(isset($_SESSION['login']))){
	$_SESSION['prev_page'] = "evaluate.php";
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
	</style>
</head>
<body>
	<?php 
		set_navi(4); 
	?>
	<div class="container">
	<div class="jumbotron">
	<?php
		//first check if he/she has a friend
		$hasFriend = false;
		$con = createConnection();
		$friendUserName = getFriend($con, $currentUser);
		if($friendUserName == -1){
			echo "Sorry. I can't find needed info.";
		}else if(is_null($friendUserName)){
			echo "Sorry. You don't a friend on file.";
		}else{
			$hasFriend = true;
		}

		if($hasFriend){
			//show the score
			$isAnswered = isAnswered($con, $friendUserName);
			if($isAnswered == -1){
				echo "Error: not able to find the record of user.";
			}else{
				$score = getScore($con, $friendUserName);
				if ($score == -1){
	    		echo "Error: not able to find the record.";
	    		
	    		}else{
	    			echo "<h1>你爱人的得分是 <span class='label label-info'>$score</span></h1><br><br><br>";
	    			getHTMLProcessBar($score);	
	    			echo '<br><br>';
	    		}
				if($isAnswered == 0){
					//gnerate HTML to allow user to answered the qeustions
					echo '<h2>你还没有为他回答问题</h2><a href="answerquestions.php" class="btn btn-primary btn-lg">开始答题!</a>';
				}else{
					echo '<h2>你已经为他回答过问题</h2><a href="answerquestions.php" class="btn btn-primary btn-lg">重新答题!</a>';
				}
			}
		}else{
			//generate the HTML to allow user add friend 
		}

		//get unanswered questions for a user



		$questionArray = getUnansweredQuestions($con,"a");
		$question = $questionArray;
		print_r($questionArray[1][0]); 
	?>
	</div>	
	</div>

</body>
</html>
