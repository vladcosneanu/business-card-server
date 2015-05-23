<?php
include_once ("../objects/Utils.php");
Utils::$relativePath = "../";
include_once ('../db/db_connection.php');
$link = Database::getDBConnection();

// extract the request variables
$username = $_GET["username"];
$password = $_GET["password"];

// get the user (if it exists) from the database
$query = "SELECT * FROM users WHERE username = '" . $username . "' AND password = SHA1('" . $password . "');";
$result = mysqli_query($link, $query);
$user = array();
$user["found"] = false;
while($row = mysqli_fetch_array($result)) {
	$user["found"] = true;
	$user["id"] = $row["id"];
	$user["title"] = $row["title"];
	$user["firstName"] = $row["first_name"];
	$user["lastName"] = $row["last_name"];
	$user["username"] = $row["username"];
	$user["username"] = $row["username"];
	$user["password"] = $row["password"];
}

echo json_encode($user);
?>