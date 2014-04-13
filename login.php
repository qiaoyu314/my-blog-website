<?php
session_start();
  //get the login info and redirect the page
  require "include/dbConnection.php";


  $username = $_POST["username"];
  $password = $_POST["password"];

  $con = createConnection();

  if(isLoginCorrect($con, $username, $password)){
    $_SESSION['login'] = $username;
    if(isset($_SESSION['prev_page'])){
      header('Location: ' . $_SESSION['prev_page']);
    }else{
        header('Location: blog.php' ) ;
    }
  }else{
    //echo "Login failed!";
    header('Location: user_login.php');
  }

  //closeConnection($con);

?>