<?php
// Validate is user logged in
require_once(__DIR__ . '/validator_functions.php');
try {
    validate_user_logged_in();
} catch (ValidationException $e) {
    header("Location: /login/");
}