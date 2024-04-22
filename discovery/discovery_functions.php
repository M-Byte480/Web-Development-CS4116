<?php
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/likes.php');
require_once(__DIR__ . '/../database/repositories/dislikes.php');
require_once(__DIR__ . '/../search/search_functions.php');
function get_potential_matching_profiles(): array
{
    // Todo: write the functions for these
    $this_user = get_user_from_cookies();
    $users_matching_description = get_user_matching_description($this_user);
    $users_matching_description_assoc = array();
    while ($row = mysqli_fetch_row($users_matching_description)) {
        $users_matching_description_assoc[] = $row;
    }

    $users_liked_by_this_user = get_all_liked_user_by_user_id($this_user['id']);
    $users_disliked_by_this_user = get_all_disliked_user_by_user_id($this_user['id']);

    return array_diff($users_matching_description_assoc, $users_liked_by_this_user, $users_disliked_by_this_user);
}

function get_user_from_cookies()
{
    if (!isset($_COOKIE["email"])) {
        // todo: get the user to re-login
        echo 'Login please';
        exit();
    }

    return get_user_profile_from_credentials($_COOKIE["email"], $_COOKIE["hashed_password"]);
}

function get_user_matching_description($this_user){
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

?>