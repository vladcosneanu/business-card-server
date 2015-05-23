<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

// extract the request variables
$userId = $_GET["user_id"];
$passcode = $_GET["passcode"];

// attempt to join the event
$joinResult = User::joinEvent($userId, $passcode);
if (strcmp($joinResult, "Event does not exist") == 0) {
	// event does not exist
	$result["success"] = "false";
	$result["error"] = $joinResult;
} else if (strcmp($joinResult, "User already added to event") == 0) {
	// user already joined the event
	$result["success"] = "false";
	$result["error"] = $joinResult;
} else {
	// the user successfully joined the event
	$result["success"] = "true";
	$result["event"] = $joinResult;
}

echo json_encode($result);
?>