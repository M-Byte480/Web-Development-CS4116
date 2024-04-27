<?php
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/discovery_functions.php');

$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);

$postData = $decoded_json->discovery_action;

$action = $postData->action;
$user_id = $postData->user_id;
$affected_user = $postData->affected_user;


echo json_encode(try_interact_with_another_user($user_id, $affected_user, $action));
?>
