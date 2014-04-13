<?php
session_start();
if(!(isset($_SESSION['login']))){
	$_SESSION["prev_page"] = "favoriateLocations.php";
	header("Location: user_login.php");
}else{
	$currentUser = $_SESSION['login'];
}

include 'template/navi.php';
require "include/dbConnection.php";

?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'template/head.php' ?>
	<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB_41MxdyVr20kTufyebBAvI01fci-709Y&sensor=true">
    </script>
    <script type="text/javascript">var username = '<?php echo $_SESSION["login"]; ?>'</script>
    <script type="text/javascript" src="js/map.js"></script>
    <style type="text/css">
    	html { height: 100% }
  		body { height: 100%;}
  		.full-hight{height: 100%}  
  		#favoriate-locations{
  			margin-top: 5%;
  		}
    </style>
</head>
<body>
	<?php 
		set_navi(6);
	?>
	
	<div class="container full-hight">
	<div class="row full-hight">
	  	<div class="col-xs-12 col-md-8 full-hight"> <!--map view-->
	  		<div class="full-hight" id="map-canvas"></div>
	  	</div>
	  	<div class="col-xs-6 col-md-4" id="blog_topic"> <!--location list-->
	  		<div class="input-group">
		      	<input type="text" class="form-control" id="address" placeholder="Enter address to search...">
		      	<span class="input-group-btn">
		        <button class="btn btn-primary" id="search" type="button">Search</button>
		      	</span>
		    </div>
		    <div><!--list of favoriate locations-->
		    	<h3><span class="label label-success">Favorite Locations</span></h3>
		    	<div id="favoriate-locations" class="scrollable">
		    	<table class="table table-hover table-striped" id="favoriate-locations">
		    	</table>
		    	</div>
		    </div>

	  	</div>
	</div>
	</div>
</body>
</html>