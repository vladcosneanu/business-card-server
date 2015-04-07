<?php
include_once ("../../objects/Utils.php");
Utils::$relativePath = "../../";
include_once ('../../db/db_connection.php');
$link = Database::getDBConnection();

include_once ("../../objects/User.php");

$id = $_GET["id"];
$gcmRegId = $_GET["gcm_reg_id"];

$user = new User();
$user->setId($id);
$user->setGCMRegId($gcmRegId);
$user->updateGCMRegId();

$result["success"] = "true";
echo json_encode($result);
?>