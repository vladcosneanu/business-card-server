<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

// extract the request variables
$userId = $_GET["user_id"];

// get the user's cards
$myCards = User::getMyCards($userId);

echo json_encode($myCards);
?>