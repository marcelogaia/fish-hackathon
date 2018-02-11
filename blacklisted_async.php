<?php
	$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$fao = file_get_contents(str_replace("blacklisted_async.php", "fao.php", $actual_link));
	$fao = json_decode($fao);
	if(!is_null($fao)) {
		echo "blacklisted"; 
		return;
	}

	$iuu = file_get_contents(str_replace("blacklisted_async.php", "iuu.php", $actual_link));
	$iuu = json_decode($iuu);
	if(is_array($iuu)) {
		echo "blacklisted"; 
		return;
	}

	$greenpeace = file_get_contents(str_replace("blacklisted_async.php", "greenpeace.php", $actual_link));
	$greenpeace = json_decode($greenpeace);
	if(sizeof($greenpeace) > 0) {
		echo "blacklisted"; 
		return;
	}

	echo "okay"; 
	return;
?>