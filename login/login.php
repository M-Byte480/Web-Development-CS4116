<?php

global $db_host, $db_username, $db_password, $db_database;

require_once(__DIR__ . "/../database/repositories/users.php");
require_once(__DIR__ . '/../secrets.settings.php');
require_once(__DIR__ . '/login_functions.php');
$connection = get_user_from_email($_GET['email']);
$errors = validate_login_credentials($connection, $_GET);
$output = array();

if (empty($errors)) {
    $output['success'] = 1;
} else {
    $output['success'] = 0;
}
$output['alerts'] = $errors;

echo json_encode($output);
?>



