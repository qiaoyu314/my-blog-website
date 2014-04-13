<?php
/**
	Make connction with mysql database
*/
	$host = "qiaoyu314.db.12024604.hostedresource.com";
	$dbUsername = "qiaoyu314";
	$dbPassword = "Qy!123456";
	$dbname = "qiaoyu314";
	$con;

	function createConnection(){

		global $host, $dbUsername, $dbPassword, $dbname, $con;
		
		$con = mysql_connect($host, $dbUsername, $dbPassword) OR DIE ("Unable to connect to database! Please try again later.");
	    mysql_select_db($dbname);
	    mysql_set_charset( "utf8", $con);
	    return $con;

	    
	}	

	function closeConnection($con){
		// Check connection

		/*
		if (mysql_connect_errno($con))
		  {
		  echo "Failed to connect to MySQL: " . mysql_connect_error();
		  }
		*/
		if($con){
			mysql_close($con);
		}
		
	}

	function getComments($con, $path){
		$comments = array();
		$usertable = "comment";
	    //Fetching from your database table.
	    $query = "SELECT content FROM $usertable WHERE img_path='$path'";
	    $result = mysql_query($query, $con);
	    if ($result) {
	    	while($row = mysql_fetch_array($result)) {
	    		array_push($comments, $row[0]);

	    	}
	    }
	    return $comments;
	}

	function addComments($con, $path, $content){
		$usertable = "comment";
	    //insert new comment 
	    $content = mysql_real_escape_string($content);
	    $query = "INSERT INTO $usertable (img_path, content) VALUES ('$path','$content')";
	    if(mysql_query($query, $con)){
	    	return 1;
	    }else{
	    	return -1;
	    }
	    
	}

	function isLoginCorrect($username, $password){
		global $con;
		if(!$con){
			$con = createConnection();
		}
		$usertable = "user";
		$query = "SELECT * FROM $usertable WHERE username='$username' AND password='$password'";
		$result = mysql_query($query, $con);
		if($result){
			if(mysql_num_rows($result)>0){
				return TRUE;
			}
		}
		return FALSE;
	}

	function signUp($username, $password){
		global $con;
		if(!$con){
			$con = createConnection();
		}
		$query = "INSERT INTO user (username, password)
				VALUES ('$username', 'password')";
		return mysql_query($query, $con);
	}

	/**
	Load all unanswered questions for a user
	**/
	function getUnansweredQuestions($con, $username){
		$question = array();
		$questionID = array();
		$answerType = array();
		$questionArray = array();

		$unansweredTable = "user_unanswered_questions";
		$questionTable = "question";

		//if questions have not been answered for a user, pull all questions.
		//else 
		$query = "SELECT $questionTable.id, $questionTable.text, $questionTable.answer_type
				  FROM question, $unansweredTable
				  WHERE $unansweredTable.username='$username' AND $questionTable.id=$unansweredTable.question_id";
		$result = mysql_query($query, $con);
		if($result){
			while ($row = mysql_fetch_array($result)) {
				array_push($questionID, $row[0]);
				array_push($question, $row[1]);
				array_push($answerType, $row[3]);
			}
		}
		array_push($questionArray,$questionID);
		array_push($questionArray,$question);
		array_push($questionArray,$answerType);

		return $questionArray;
	}
	
	/**
	stores answers
	**/
	function storeAnswers($username, $questionsWithAnswers){

	}

	/**
	calculate score for a user
	**/
	function calculateStore($username){

	}

	/**
	0: user has not answered the questions
	1: user has answerted the questions
	-1: not result 
	**/
	function isAnswered($con, $username){
		$userTable = "user";
		$query = "SELECT $userTable.answered FROM $userTable WHERE username='$username'";
		$result = mysql_query($query, $con);
		if($result){
			$row = mysql_fetch_array($result);
			return $row[0];
		}else{
			return -1;
		}
	}
	/**
	get the score for a user
	**/
	function getScore($con, $username){
		$userScoreTable = "user_score";
		$query = "SELECT $userScoreTable.score FROM $userScoreTable WHERE username='$username'";
		$result = mysql_query($query, $con);
		if($result){
			$row = mysql_fetch_array($result);
			return $row[0];
		}else{
			return -1;
		}
	}
	/**
	
	**/
	function changeQuestionStatus($con, $username){
		$userTable = "user";
		$query = "UPDATE $userTable SET answered=1 WHERE username='$username'";
		$result = mysql_query($query, $con);
	}

	/**
	get the score of a user
	**/
	function setScore($con, $username, $score){
		$userScoreTable = "user_score";
		$query = "UPDATE $userScoreTable SET score=$score WHERE username='$username'";
		$result = mysql_query($query, $con);
	}

	/**
	get a quetion 
	**/
	function getQuestion($con, $questionId){
		$questionTable = "question";
		$query = "SELECT * FROM $questionTable WHERE id='$questionId'";
		$result = mysql_query($query, $con);
		if($result){
			$row = mysql_fetch_array($result);
			return $row;
		}else{
			echo "Error: not able to find question record";
		}

	}
	//generate HTML for process bar based on score
	function getHTMLProcessBar($score){
		$total = 4500;
		$poor = 1500;
		$normal = 2500;
		$good = 3500;
		$poorPercent = $poor / $total * 100;
		$normalPercent = ($normal - $poor) / $total * 100;
		$goodPercent =  ($good - $normal) / $total * 100;
		echo '<div class="progress">';
		if($score<$poor){
			$perent = $score / $total * 100;
			echo "<div class='progress-bar progress-bar-danger' style='width:$perent%'></div>";
		}else if($score<$normal){
			$precent = ($score - $poor) / $total * 100; 
			echo "<div class='progress-bar progress-bar-danger' style='width:$poorPercent%'></div>";
			echo "<div class='progress-bar progress-bar-warning' style='width:$precent%'></div>"; 
		}else if($score<$good){
			$precent = ($score - $normal) / $total * 100; 
			echo "<div class='progress-bar progress-bar-danger' style='width:$poorPercent%'></div>";
			echo "<div class='progress-bar progress-bar-warning' style='width:$normalPercent%'></div>"; 
			echo "<div class='progress-bar progress-bar-info' style='width:$precent%'></div>";
		}else{
			$precent = ($score - $good) / $total * 100; 
			echo "<div class='progress-bar progress-bar-danger' style='width:$poorPercent%'></div>";
			echo "<div class='progress-bar progress-bar-warning' style='width:$normalPercent%'></div>"; 
			echo "<div class='progress-bar progress-bar-info' style='width:$goodPercent%'></div>";
			echo "<div class='progress-bar progress-bar-success' style='width:$precent%'></div>";
		}
		echo '</div>';
	}


	function getFriend($con, $username){
		$userTable = "user";
		$query = "SELECT friend FROM $userTable WHERE username='$username'";
		$result = mysql_query($query, $con);
		if($result){
			$row = mysql_fetch_array($result);
			return $row[0];
		}else{
			return -1;
		}

	}

	/**
	generate HTML form questons
	**/
	function getHTMLQuestions($con, $username){
		//get all questions 
		$questionTable = "question";
		$query = "SELECT * FROM $questionTable";
		$result = mysql_query($query, $con);
		if($result){
			echo '<form role="form" action="calculateScore.php" method="POST">';
			echo '<table class="h_center">';
			while($row = mysql_fetch_array($result)) {
				echo '<tr>';
				echo '<td class="question">';
				//qeuston
				echo "<h3>$row[1]</h3>";
				echo '</td>';
				echo '<td class="answer">';
				//answer
				if($row[2] == 1){
					//radio button

					echo '<div class="radio">';
					echo "<input type='radio' name='$row[0]' value='1' checked>是";
					echo '</div>';
					echo '<div class="radio">';
					echo "<input type='radio' name='$row[0]' value='0' checked>否";
					echo '</div>';
				}else{
					echo "<input type='text' class='form-control' name='$row[0]' placeholder='请输入数字''>";
				}
				echo '</td>';
				echo '</tr>';
	    	}
	    	echo '<tr><td><button type="submit" class="btn btn-primary">Submit</button></td></tr>';
	    	echo '</table>';

			echo '</form>';	
		}else{
			echo '<h3>Error: not able to get question record.</h3>';
		}
		
	}

	//generate HTML for adding a friend
	function getHTMLAddFriend(){

	}
	/**
	return HTML code of a list of blog preview
	**/
	function getNextBlogs($page){
		$con = createConnection();
		$blogTable = "blog";
		$imgTable = "image";
		$num = 10;
		$startIndex = ($page - 1) * $num;		//retrive 10 blogs in each page
		$query = "SELECT $blogTable.title, $blogTable.preview, $imgTable.path, $blogTable.creation_time 
				FROM $blogTable, $imgTable 
				WHERE $blogTable.img_id = $imgTable.id  
				LIMIT $startIndex,$num";
		$result = mysql_query($query, $con);
		if($result){
			while ($row = mysql_fetch_array($result)) {
				echo '<div class="media blog-preview">';
				echo '<a class="pull-left"> <img class="media-object blog-preview" src="' . 'img/blog_preview/' . $row[2] . '" alt="Not available"></a>';
				echo '<div class="media-body">';
				echo '<h2>' . $row[0] . '</h2>';	//title
				echo '<h3.' . $row[3] . '</h3.';	//creation time
				echo '<p>' . $row[1] . '</p>'; 		//preview
				echo '<p><a class="btn btn-primary btn" role="button" href="index.php">Read more</a></p>';	//read more button
				echo '</div>';
				echo '</div>';
			}
		}
	}
