<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

// extract the request variables
$id = $_GET["id"];
$lastLat = $_GET["lat"];
$lastLng = $_GET["lng"];
$timestamp = $_GET["timestamp"];

// update the user's GPS location
$user = new User();
$user->setId($id);
$user->setLastLat($lastLat);
$user->setLastLng($lastLng);
$user->setLastGPSUpdate($timestamp);
$user->updateGPSLocation();

$result["success"] = "true";
echo json_encode($result);
?>