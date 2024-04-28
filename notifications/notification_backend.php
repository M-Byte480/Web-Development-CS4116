<?php
require_once("../imports.php");
require_once(__DIR__ . "/../notifications/notification_check.php");
require_once(__DIR__ . "/../notifications/notification_backend.php");
require_once(__DIR__ . "/../database/repositories/notifications.php");

?>
<?php
$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);
$userId = $decoded_json->notification->userId;
remove_all_notifications($userId);
?>