<?php require_once "mysql_connect.php";

$type = $_GET["type"];
$query = $_GET['query'];


if($type == 'country' and $query != "")
	$result = $mysqli->query("CALL data_countries('{$country}');");
if($type == 'species' and $query != "")
	$result = $mysqli->query("CALL data_species('{$species}');");
if($type == 'company' and $query != "")
	$result = $mysqli->query("CALL data_company('{$company}');");

echo json_encode(($result->fetch_assoc()));
