<?php
/**
Delete a favorite location
**/
require "../include/dbConnection.php";
header('Content-Type:application/json');

$result = array();
$_DELETE  = array(); 

if($_SERVER['REQUEST_METHOD'] == 'DELETE') {  
    parse_str(file_get_contents('php://input'), $_DELETE);  
	if(empty($_DELETE['username'])){
		header($_SERVER["SERVER_PROTOCOL"]." 406 No user ID."); 
		$result["status"] = -1;
		$result["error"] = "No user ID.";
	}else if(empty($_DELETE['location_id'])){
		header($_SERVER["SERVER_PROTOCOL"]." 406 No location info.");
		$result["status"] = -1;
		$result["error"] = "No location info.";
	}else{
		if(deleteFavoriteLocation($_DELETE['username'], $_DELETE['location_id'], $_DELETE['name'])){
			$result["status"] = 1;
		}else{
			header($_SERVER["SERVER_PROTOCOL"]." 406 Query fails.");
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