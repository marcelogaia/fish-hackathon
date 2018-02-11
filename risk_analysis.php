<?php require_once "mysql_connect.php";

$country = $_GET['country'];


if($country == '')
	$result = $mysqli->query("CALL jorge('{$country}');");

echo json_encode(($result->fetch_assoc()));
