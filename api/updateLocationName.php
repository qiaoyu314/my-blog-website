<?php
/**
Update the name of a favorite location
**/
require "../include/dbConnection.php";
header('Content-Type:application/json');

$result = array();
if(empty($_POST['username'])){
	$result["status"] = -1;
	$result["error"] = "No user ID.";
}else if(empty($_POST['location_id'])){
	$result["status"] = -1;
	$result["error"] = "No location info.";
}else if(empty($_POST['name'])){
	$result["status"] = -1;
	$result["error"] = "No name info.";
}else{
	updateLocationName($_POST['username'], $_POST['location_id'],$_POST['name']);
	$result["status"] = 1;
}

echo json_encode($result);


?>