<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/BusinessCard.php");

$id = $_GET["id"];
$userId = $_GET["user_id"];
$title = $_GET["title"];
$email = $_GET["email"];
$phone = $_GET["phone"];
$address = $_GET["address"];
$public = $_GET["public"];

$businessCard = new BusinessCard();
$businessCard->setId($id);
$businessCard->setUserId($userId);
$businessCard->setTitle($title);
$businessCard->setEmail($email);
$businessCard->setPhone($phone);
$businessCard->setAddress($address);
$businessCard->setPublic($public);
$businessCard->update();

$result["success"] = "true";
echo json_encode($result);
?>