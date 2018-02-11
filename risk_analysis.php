<?php require_once "mysql_connect.php";

$country = $_GET['country'];
$species = $_GET['species'];
$company = $_GET['company'];


$result = $mysqli->query("CALL data_country({$country});");

var_dump($result->fetch_assoc());
