<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/Event.php");

$eventId = $_GET["event_id"];
$userId = $_GET["user_id"];

Event::deleteJoined($userId, $eventId);

$result["success"] = "true";
echo json_encode($result);
?>