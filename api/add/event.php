<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");
include_once ("../../objects/Event.php");

$userId = $_GET["user_id"];
$name = $_GET["name"];
$location = $_GET["location"];
$date = $_GET["date"];
$passcode = $_GET["passcode"];

$available = Event::isPasscodeAvailable($passcode);
if ($available) {
	$event = new Event();
	$event->setName($name);
	$event->setLocation($location);
	$event->setDate($date);
	$event->setPasscode($passcode);
	$event->save();
	
	User::joinEvent($userId, $passcode);
	
	$result["success"] = "true";
} else {
	$result["success"] = "false";
}

echo json_encode($result);
?>