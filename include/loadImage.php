<?php

//this file is used for AJAX to load more images

require "dbConnection.php";

$index = $_POST['index'];
$path = "../" . $_POST['path'];

/**
	load images from "img/test"
*/

$count = 0;
$max = 30;
//load 10 images each time
//tranverse all files


if ($handle = opendir($path)) {
	$con = createConnection();
    while (false !== ($file = readdir($handle))) {
        if ($file != "." && $file != ".." && (strpos($file,".jpg") !== false)) {    
        	if($count<(($index+1) * $max) && $count > ($index * $max - 1)){
		    	$currentFile = $path.$file;
		        $comments = getComments($con,$currentFile);
		        $commentsHtml = "<table class='table'>";
		        for($i=0;$i<count($comments);$i++){
		        	$commentsHtml .= "<tr><td>".$comments[$i]."</td></tr>";
		        }
		        $commentsHtml .= "</table>";
		        echo "<div class='item'><img src='$currentFile' class='img-responsive'>$commentsHtml</div>";
        	} 
            $count++;
        }
    }
    //closeConnection($con);
	closedir($handle);
}

?>
