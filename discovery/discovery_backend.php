<?php
require_once(__DIR__ . '/../validate_user_logged_in.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . "/../database/repositories/users.php");

//$json = filter_input(INPUT_POST, 'json');
//$decoded_json = json_decode($json);
//$postData = $decoded_json->report_action;
//
////report_action': {
////                    'report_reason': document.getElementById('report_reason').value,
/*/*                    'user_id': "<?= $user_id ?>",*/
/*/*                    'reported_user': "<?= $_GET['user_id'] ?>"*/
////                }
//
//$user_ID = $postData->user_id;
//$reported_user_ID = $postData->reported_user;
//$report_reason = $postData->report_reason;
//
////$user_ID = $_POST['user_ID'];
////print_r($user_ID);
////$reported_user_ID = $_POST['reported_user_ID'];
////print_r($reported_user_ID);
//
//add_new_report($user_ID, $reported_user_ID, $report_reason);

if (isset($_POST['report_reason']) && isset($_POST['user_id']) && isset($_POST['reported_user'])) {
    $user_ID = $_POST['user_id'];
    $reported_user_ID = $_POST['reported_user'];
    $report_reason = $_POST['report_reason'];

    echo "Sucess";
    add_new_report($user_ID, $reported_user_ID, $report_reason);
}
