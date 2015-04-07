<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");
include_once ("../../objects/BusinessCard.php");

$title = $_GET["title"];
$firstName = $_GET["first_name"];
$lastName = $_GET["last_name"];
$email = $_GET["email"];
$phone = $_GET["phone"];
$username = $_GET["username"];
$password = $_GET["password"];
$public = $_GET["public"];

$available = User::isUsernameAvailable($username);

$result = array();
if ($available) {
	$user = new User();
	$user->setFirstName($firstName);
	$user->setLastName($lastName);
	$user->setUsername($username);
	$user->setPassword($password);
	$user->save();
	
	$query = "SELECT * FROM users WHERE username = '" . $username . "' AND password = SHA1('" . $password . "');";
	$queryResult = mysqli_query($link, $query);

	$found = false;
	while($row = mysqli_fetch_array($queryResult)) {
		$found = true;
		$user->setId($row["id"]);
	}
	
	$businessCard = new BusinessCard();
	$businessCard->setUserId($user->getId());
	$businessCard->setTitle($title);
	$businessCard->setEmail($email);
	$businessCard->setPhone($phone);
	$businessCard->setPublic($public);
	$businessCard->save();
	
	$result["success"] = "true";
} else {
	$result["success"] = "false";
}

echo json_encode($result);
?>