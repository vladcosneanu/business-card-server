<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/BusinessCard.php");

// extract the request variables
$id = $_GET["id"];
$userId = $_GET["user_id"];

// delete a user's card
$businessCard = new BusinessCard();
$businessCard->setId($id);
$businessCard->setUserId($userId);
$businessCard->delete();

$result["success"] = "true";
echo json_encode($result);
?>