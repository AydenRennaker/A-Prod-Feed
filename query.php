<?php
	
	include "inc/request_generator.php";
	//include "settings/config.php";
	
	$params = array( "ItemPage" => "2" );
	
	$url = getXMLLink($params);
	
	echo $url;

?>