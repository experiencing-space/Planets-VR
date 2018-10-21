<?php

	$parameters = array();
	foreach ($_GET as $key=>$val) { 
    		$parameters[strtolower($key)] = strtolower($val); 
	}  		
	foreach ($_POST as $key=>$val) { 
    		$parameters[strtolower($key)] = strtolower($val); 
	}  	
	
	$entity=$parameters["entity"];
	$type=$parameters["type"];
	$site=$parameters["site"];

	header('Content-Type: text/html; Charset=UTF-8');

	print "<html>";
	print "<head>";
        print "<title>NASA Space App Challenge 2018 - experiencing.space</title>";
	print '<link href="css/index.css" rel="stylesheet" type="text/css" media="all">';
	print "</head>";

	print '<body style="width: 100%;height: 100%;background-color: #000;color: #fff;margin: 0px;padding: 0;overflow: hidden;">';

	$string = file_get_contents("assets/planets.json");
	$planets = json_decode($string, true);
		
	print '<ul  class="menu-list">';

	if (!isset($type)) {
		foreach ($planets["planets"] as $planet) {
			renderButton("", "planet", $planet["name"],"");
		}
	}

	if ($type=="planet") {
		foreach ($planets["planets"] as $planet) {
			if ($planet["name"]==$entity) {
				if (sizeof($planet["moons"])>0) {
					foreach ($planet["moons"] as $moon) {
						renderButton($moon["name"], "moon", $moon["name"], "");
					}
				} 
				foreach ($planet["landingsites"] as $site) {
					$post="entity=".$entity."&site=".str_replace(" ","_",strtolower($site["name"]));
					renderButton($entity, "site", $site["name"], $post);
				}
			}
		}
	}

	if ($type=="moon") {
		foreach ($planets["planets"] as $planet) {
			foreach ($planet["moons"] as $moon) {
				if ($moon["name"]==$entity) {
					foreach ($moon["landingsites"] as $site) {
						$post="entity=".$entity."&site=".str_replace(" ","_",strtolower($site["name"]));
						renderButton($entity, "site", $site["name"], $post);
					}
				} 
			}
		}
	}


	print "</ul>";

	print "</body>";
	print "</html>";

	function renderButton($entity, $type, $label ,$post) {
		$src="";
		$dest="";
		if ($type=="planet" or $type=="moon") {
			$src="assets/".$label.".jpg";
			$dest="index.php?entity=".$label."&type=".$type;
		}
		if ($type=="site") {
			$src="assets/".$entity."_".str_replace(" ","_",strtolower($label)).".jpg";
			if (!file_exists($src)) {
				$src="assets/".$entity."_".str_replace(" ","_",strtolower($label)).".png";
			}
			$dest="vr.php?".$post;
		}
   		print '<li class="menu-item">';
        	print '<a href="'.$dest.'"><img src="'.$src.'" alt="icon" class="alignnone size-full" />';
     		print '<h3>'.ucwords($label).'</h3></a>';
  		print '</li>';
	}


?>
