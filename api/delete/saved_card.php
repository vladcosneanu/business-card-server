<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/BusinessCard.php");

// extract the request variables
$cardId = $_GET["card_id"];
$userId = $_GET["user_id"];

// delete a user's saved card
$businessCard = new BusinessCard();
$businessCard->setId($cardId);
$businessCard->setUserId($userId);
$businessCard->deleteSaved();

$result["success"] = "true";
echo json_encode($result);
?>