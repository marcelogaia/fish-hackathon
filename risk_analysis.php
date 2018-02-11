<?php require_once "mysql_connect.php";

$country = $_GET['country'];
$species = $_GET['species'];
$company = $_GET['company'];


if(isset($_GET['country']))
	$result = $mysqli->query("CALL data_countries('{$country}');");
if(isset($_GET['species']))
	$result = $mysqli->query("CALL data_species('{$species}');");
if(isset($_GET['company']))
	$result = $mysqli->query("CALL data_company('{$company}');");

echo json_encode(($result->fetch_assoc()));