/******************************************************************************************

The following fucntions are used for Uber project

******************************************************************************************/
	/**
	get all locations for a user
	return in json
	**/
	function loadALlLocations($username){
		$con = createConnection();
		$locationTable = "location";
		$favoriateLocationTable = "favorite_location";
		$query = "SELECT $favoriateLocationTable.name AS name, $locationTable.latitude AS latitude, 
				$locationTable.longitude AS longitude, $locationTable.address AS address,$locationTable.id AS location_id
				FROM $locationTable,$favoriateLocationTable
				WHERE $favoriateLocationTable.username = '$username' AND $locationTable.id = $favoriateLocationTable.location_id
				ORDER BY address";
		$result = mysql_query($query, $con);
		$jsonArray = array();
		if($result){
			while ($row = mysql_fetch_array($result)) {
				$jsonArray[] = $row;
			}

		}else{
			die('load favorite Invalid query: ' . mysql_error());
		}
		//$json = json_encode($jsonArray);
		return $jsonArray;
	}
	/**
	add a new faviorate location for a user
	if it already is, update the name
	**/
	function addFavoriateLocation($username, $location){
		global $con;
		$name = $location["name"];
		//check if the location exists
		$location_id = locationExists($location);
		if($location_id){
			//echo "location exists\n";
			//check if it already the favorite
			$favorite_location = favoriteExists($username, $location_id);
			if($favorite_location){
				//echo "favorite exists\n";
				//update the name
				updateLocationName($username, $location_id, $name);	
			}else{
				//add a new row in favoriate_location table
				$query = "INSERT INTO favorite_location
						VALUES('$username', $location_id, '$name')";
				$result = mysql_query($query,$con);	
			}
		}else{
			//insert a new location 
			$lat = $location["latitude"];
			$lng = $location["longitude"];
			$address = mysql_real_escape_string($location["address"]);
			$query = "INSERT INTO location (latitude, longitude, address)
					VALUES ($lat, $lng, '$address')";
			$result=mysql_query($query,$con);
			if (!$result) {
    			die('insert location Invalid query: ' . mysql_error());
    			return;
			}
			//connect the user with this location
			$location_id = mysql_insert_id($con);
			//echo "$location_id";
			$query = "INSERT INTO favorite_location
					VALUES('$username', $location_id, '$name')";
			$result=mysql_query($query,$con);
		}
		return $location_id;
	}

	function locationExists($location){
		global $con;
		$lat = $location["latitude"];
		$lng = $location["longitude"];
		$e = 0.01;
		if(!$con){
			$con = createConnection();
		}
		$query  = "SELECT id 
				FROM location
				WHERE ABS(latitude - $lat)<$e AND ABS(longitude - $lng)<$e
				LIMIT 1";
		$result = mysql_query($query, $con);
		if($result){
			if($row =  mysql_fetch_array($result)){
				return $row[0];
			}	
		}
		return null;
	}

	function favoriteExists($username, $location_id){
		global $con;
		if(!$con){
			$con = createConnection();
		}
		$query = "SELECT * 
				FROM favorite_location
				WHERE username = '$username' AND location_id = $location_id";
		mysql_query($query, $con);
		$result = mysql_query($query, $con);
		if($result){
			if($row =  mysql_fetch_array($result))
				return true;
		}
		return false;
	}

	function updateLocationName($username, $location_id, $name){
		global $con;
		if(!$con){
			$con = createConnection();
		}
		$query = "UPDATE favorite_location
				SET name='$name'
				WHERE username='$username' AND location_id=$location_id";
		mysql_query($query,$con);
	}

	function deleteFavoriteLocation($username, $location_id){
		global $con;
		if(!$con){
			$con = createConnection();
		}
		$query = "DELETE FROM favorite_location
				WHERE username='$username' AND location_id=$location_id";
		mysql_query($query,$con);
	}

?>