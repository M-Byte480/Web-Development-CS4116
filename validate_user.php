<?php
// Validate is user logged in
require_once(__DIR__ . '/validator_functions.php');
try {
    validate_user_logged_in();
    validate_user_is_admin();
} catch (ValidationException $e) {
    echo 'User Credentials have expired';
    exit();
}