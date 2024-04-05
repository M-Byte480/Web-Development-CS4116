<?php

// Validate is user logged in
require_once(__DIR__ . '/../validate_user.php');

require_once(__DIR__ . "/../database/repositories/beverages.php");
require_once(__DIR__ . "/../database/repositories/interests.php");
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . "/../database/repositories/profiles.php");

$user_ID = (string)get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc()['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (array_key_exists('edit_bio', $_POST)) {
        update_user_description_from_user_ID($user_ID, $_POST['edit_bio']);
    } else if (array_key_exists('edit_drink', $_POST)) {
        update_users_beverage_from_user_ID($user_ID, $_POST['edit_drink']);
    } else if (array_key_exists('edit_interests', $_POST)) {
        update_users_interests_from_user_ID($user_ID, $_POST['edit_interests']);
    } else if (array_key_exists('edit_looking_for', $_POST)) {
        update_user_seeking_from_user_ID($user_ID, $_POST['edit_looking_for']);
    }

}
header("Location: ../profile/");