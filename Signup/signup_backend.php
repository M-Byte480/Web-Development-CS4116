<?php

global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../secrets.settings.php');
require_once(__DIR__ . '/signup_functions.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');
require_once(__DIR__ . '/../database/repositories/users.php');

$id = custom_uuid();
$errors = validateData();
$output = array();

$gender = $_POST["gender"];
$password = $_POST["user_password"];
$email = $_POST["user_email"];
$first_name = $_POST["user_first_name"];
$second_name = $_POST["user_second_name"];
$date_of_birth = date('Y-m-d', strtotime($_POST["user_dob"]));
$email_in_use = is_email_taken($email);

if($email_in_use){
    $errors[] = "Email already linked to an existing account";
}

if (empty($errors)) {
    add_user_to_database($id, $email, $first_name, $second_name, $password, $date_of_birth);
    add_new_row_to_profile($id, $gender);
    $output['success'] = 1;
} else {
    $output['success'] = 0;
}

$output['errors'] = $errors;

echo json_encode($output);

?>