<?php

	header('Content-Type: text/html; Charset=UTF-8');
	$parameters = array();
	foreach ($_GET as $key=>$val) { 
    		$parameters[strtolower($key)] = strtolower($val); 
	}  		
	foreach ($_POST as $key=>$val) { 
    		$parameters[strtolower($key)] = strtolower($val); 
	}  	
	
	$entity=$parameters["entity"];
	$site=$parameters["site"];
	$file = file_get_contents ("vr.est");
	$file = str_replace("<<entity>>",$entity,$file);
	$file = str_replace("<<surface>>","data/".$entity."_".$site."_surface.jpg",$file);
	$file = str_replace("<<terrain>>","data/".$entity."_".$site."_terrain.jpg",$file);

	print $file;

?>
