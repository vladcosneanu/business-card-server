<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");
include_once ("../../objects/BusinessCard.php");
include_once ("../gcm/GCMPushMessage.php");

$userId = $_GET["user_id"];
$cardId = $_GET["card_id"];

User::addPublicCard($userId, $cardId);

$result["success"] = "true";
echo json_encode($result);
?>