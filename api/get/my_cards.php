<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$userId = $_GET["user_id"];
$myCards = User::getMyCards($userId);

echo json_encode($myCards);
?>