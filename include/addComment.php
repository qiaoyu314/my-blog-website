<?php
	require "dbConnection.php";

	$path =  $_POST["path"];
	$content = $_POST["content"];


	//add comments to the database
	$con = createConnection();
	echo addComments($con, $path, $content);
	//closeConnection($con);
?>