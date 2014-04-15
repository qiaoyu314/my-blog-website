<?php
/**
Update the name of a favorite location
**/
require "../include/dbConnection.php";
header('Content-Type:application/json');

$result = array();
$_PUT  = array();  
if($_SERVER['REQUEST_METHOD'] == 'PUT') {  
    parse_str(file_get_contents('php://input'), $_PUT);  
    if(empty($_PUT['username'])){
    	header($_SERVER["SERVER_PROTOCOL"]." 406 No user ID.");
		$result["status"] = -1;
		$result["error"] = "No user ID.";
	}else if(empty($_PUT['location_id'])){
		header($_SERVER["SERVER_PROTOCOL"]." 406 No location info.");
		$result["status"] = -1;
		$result["error"] = "No location info.";
	}else if(empty($_PUT['name'])){
		header($_SERVER["SERVER_PROTOCOL"]." 406 No name info.");
		$result["status"] = -1;
		$result["error"] = "No name info.";
	}else{
		if(updateLocationName($_PUT['username'], $_PUT['location_id'],$_PUT['name'])){
			$result["status"] = 1;
		}else{
			header($_SERVER["SERVER_PROTOCOL"]." 404 Query fails.");
			$result["status"] = -1;
			$result["error"] = "Query fails.";
		}
	}
}else{
	header($_SERVER["SERVER_PROTOCOL"]." 406 Invalid request method.");
	$result["status"] = -1;
	$result["error"] = "Invalid request method.";
}


echo json_encode($result);


?>