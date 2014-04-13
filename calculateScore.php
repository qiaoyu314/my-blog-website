<?php
  session_start();
  if(!(isset($_SESSION['login']))){
    $_SESSION['prev_page'] = "calculateScore.php";
    header("Location: user_login.php");
  }else{
    $currentUser = $_SESSION['login'];
    $friend = $_SESSION['friend']; 
  }
  //get the login info and redirect the page
  require "include/dbConnection.php";

  //HTML for waiting icon




  $con = createConnection();
  $total = 1000;
  for($i=1;$i<=30;$i++){
    $questionInfo = getQuestion($con, $i);
    $score = $questionInfo[3];
    //echo "score: $score<br>";
    $total = $total +  $_POST["$i"] * $score;
    //echo "total: $total<br>"; 
  }

  //echo "$total";
  setScore($con, $friend, $total);
  changeQuestionStatus($con, $friend);
  header('Location: evaluate.php');
  //closeConnection($con);

?>