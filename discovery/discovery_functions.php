<?php
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/likes.php');
require_once(__DIR__ . '/../database/repositories/dislikes.php');

function get_potential_matching_profiles($user_id)
{
    // Todo: write the functions for these
    $users_liked_by_this_user = array();
    $users_disliked_by_this_user = array();

    $all_users = get_all_user_ids();

    return array_diff($all_users, $users_liked_by_this_user, $users_disliked_by_this_user);
}

function get_user_from_cookies()
{
    if (!isset($_COOKIE["email"])) {
        // todo: get the user to re-login
        echo 'Login please';
        exit();
    }

    return get_user_by_credentials($_COOKIE["email"], $_COOKIE["hashed_password"]);
}

?>