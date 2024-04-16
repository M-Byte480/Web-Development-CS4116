<?php

global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../secrets.settings.php');
require_once(__DIR__ . '/signup_functions.php');
require_once(__DIR__ . '/../database/repositories/profiles.php');
require_once(__DIR__ . '/../database/repositories/users.php');

$id = custom_uuid();
$hashed_user_password = hash("sha256", ($_POST["user_password"]));
$time_now = date('Y-m-d');
$date = date('Y-m-d', strtotime($_POST["user_dob"]));
$errors = validateData();
set_id_email_pw_fname_lname_dob_jd($db_host, $db_username, $db_password, $db_database, $id);
set_id_gender($db_host, $db_username, $db_password, $db_database, $id);


$output = array();
$output['Success'] = 1;
$output['errors'] = $errors;
echo json_encode($output);

?>