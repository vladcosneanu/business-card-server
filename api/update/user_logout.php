<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

// extract the request variables
$id = $_GET["id"];

// update the user for logout scenario
$user = new User();
$user->setId($id);
$user->updateLogout();

$result["success"] = "true";
echo json_encode($result);
?>