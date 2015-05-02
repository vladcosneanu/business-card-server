<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/Conference.php");

$conferenceId = $_GET["conference_id"];
$userId = $_GET["user_id"];

Conference::deleteJoined($userId, $conferenceId);

$result["success"] = "true";
echo json_encode($result);
?>