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
    echo json_encode(array('Success' => FAIL));
    exit();
}

require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/profile_pictures.php');
require_once(__DIR__ . '/admin_functions.php');

$return_array = array();
$return_array['success'] = SUCCESS;

try {
    switch ($action) {
        case 'permanent':
            validate_ban_parameters($_POST);
            if (!permanently_ban_user_with_user_ID($_POST)) {
                $return_array['success'] = ERROR;
                $return_array['msg'] = "Failed to ban user!";

                break;
            }
            $return_array['msg'] = "Permanently banned user!";
            $return_array['user_id'] = $_POST['user_id'];
            break;
        case 'temporary':
            validate_ban_parameters($_POST);
            if (!temporarily_ban_user_with_user_ID($_POST)) {
                $return_array['success'] = ERROR;
                $return_array['msg'] = "Failed to ban user!";

                break;
            }
            $return_array['msg'] = "Temporarily banned user!";
            $return_array['user_id'] = $_POST['user_id'];

            break;

        case 'unban':
            if (!unban_user($_POST)) {
                $return_array['success'] = ERROR;
                $return_array['msg'] = "Failed to unban user!";

                break;
            }
            $return_array['msg'] = "Successfully unbanned user!";
            $return_array['user_id'] = $_POST['user_id'];

            break;
        case 'remove_bio':
            update_user_bio_from_user_ID($_POST['user_id'], '');

            break;
        case 'remove_pfp':
            update_user_pfp_from_user_ID($_POST['user_id'], '');

            break;
        case 'remove_all_images':

            break;
        case 'delete':
            validate_delete_parameters($_POST);
            delete_user_from_user_ID($_POST['user_id']);

            break;
        case 'get-ban-details':
            $user = get_user_by_id($_POST['id']);
            ban_user_functionality($user);

            exit();
        case 'get-user-actions':
            $user = get_user_by_id($_POST['id']);
            get_user_actions($user);

            exit();
    }
} catch (ValidationException $e) {
    $return_array['success'] = ERROR;
    echo json_encode($return_array);
    exit();
}

echo json_encode($return_array);

?>