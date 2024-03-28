<?php
// This page should be accessed by an Admin only

/*
 * -1 Failed to find action field
 *  0 Error
 *  1 Success
 */
const FAIL = -1;
const SUCCESS = 1;
const ERROR = 0;

if (isset($_POST['action']) && $_POST['action']) {
    $action = $_POST['action'];
} else {
    echo json_encode(array('success' => FAIL));
    exit();
}

require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/profile_pictures.php');
try {
    switch ($action) {
        case 'ban':
            validate_ban_parameters($_POST);
            ban_user_by_id($_POST['user_id']);
            break;
        case 'remove_bio':
            update_user_bio($_POST['user_id'], '');
            break;
        case 'remove_pfp':
            update_user_pfp($_POST['user_id'], '');
            break;
        case 'remove_all_images':
            break;
        case 'delete':
            validate_delete_parameters($_POST);
            delete_user_by_id($_POST['user_id']);
            break;
    }
} catch (ValidationException $e) {
    echo json_encode(array('success' => ERROR));
    exit();
}


echo json_encode(array('success' => SUCCESS));

?>