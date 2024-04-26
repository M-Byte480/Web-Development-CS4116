<?php

global $db_host, $db_username, $db_password, $db_database, $db_some_secret, $secret_encryption_method, $secret_encryption_key;
require_once(__DIR__ . '/../secrets.settings.php');
require_once(__DIR__ . '/signup_functions.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');
require_once(__DIR__ . '/../database/repositories/users.php');
require_once(__DIR__ . '/../database/repositories/profile_pictures.php');
$output = array();
$errors = validate_post_data();

if (empty($errors)) {
    $email = $_POST["user_email"];
    $email_in_use = is_email_taken($email);

    if ($email_in_use) {
        $errors[] = "Email already linked to an existing account";
    }
}

if (empty($errors)) {
    $gender = $_POST["gender"];
    $password = $_POST["user_password"];
    $first_name = $_POST["user_first_name"];
    $second_name = $_POST["user_second_name"];
    $id = custom_uuid();
    $date_of_birth = date('Y-m-d', strtotime($_POST["user_dob"]));
    
    add_user_to_database($id, $email, $first_name, $second_name, $password, $date_of_birth);
    add_new_row_to_profile($id, $gender);
    set_profile_picture_on_gender($id, $gender);
    $output['success'] = 1;
} else {
    $output['success'] = 0;
}


$output['errors'] = $errors;

echo json_encode($output);

?>