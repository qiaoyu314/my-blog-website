<?php
/**
load all favoriate locations for a user
**/
require "../include/dbConnection.php";
header('Content-Type:application/json');
if(!empty($_GET['username'])){
	$username = $_GET['username'];
	$locations = loadALlLocations($username);
	if($locations){
		echo json_encode($locations);
	}else{
		echo "{}";
	}
}else{
	header($_SERVER["SERVER_PROTOCOL"]." 406 In user ID.");
}

?>