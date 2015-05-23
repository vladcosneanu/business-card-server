<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");
include_once ("../../objects/BusinessCard.php");
include_once ("../gcm/GCMPushMessage.php");

// extract the request variables
$userId = $_GET["user_id"];
$cardId = $_GET["card_id"];

$user = User::getById($userId);
$card = BusinessCard::getById($cardId);
$cardUser = User::getById($card->getUserId());

// set up and send the message to GCM
$apiKey = "AIzaSyClU64iccv6LVTB0IkccBvL3OKPSrh9jPo";
$devices = array($user->getGCMRegId());
$message = $cardUser->getFirstName() . " " . $cardUser->getLastName() . " would like to share his " . $card->getTitle() . " business card.";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($message, array('title' => 'Business Card share request', 'card_id' => $cardId, 'user_id' => $userId));

echo $response;
?>