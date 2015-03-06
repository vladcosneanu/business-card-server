<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$title = $_GET["title"];
$firstName = $_GET["first_name"];
$lastName = $_GET["last_name"];
$email = $_GET["email"];
$phone = $_GET["phone"];
$username = $_GET["username"];
$password = $_GET["password"];

$available = User::isUsernameAvailable($username);

$result = array();
if ($available) {
	$user = new User();
	$user->setTitle($title);
	$user->setFirstName($firstName);
	$user->setLastName($lastName);
	$user->setUsername($username);
	$user->setPassword($password);
	$user->save();
	
	$result["success"] = "true";
} else {
	$result["success"] = "false";
}

echo json_encode($result);
?>