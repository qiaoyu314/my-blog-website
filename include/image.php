<?php

	//include "dbConnection.php";
/**
	Read the info of a image	
*/
function getImgInfo($fileName){
	$exif = exif_read_data($fileName, "EXIF", true);	
	if (@array_key_exists('EXIF', $exif)) 
	{
		return $exif['EXIF']['DateTimeOriginal'];		
	}
	return NUll;
}

/**
	load images from "img/test"
*/
function loadImage($path, $index){

//	$directory = "img/test/";
	$count = 0;
	$max = 30;
	//load 10 images each time
	//tranverse all files
	if ($handle = opendir($path)) {
		$con = createConnection();
	    while (false !== ($file = readdir($handle))) {
	    	$file = strtolower($file);
	        if ($file != "." && $file != ".." && ((strpos($file,".jpg")||strpos($file,".png")) !== false) && $count<$max) {            
	           // echo "$file\n";
	            $currentFile = $path.$file;
	            //retrieve comments from db
	            $comments = getComments($con,$currentFile);
	            $commentsHtml = "<table class='table'>";
	            for($i=0;$i<count($comments);$i++){
	            	$commentsHtml .= "<tr><td>".$comments[$i]."</td></tr>";
	            }
	            $commentsHtml .= "</table>";
	            
	            echo "<div class='item'><img src='$currentFile' class='img-responsive'>$commentsHtml</div>";
	            $count++;
	        }
	    }
	    //closeConnection($con);
    	closedir($handle);
	}	
}

/**
load images paths into javascript array
**/
function loadImagesIntoJS($path){
	$count = 0;
	$max = 30;
	echo "<script>";
	echo "var images = new Array();";
	//load 10 images each time
	//tranverse all files
	if ($handle = opendir($path)) {
		$con = createConnection();
	    while (false !== ($file = readdir($handle))) {
	    	$file = strtolower($file);
	        if ($file != "." && $file != ".." && ((strpos($file,".jpg")||strpos($file,".png")) !== false) && $count<$max) {            
	           // echo "$file\n";
	            $currentFile = $path.$file;
	           
	            echo "images[$count] = new Image();";
	            echo "images[$count].src = \"$currentFile\";";
	            echo "string";
	            $count++;
	        }
	    }
	    //closeConnection($con);
    	closedir($handle);
	}	
	echo "</script>";
}


?>