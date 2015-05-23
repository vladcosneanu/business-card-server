<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

// extract the request variables
$userId =  $_GET["user_id"];
$distance = $_GET["distance"];
$lat = $_GET["lat"];
$lng = $_GET["lng"];

// get the nearby cards
$nearbyCards = User::getNearbyCards($userId, $distance, $lat, $lng);

echo json_encode($nearbyCards);
?>