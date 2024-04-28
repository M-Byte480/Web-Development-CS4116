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
require_once(__DIR__ . '/../signup/signup_functions.php');
require_once(__DIR__ . '/../validator_functions.php');
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');
require_once(__DIR__ . '/../database/repositories/profile_pictures.php');
require_once(__DIR__ . '/../database/repositories/images.php');
require_once(__DIR__ . '/admin_functions.php');

$return_array = array();
$return_array['success'] = SUCCESS;

function pfp($user): void
{
    ?>
    <img src="<?php
    $pfp = get_user_pfp_from_user_ID($user['id']);
    if ($pfp) {
        echo("data:image/png;base64," . $pfp);
    } else {
        echo("../resources/search/default_image.jgp");
    }
    ?>"
         alt="Profile Picture"
         class="img-fluid rounded-circle"
         style="width: 100px; height: 100px; object-fit: cover;"
    >
    <?php
}

function user_information($user): void
{
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>
                    <a href="<?= '../profile/' . "?user_id=" . $user['id'] ?>"
                       target="_blank"
                       style="color: inherit;"><?= get_user_name($user) ?></a> <?= get_user_age($user) ?>
                </h4>
            </div>
            <div class="col-md-6">Reports: <?= $user['reportCount'] === null ? 0 : $user['reportCount'] ?>
            </div>
        </div>
    </div>
    <?php
}

function action_button($user): void
{
    ?>
    <div class="dropdown">
        <div class="mobile-menu-toggle">
            <button class="btn <?= $user['banned'] ? 'btn-light' : 'btn-dark' ?> dropdown-toggle mobile-toggle-btn btn-sm"
                    type="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu p-2">
                <li>
                    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" value="<?= $user['id'] ?>"
                            data-bs-target="#banModal" onclick="fetchBanUser('<?= $user['id'] ?>')">
                        Ban Options
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal"
                            data-bs-target="#editUserModal" onClick="fetchUserActions('<?= $user['id'] ?>')">
                        User Options
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-secondary m-1" data-bs-toggle="modal"
                            data-bs-target="#viewHistoryModal" onClick="fetchBanHistory('<?= $user['id'] ?>')">
                        Ban History
                    </button>
                </li>
                <li>
                    <button type="button" class="btn btn-secondary m-1" data-bs-toggle="modal"
                            data-bs-target="#viewHistoryModal" onClick="fetchReportLogs('<?= $user['id'] ?>')">
                        Report Log
                    </button>
                </li>
                <li>
                    <form id="removeForm-<?= $user['id'] ?>" method="post" action="admin_backend.php">
                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                        <input type="hidden" name="admin_email" value="<?= $_COOKIE['email'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="button" class="btn btn-danger m-1" name="removeBtn" id="removeBtn" value="Delete"
                                onclick="deleteUser('<?= $user['id'] ?>')">
                            Delete
                        </button>
                    </form>
                </li>
            </ul>

        </div>
    </div>
    <?php
}

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

            if (!is_value_set($_POST, 'unbanDate')) {
                $return_array['msg'] = 'Expiration is not set';
                $return_array['success'] = ERROR;
                break;
            }

            if (!temporarily_ban_user_with_user_ID($_POST)) {
                $return_array['success'] = ERROR;
                $return_array['msg'] = "Failed to ban user! Contact the developers";

            } else {
                $return_array['msg'] = "Temporarily banned user!";
                $return_array['user_id'] = $_POST['user_id'];
            }

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
            update_user_description_from_user_ID($_POST['user_id'], '');
            $return_array['msg'] = "Successfully removed Bio!";

            break;
        case 'remove_pfp':

            $gender = get_gender_from_user_ID($_POST['user_id']);
            set_profile_picture_on_gender($_POST['user_id'], $gender);
            $return_array['msg'] = "Successfully removed PFP!";

            break;
        case 'remove_all_images':
            remove_all_pictures($_POST['user_id']);
            $return_array['msg'] = "Successfully removed images!";

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

        case 'get-ban-history':
            $user = get_user_by_id($_POST['id']);
            get_user_ban_history($user);

            exit();

        case 'get-report-history':
            $user = get_user_by_id($_POST['id']);
            get_user_report_history($user);

            exit();

        case 'get-users':
            $json = filter_input(INPUT_POST, 'json');
            $decoded_json = json_decode($json, true);

            $usersInDb = get_users_for_admin_page($decoded_json["searchText"], $decoded_json["row_number"]);
            foreach ($usersInDb as $user) {
                ?>
                <div class="container list-item" id="<?= $user['id'] ?>">
                    <div style="display: none;" class="list-flag">
                        <?= get_user_name($user) . ' ' . get_user_age($user) ?></div>
                    <div style="display: none;" class="list-id"><?= $user['id'] ?></div>
                    <div id="<?= 'row-' . $user['id'] ?>"
                         class=" row align-items-center height-100px mt-3 border curve-100 <?= $user['banned'] ? 'bg-red' : 'bg-gray' ?>">
                        <div class="col-2 col-sm-2 col-md-2 p-1 width-100px">
                            <?php pfp($user) ?>
                        </div>
                        <div class="col-6 col-sm-8 col-md-8">
                            <?php user_information($user) ?>
                        </div>
                        <div class="col-2 col-sm-2 col-md-2 text-md-right">
                            <?php action_button($user) ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            exit();
    }
} catch (ValidationException $e) {
    $return_array['success'] = ERROR;
}

echo json_encode($return_array);

?>