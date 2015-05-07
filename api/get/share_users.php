<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$userId =  $_GET["user_id"];
$distance = $_GET["distance"];
$lat = $_GET["lat"];
$lng = $_GET["lng"];

$shareUsers = User::getShareUsers($userId, $distance, $lat, $lng);

echo json_encode($shareUsers);
?>