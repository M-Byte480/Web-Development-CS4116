<?php
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . "/../database/repositories/reports.php");

$json = filter_input(INPUT_POST, 'json');
$decoded_json = json_decode($json);

$postData = $decoded_json->report_action;

$report = $postData->report;

$user_id = $postData->user_id;

$affected_user = $postData->affected_user;


if (sizeof(check_if_report_exists($user_id, $affected_user)) == 0) {
    add_new_report($user_id, $affected_user, $report);
}

?>
