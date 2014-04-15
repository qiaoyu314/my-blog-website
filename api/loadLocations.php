<?php
/**
load all favoriate locations for a user
**/
require "../include/dbConnection.php";
header('Content-Type:application/json');
if(!empty($_GET['username'])){
	$username = $_GET['username'];
	$locations = loadALlLocations($username);
	echo json_encode($locations);
}else{
	echo "{}";
}

?>