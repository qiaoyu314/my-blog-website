<?php
	//load all favoriate locations for a user
	require "../include/dbConnection.php";
	header('Content-Type:application/json');
	$result = array();
	$location_id;
	//echo $_POST["location"];
	
	if(empty($_POST['username'])){
		$result["status"] = -1;
		$result["error"] = "No user ID.";
	}else if(empty($_POST['location'])){
		$result["status"] = -1;
		$result["error"] = "No location info.";
	}else{
		$location = json_decode(stripslashes($_POST["location"]), true);
		$location_id = addFavoriateLocation($_POST['username'], $location);
		$result["status"] = 1;
		$result["location_id"] = $location_id;
	}

	echo json_encode($result);
	
?>