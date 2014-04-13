<?php
/**
load all favoriate locations for a user
**/
require "../include/dbConnection.php";
header('Content-Type:application/json');
if(!empty($_POST['username'])){
	$username = $_POST['username'];
	$locations = loadALlLocations($username);
	echo json_encode($locations);

}else{
	echo "{}";
}

?>