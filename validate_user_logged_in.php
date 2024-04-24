<?php
// Validate is user logged in
require_once(__DIR__ . '/validator_functions.php');
try {
    validate_user_logged_in();
    require_once(__DIR__ . '/validate_is_user_banned.php');
} catch (ValidationException $e) {
    // User Credentials have expired
    header("Location: ../login/");
    exit();
}