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

if (empty($errors)) {
    set_id_email_pw_fname_lname_dob_jd($db_host, $db_username, $db_password, $db_database, $id);
    set_id_gender($db_host, $db_username, $db_password, $db_database, $id, $gender);
    $output['success'] = 1;
} else {
    $output['success'] = 0;
}

$output['errors'] = $errors;

echo json_encode($output);

?>