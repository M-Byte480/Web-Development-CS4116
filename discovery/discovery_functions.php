<?php
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/likes.php');
require_once(__DIR__ . '/../database/repositories/dislikes.php');
require_once(__DIR__ . '/../search/search_functions.php');
require_once(__DIR__ . '/../database/repositories/connections.php');

function get_potential_matching_profiles(): array
{
    // Todo: write the functions for these
    $this_user = get_user_from_cookies();
    $users_matching_description = get_user_matching_description($this_user);
    $users_matching_description_assoc = array();
    while ($row = mysqli_fetch_assoc($users_matching_description)) {
        $users_matching_description_assoc[] = $row;
    }

    $users_liked_by_this_user = get_all_liked_user_by_user_id($this_user['id']);
    $users_disliked_by_this_user = get_all_disliked_user_by_user_id($this_user['id']);

    return array_diff($users_matching_description_assoc, $users_liked_by_this_user, $users_disliked_by_this_user);
}

function get_user_from_cookies()
{
    if (!isset($_COOKIE["email"])) {
        header("Location: ../login/");
        exit();
    }

    return get_user_profile_from_credentials($_COOKIE["email"], $_COOKIE["hashed_password"]);
}

function get_user_matching_description($this_user)
{
    $dob = new DateTime($this_user['dateOfBirth']);
    $diff = $dob->diff(new DateTime());
    $age = $diff->y;
    $interests = get_user_interests_from_user_ID($this_user["id"]);
    $beverage = $this_user['name'];
    $looking_for = $this_user['seeking'];
    $get = array(
        "age1" => $age / 2 - 7,
        "age2" => $age + 7,
        "beverages" => $beverage,
        "interests" => $interests,
        "genders" => array($looking_for),
    );
    return get_user_by_matches($get);
}

function try_interact_with_another_user($user_id, $affected_user, $action): array
{

    $errors = [];
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
            if (check_if_a_new_connection_is_formed($user_id, $affected_user)) {
                create_connection($user_id, $affected_user);
                $errors[] = "You have connected with " . get_first_name_from_user_ID($affected_user);

            }

    }


    return $errors;


}

