<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$userId =  $_GET["user_id"];
$eventId = $_GET["event_id"];
$eventCards = User::getEventCards($userId, $eventId);

echo json_encode($eventCards);
?>