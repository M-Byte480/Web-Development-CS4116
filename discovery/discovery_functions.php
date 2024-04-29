<?php
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/likes.php');
require_once(__DIR__ . '/../database/repositories/dislikes.php');
require_once(__DIR__ . '/../search/search_functions.php');
require_once(__DIR__ . '/../database/repositories/connections.php');
require_once(__DIR__ . '/../database/repositories/notifications.php');


function try_interact_with_another_user($user_id, $affected_user, $action): string
{
    $msg = "";
    switch ($action) {
        case 'dislike':
            //dislike here ->we good
            //dislike missing ->set it
            if (!does_dislike_exist($user_id, $affected_user)) {
                add_dislike_by_user_ids($user_id, $affected_user);
            }
            //like exists -> remove
            //like missing -> we good
            if (does_like_exist($user_id, $affected_user)) {
                delete_like_by_user_ids($user_id, $affected_user);
            }
            break;

        case 'like':
            //like here ->we good
            //like missing ->set it
            if (!does_like_exist($user_id, $affected_user)) {
                add_like_by_user_ids($user_id, $affected_user);
            }

            if (does_dislike_exist($user_id, $affected_user)) {
                remove_dislike_by_user_id($user_id, $affected_user);
            }
            if (check_if_connection_exists($user_id, $affected_user)) {
                create_connection($user_id, $affected_user);
                $msg = "You have connected with " . get_first_name_from_user_ID($affected_user);
                create_notifcation_for_user($affected_user, "You have connected with " . get_first_name_from_user_ID($user_id));
            }

    }


    return ($msg);


}

