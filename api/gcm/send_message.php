<?php
include_once ("GCMPushMessage.php");

$apiKey = "AIzaSyClU64iccv6LVTB0IkccBvL3OKPSrh9jPo";
$devices = array('APA91bHrQKniTR2Inegtx47QNCctVDY_8RrJBw9zSVFkzptUdZaKs1cWuJXBS2sGO8fjmlwKiYYO4Nc4YVz_ho1Pvm32ZiCkFMv_lbu7inkKlLvTAyLsZUW78IC1pNIERH28cSTanuBY8VbqHdjxf4BeUG0JF6Qg8A');
$message = "The message to send";

$gcpm = new GCMPushMessage($apiKey);
$gcpm->setDevices($devices);
$response = $gcpm->send($message, array('title' => 'Test title'));

var_dump($response);
?>