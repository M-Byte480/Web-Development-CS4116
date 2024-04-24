<?php
// Validate user is logged in and admin
require_once(__DIR__ . '/validator_functions.php');
try {
    require_once (__DIR__ . '/validate_user_logged_in.php');
    validate_user_is_admin();
} catch (ValidationException $e) {
    // User Credentials have expired
    header("Location: ../profile/");
    exit();
}