<?php require_once "mysql_connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$country = $_GET['country'];

if($country != '') $result = $mysqli->query("CALL jorge('{$country}')");

echo json_encode(($result->fetch_assoc()));
