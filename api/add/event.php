<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");
include_once ("../../objects/Event.php");

// extract the request variables
$userId = $_GET["user_id"];
$name = $_GET["name"];
$location = $_GET["location"];
$date = $_GET["date"];
$passcode = $_GET["passcode"];

// check if the passcode is available
$available = Event::isPasscodeAvailable($passcode);
if ($available) {
	// passcode is available
	// save the event
	$event = new Event();
	$event->setName($name);
	$event->setLocation($location);
	$event->setDate($date);
	$event->setPasscode($passcode);
	$event->save();
	
	// add the user as the first participant to the event
	User::joinEvent($userId, $passcode);
	
	$result["success"] = "true";
} else {
	// passcode not available
	$result["success"] = "false";
}

echo json_encode($result);
?>