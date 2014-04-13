var $container = $('#img_container');
		// initialize Masonry after all images have loaded  

$container.waitForImages(function(){
	$(".item img").show();
	$container.masonry({
    itemSelector : '.item',
    isAnimated: true
  });

});
	
$("#load_More").click(function(){
  	//display the next * images
  		//display the loading icon
  		$("button#load_More").fadeOut();
  		$("img#load_More").fadeIn();
  		$.ajax({
  			type: "POST",
  			url: "include/loadImage.php",
  			data: {index: count, path: "img/test/"}
  		}).done(function(result){
  			$("button#load_More").fadeIn();
	  		$("img#load_More").fadeOut();
  			if(result){
	  			count++;
	  			$container.append(result).waitForImages(function(){
					$(".item img").show();
					$container.masonry('reload');
				});
  			}else{
  				alert("No more images.");
  			}
  			
  		});
  });
  //click the image will lead to the php
  $("#img_container").on( "click", "img", function() {
  	$path = $(this).attr("src");
  	document.location.href="imageDetail.php?path=" + $path;
  });


//scroll down detection
  var threshold = 1;
  var count = 1;
  
  /*
  $(window).scroll(function() {
  	if($(window).scrollTop() + $(window).height() > $(document).height() - threshold) {
  		//display the next * images
  		$.ajax({
  			type: "POST",
  			url: "include/loadImage.php",
  			data: {index: count, path: "img/test/"}
  		}).done(function(result){
  			$container.append(result).masonry('reload');
  		});
  	}
  });
  */
  

