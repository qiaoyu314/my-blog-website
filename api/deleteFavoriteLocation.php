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
		http_response_code(406);
		$result["status"] = -1;
		$result["error"] = "No user ID.";
	}else if(empty($_DELETE['location_id'])){
		http_response_code(406);
		$result["status"] = -1;
		$result["error"] = "No location info.";
	}else{
		if(deleteFavoriteLocation($_DELETE['username'], $_DELETE['location_id'], $_DELETE['name'])){
			$result["status"] = 1;
		}else{
			http_response_code(404);
			$result["status"] = -1;
			$result["error"] = "Query fails.";
		}
	}
}else{
	http_response_code(406);
	$result["status"] = -1;
	$result["error"] = "Invalid request method.";
}

echo json_encode($result);


?>