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
		$result["status"] = -1;
		$result["error"] = "No user ID.";
	}else if(empty($_DELETE['location_id'])){
		$result["status"] = -1;
		$result["error"] = "No location info.";
	}else{
		if(deleteFavoriteLocation($_DELETE['username'], $_DELETE['location_id'], $_DELETE['name'])){
			$result["status"] = 1;
		}else{
			$result["status"] = -1;
			$result["error"] = "Query fails.";
		}
	}
}else{
	$result["status"] = -1;
	$result["error"] = "Invalid request method.";
}

echo json_encode($result);


?>