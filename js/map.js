var SF = new google.maps.LatLng(37.7833, 122.4167);
var geocoder;
var map;
var marker;
var infoWindow;
var latLng;
var address;
var favoriteName;
var favoriteLocations;
var favoriteLocationId;
var defaultZoom = 13;

$(document).ready(function(){

	//load all favorite locations
	loadFavoriateLocations();

	//initialize the map
	initialize();

	//adjust the table
	$("div#favoriate-locations").height($("div#map-canvas").height() * 0.8);

	//click event for search button
	$input = $("input#address");
	$("button#search").click(function(){
		var address = $input.val();
		//check if it's a favoriate name
		if(isFavoriteName(address)){
			placeMarker(true);
		}else{
			searchAddress(address);
		}
	});
});

//initialize the map
function initialize() {
	var mapOptions = {
	  zoom: defaultZoom
	};
	geocoder = new google.maps.Geocoder();
	map = new google.maps.Map(document.getElementById("map-canvas"),
	    mapOptions);
	// Try W3C Geolocation
	if(navigator.geolocation) {
	    browserSupportFlag = true;
	    navigator.geolocation.getCurrentPosition(function(position) {
	      latLng = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
	      placeMarker(favoriteExists(latLng.lat(),latLng.lng()));
	    }, function() {
	      handleNoGeolocation(browserSupportFlag);
	    });
	}
	// Browser doesn't support Geolocation
	else {
	    browserSupportFlag = false;
		handleNoGeolocation(browserSupportFlag);
	}
	//handle the failure loading locaiton
	function handleNoGeolocation(errorFlag) {
	    if (errorFlag == true) {
	      alert("Geolocation service failed.");
	    } else {
	      alert("Your browser doesn't support geolocation.");
	    }
	    map.setCenter(SF);
	}

	//bind click event
	google.maps.event.addListener(map, 'click', function(event) {
		latLng = event.latLng;
  		placeMarker(favoriteExists(latLng.lat(), latLng.lng()));
  	});
}
//generate HTML code for info windows
function generateInfoContent(savedLocation){
	var htmlCode = "<div id='infoWindow-input'" +
					"<p>" + address + "</p>";
	if(savedLocation){
		htmlCode = htmlCode + 
					"<div class='input-group'>" +
					"<input type='text' class='form-control' id='name' placeholder='" + favoriteName + "'>" +
					"<span class='input-group-btn'>" +
					"<button class='btn btn-warning' id='update' type='button' onclick='updateLocationName()'>Rename</button>" +
					"</span>" +
					"<span class='input-group-btn'>" +
					"<button class='btn btn-danger' id='delete' type='button' onclick='deleteFavoriteLocation()'>Delete</button>" +
					"</span>" +
					"</div>" +
					"</div>";
	}else{
		htmlCode = htmlCode +
					"<div class='input-group'>" +
					"<input type='text' class='form-control' id='name' placeholder='name this place'>" +
					"<span class='input-group-btn'>" +
					"<button class='btn btn-success' id='save' type='button' onclick='addLocation()'>Save as my favoriate</button>" +
					"</span>" +
					"</div>" +
					"</div>";
	}

	return htmlCode;
}
//geocode and place the marker
function searchAddress(address) {
	var returnVal;
	geocoder.geocode( { 'address': address, 'bounds': map.getBounds()}, function(results, status) {
  		if (status == google.maps.GeocoderStatus.OK) {
  			latLng = results[0].geometry.location;
  			placeMarker(favoriteExists(latLng.lat(), latLng.lng()));
  		} else {
    		alert("Geocode was not successful for the following reason: " + status);
  		}
	});
	return returnVal;
}
//create a new info windown based on the location of the marker
//and show the window
function createInfoWindow(savedLocation){
	if(savedLocation){
		infowindow = new google.maps.InfoWindow({
			content: generateInfoContent(true),
			maxWidth: 300
		});
		infowindow.open(map,marker);
	}else{
		latLng = marker.getPosition();
		geocoder.geocode( { 'latLng': latLng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				address = results[0].formatted_address; 
		  		if(typeof infowindow != "undefined"){
		        	infowindow.close();
		        }
				infowindow = new google.maps.InfoWindow({
					content: generateInfoContent(false),
					maxWidth: 300
				});
				infowindow.open(map,marker);
			}
		});
	}
}

//place a marker
//info window will be built depends on savedLocation
function placeMarker(savedLocation){
	map.setCenter(latLng);
	if(typeof marker != "undefined"){
			marker.setMap(null);
	}
	marker = new google.maps.Marker({
        map: map,
        draggable:true,
        animation: google.maps.Animation.DROP,
        position: latLng
	});
	if(map.getZoom()<defaultZoom){
		map.setZoom(defaultZoom);
	}
	createInfoWindow(savedLocation);
	google.maps.event.addListener(marker, 'click', function(){
		latLng = marker.getPosition();
		createInfoWindow(favoriteExists(latLng.lat(),latLng.lng()))});	
    google.maps.event.addListener(marker,'dragstart',function(){infowindow.close()});
    google.maps.event.addListener(marker,'dragend',function(){
    	latLng = marker.getPosition();
    	placeMarker(favoriteExists(latLng.lat(),latLng.lng()));
    });
}

