<?php

// Validate is user logged in
require_once(__DIR__ . '/../validate_user_logged_in.php');

require_once(__DIR__ . "/../database/repositories/beverages.php");
require_once(__DIR__ . "/../database/repositories/interests.php");
require_once(__DIR__ . "/../database/repositories/profile_pictures.php");
require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . "/../database/repositories/profiles.php");
require_once(__DIR__ . "/../database/repositories/images.php");

$user_ID = (string)get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password'])->fetch_assoc()['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (array_key_exists('edit_bio', $_POST)) {
            update_user_description_from_user_ID($user_ID, htmlspecialchars($_POST['edit_bio']));
        }
        if (array_key_exists('edit_drink', $_POST)) {
            update_users_beverage_from_user_ID($user_ID, $_POST['edit_drink']);
        }
        if (array_key_exists('edit_interests', $_POST)) {
            update_users_interests_from_user_ID($user_ID, $_POST['edit_interests']);
        }
        if (array_key_exists('edit_looking_for', $_POST)) {
            update_user_seeking_from_user_ID($user_ID, $_POST['edit_looking_for']);
        }
        if (array_key_exists('edit_firstname', $_POST)) {
            update_first_name_from_user_ID($user_ID, htmlspecialchars($_POST['edit_firstname']));
        }
        if (array_key_exists('edit_lastname', $_POST)) {
            update_last_name_from_user_ID($user_ID, htmlspecialchars($_POST['edit_lastname']));
        }
        if (array_key_exists('edit_age', $_POST)) {
            if (get_age_from_DOB($_POST['edit_age']) >= 18) {
                update_DOB_from_user_ID($user_ID, $_POST['edit_age']);
            }
        }
        if (array_key_exists('delete_picture', $_POST)) {
            delete_picture_from_user_ID($user_ID, $_POST['delete_picture']);
        }
        if (array_key_exists('add_picture', $_FILES)) {
            if ($_FILES['add_picture']["tmp_name"])
                add_picture_from_user_ID($user_ID, base64_encode(file_get_contents($_FILES['add_picture']["tmp_name"])));
        }
        if (array_key_exists('edit_pfp', $_FILES)) {
            update_user_pfp_from_user_ID($user_ID, base64_encode(file_get_contents($_FILES['edit_pfp']["tmp_name"])));
        }
    } catch (Exception $e) {

    }
}
header("Location: ../profile/");