<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$userId = $_GET["user_id"];
$passcode = $_GET["passcode"];

$joinResult = User::joinEvent($userId, $passcode);
if (strcmp($joinResult, "Event does not exist") == 0) {
	$result["success"] = "false";
	$result["error"] = $joinResult;
} else if (strcmp($joinResult, "User already added to event") == 0) {
	$result["success"] = "false";
	$result["error"] = $joinResult;
} else {
	$result["success"] = "true";
	$result["event"] = $joinResult;
}

echo json_encode($result);
?>