//load all favoriate locations
function loadFavoriateLocations(){
	$.ajax({
		type: "GET",
		url: "api/loadLocations.php",
		data: {username: username},
		dataType: "json"
	}).
	done(function(locations){
		favoriteLocations = locations;
		loadLocationsInTable(locations);
	}).
	fail(function(jqXHR, textStatus, errorThrown){
		alert(textStatus);
		alert(errorThrown);
	});
}
//load all favorite locations into the table
function loadLocationsInTable(locations){
	var htmlCode = "<tr><th>Name</th><th>Address</th></tr>";
	var i = 0;
	$.each(locations, function(key, location){
		//alert(location.location_id);
		htmlCode = htmlCode + "<tr class='active' onclick='placeMarderForLocation(" + i + ")'><td>" + location.name + "</td><td>" + 
					location.address + "</td></tr>";
		i++;
	});
	$("table#favoriate-locations").html(htmlCode);
}

//place a marker baesd on favoriteLocations[index]
//used as click event for table row
function placeMarderForLocation(index){
	latLng = new google.maps.LatLng(favoriteLocations[index].latitude,favoriteLocations[index].longitude);
	address = favoriteLocations[index].address;
	favoriteName = favoriteLocations[index].name;
	favoriteLocationId = favoriteLocations[index].location_id;
	placeMarker(true);
}

//save a favoriate location
function addLocation(){
	favoriteName = $("input#name").val().trim();
	if(!favoriteName){
		alert("Please enter a name.");
		return;
	}
	var location = {
		"latitude":latLng.lat(),
		"longitude":latLng.lng(),
		"address": address,
		"name":favoriteName
	};
	$.ajax({
		type:"POST",
		url:"api/addLocation.php",
		data: {username:username,location: JSON.stringify(location)},
		dataType: "json"
	}).done(function(result){
		if(result.status==-1){
			alert(result.error);		
		}
		else{
			//load new location to the table
			loadFavoriateLocations();
			//change the infor window
			favoriteLocationId = result["location_id"];
			placeMarker(true);
		}
	}).fail(function(jqXHR, textStatus, errorThrown){
		alert(textStatus + ", " + errorThrown);
	});
}

//udpate the name
function updateLocationName(){
	var newName = $("input#name").val().trim();
	if(!newName){
		alert("Please enter a name.");
		return;
	}
	if(newName == favoriteName){
		alert("Name is not changed.");
		return;
	}
	$.ajax({
		type:"PUT",
		url:"api/updateLocationName.php",
		data: {username: username, location_id: favoriteLocationId, name: newName},
		dataType: "json"
	}).done(function(result){
	if(result.status==-1){
		alert(result.error);		
	}
	else{
		favoriteName = newName;
		//load new location to the table
		loadFavoriateLocations();
		//change the infor window
		placeMarker(true);
	}
	}).fail(function(jqXHR, textStatus, errorThrown){
	alert(textStatus + ", " + errorThrown);
	});
	
}

//delete a favorite location
function deleteFavoriteLocation(){
	$.ajax({
		type:"DELETE",
		url:"api/deleteFavoriteLocation.php",
		data: {username: username, location_id: favoriteLocationId},
		dataType: "json"
	}).done(function(result){
	if(result.status==-1){
		alert(result.error);		
	}
	else{
		//reload the favorite location table
		loadFavoriateLocations();
		//remove the marker
		marker.setMap(null);
	}
	}).fail(function(jqXHR, textStatus, errorThrown){
	alert(textStatus + ", " + errorThrown);
	});
}

//given lat and lng info, check if it's already in the the favorite list
function favoriteExists(latitude, longitude){
	var e = 0.001;
	var i = 0;
	var found = false;
	$.each(favoriteLocations, function(key, location){
		if(Math.abs(location.latitude) - latitude < e && Math.abs(location.longitude - longitude)<e){
			//alert("found one");
			latLng = new google.maps.LatLng(location.latitude,location.longitude);
			favoriteName = location.name;
			address = location.address;
			favoriteLocationId = i;
			found = true;
			return;
		}
		i++;
	});
	return found;
}

//
function isFavoriteName(inputName){
	var i = 0;
	var found = false;
	$.each(favoriteLocations, function(key, location){
		if(location.name.toLowerCase() == inputName.toLowerCase()){
			//alert("found one");
			latLng = new google.maps.LatLng(location.latitude,location.longitude);
			favoriteName = location.name;
			address = location.address;
			favoriteLocationId = i;
			found = true;
			return;
		}
		i++;
	});
	return found;
}