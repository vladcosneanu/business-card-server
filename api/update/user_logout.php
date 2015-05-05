<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$id = $_GET["id"];

$user = new User();
$user->setId($id);
$user->updateLogout();

$result["success"] = "true";
echo json_encode($result);
?>