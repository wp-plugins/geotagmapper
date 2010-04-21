<?php
	# used to bypass Same Origin Policy
	# -> Cross Domain Ajax 
	# $_POST data
	# geotagmapper_country
	# geotagmapper_state
	# geotagmapper_city
	# geotagmapper_street
	# geotagmapper_zip
	$geotagmapper_street=urlencode($_POST["geotagmapper_street"]);
	$geotagmapper_city=urlencode($_POST["geotagmapper_city"]);
	$geotagmapper_state=urlencode($_POST["geotagmapper_state"]);
	$geotagmapper_city=urlencode($_POST["geotagmapper_city"]);
	$geotagmapper_country=urlencode($_POST["geotagmapper_country"]);
	$address=$geotagmapper_street.",+".$geotagmapper_city.",+".$geotagmapper_state.",+".$geotagmapper_country;
	header('Content-type: text/xml; charset="utf-8"',true);
	#print $address;exit();
	readfile('http://maps.google.com/maps/api/geocode/xml?address='.$address.'&sensor=false');
?>