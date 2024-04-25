<?php
require_once(__DIR__ . "/../database/repositories/dislikes.php");
require_once(__DIR__ . "/../database/repositories/likes.php");
require_once(__DIR__ . "/../discovery/discovery_functions.php");

$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);

$postData = $decoded_json->discovery_action;

$action = $postData->action;
$user_id = $postData->user_id;
$affected_user = $postData->affected_user;


$hello = json_encode(try_interact_with_another_user($user_id, $affected_user, $action));
echo $hello;
?>