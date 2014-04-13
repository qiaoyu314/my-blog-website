<?php
session_start();
$path =  $_GET["path"];
if(!(isset($_SESSION['login']))){
	$_SESSION['prev_page'] = "imageDetail.php?path=" . $path;
	header("Location: user_login.php");
}else{
	$currentUser = $_SESSION['login'];
}


include 'template/navi.php';
include 'include/image.php';
require "include/dbConnection.php"
?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'template/head.php' ?>
	<style type="text/css">
	#img
	{
		width: 60%;
		display: inline;
		float: left;
		margin: 2%;
	}
	#comments
	{
		width: 30%;
		display: inline;
		float: left;
		margin: 2%;
	}
	#old
	{
		
		overflow:auto;
	}
	#add
	{
		margin-top: 2%;
	}
	td{
		width: 100%;
	}
	</style>
</head>
<body>
	<?php
		set_navi(3); 
	?>
	<div class="container" id="large-image">
		
		<div id="img">
				<?php echo "<img src=$path class='img-responsive'>"; ?>
		</div>
		<div id="comments">
			<h3><span class="label label-success">Comments</span></h3>
			<div id="old">
				<table class="table">
				<?php 
					//load comments
					$con = createConnection();
					$comments = getComments($con, $path);
					closeConnection($con);
					//loop comments
					$count = count($comments);
					for($i=0;$i<$count;$i++){
						$comment = $comments[$i];
						echo "<tr class='info'><td>$comment<td></tr>";
					}
					
				?>
				</table>
			</div>
			<div id="new">
				<div id="dialog"><textarea class="form-control" id="text_box" rows="3" placeholder="Add new comment here"></textarea></div>
				<button type="button" class="btn btn-primary" id="add">Add</button>
			</div>
		</div>
	</div>
	<script type="text/javascript">
	//use ajax to add new coments		
		$("#add").click(function(){
			//check if text box if empty
			if(!$("#text_box").val()){
				return;
			}
			path_data = $("img").attr("src");
			content_data = $("#text_box").val();
			$.ajax({
				type: "POST",
  				url: "include/addComment.php",
  				data: {path: path_data, content: content_data}
  			}).done(function(result){
  				if(result=="1"){
  					//if the comment is added successfully, append it to #old
  					html = "<tr class='info'><td>"+content_data+"</td></tr>";
  					$("table").append(html);
  					//clear the input area
  					$("#text_box").val("");	
  				}else{
  					alert("Error: add comment");
  				}
  							
  				
			});
		});
	//set height afer everything is loaded
	$(window).load(function() {
      	var height = $(window).height();
		$("#large-image").height(height);
	});

	
	</script>

</body>
</html>