<?php
	function set_navi($index){


		//header
		echo '<div class="container">';
		echo '<a href="index.php"><h1 class="title">Yu Qiao\'s Blog</h1></a>';
		echo '</div>';


		//navigation bar
		global $currentUser;
		
		echo '<div class="navbar navbar-inverse">';
		echo '<div class="container">';
		echo '<ui class="nav nav-pills">';

		//add all menus into an array
		$menus = array(
			'<a href="blog.php">Blog</a></li>',
			'<a href="project.php">Project</a></li>',
			'<a href="gallery.php">Gallery</a></li>',
			'<a href="evaluate.php">Evaluate</a></li>',
			'<a href="score.php">View My Score</a></li>',
			'<a href="favoriateLocations.php">Favoriate Locations</a></li>'
		);
		$i = 1;
		foreach ($menus as $menu) {
			if($i==$index){
				$display = '<li class="active">' . $menu;
			}else{
				$display = '<li>' . $menu;
			}
			echo $display;
			$i++;
		}

		if(!empty($currentUser)){
			echo "<li id='logout'><a href='logout.php'>Logout: $currentUser</a></li>";
		}else{
			echo '<p class="navbar-text navbar-right"><a href="user_login.php" class="navbar-link">Sign In</a></p>';
		}
		echo '</ul>';
		echo '</div>';
		echo '</div>';
	}
?>