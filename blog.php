<?php
session_start();
if(isset($_SESSION['login'])){
	$currentUser = $_SESSION['login'];
}


include 'template/navi.php';
require "include/dbConnection.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'template/head.php' ?>
</head>
<body>
	<?php 
		set_navi(1);
	?>
	<div class="container">
	
	<div class="row">
	  	<div class="col-xs-12 col-md-8" id="blog_list"> <!--all blogs in card view-->

	  		<?php
	  			getNextBlogs(1);
	  		?>
	  	</div>
	  	<div class="col-xs-6 col-md-4" id="blog_topic"> <!-- -->
	  		<h2>Topics</h2>
	  		<ul class="list-group">
			  <li class="list-group-item">
			    <span class="badge">15</span>
			    <a href="">Programming</a>
			  </li>
			  <li class="list-group-item">
			    <span class="badge">2</span>
			    Music
			  </li>
			  <li class="list-group-item">
			    <span class="badge">6</span>
			    Dancing
			  </li>
			  <li class="list-group-item">
			    <span class="badge">2</span>
			    XXX
			  </li>
			</ul>
	  	</div>
	</div>
	</div>
	<script type="text/javascript">

	//reszie the blog-preview image
	$(window).load(function() {
		$("img.blog-preview").hide();
      	var height = $(".media.blog-preview").height();
		$("img.blog-preview").height(height);
		$("img.blog-preview").show();
	});

		
	</script>

</body>
</html>