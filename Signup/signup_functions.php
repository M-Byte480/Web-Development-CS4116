<?php
require_once(__DIR__ . '/../validator_functions.php');
function validateData(): array
{
    $errors = [];
    if (!isset($_POST['user_email'])) {
        $errors[] = "Email is empty \r";
    }
    if (!filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format \r";
    }

    if (!isset($_POST['user_first_name'])) {
        $errors[] = "First name is empty \r";
    }
    if (!isset($_POST['user_first_name'])) {
        $errors[] = "First name is empty \r";
    }

    if (!isset($_POST['user_second_name'])) {
        $errors[] = "Surname is empty \r";
    }

    if (strlen($_POST["user_password"]) < 8) {
        $errors[] = "Password must be at least 8 characters \r";
    }

    if (!preg_match("/[a-zA-Z]/i", $_POST["user_password"])) {
        $errors[] = "Password must contain at least one letter \r";
    }

    if (!preg_match("/[0-9]/", $_POST["user_password"])) {
        $errors[] = "Password must contain at least one number \r";
    }

    if (!isset($_POST['user_password'])) {
        $errors[] = "Password field is empty \r";
    }

    if ($_POST["user_password"] !== $_POST["password_confirmation"]) {
        $errors[] = "Passwords must match \r";
    }

    return $errors;

}

function custom_uuid(): string
{
    $bytes = random_bytes(16);

    $bytes[6] = chr(ord($bytes[6]) & 0x0f | 0x40);
    $bytes[8] = chr(ord($bytes[8]) & 0x3f | 0x80);

    // Format the bytes as a UUID
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($bytes), 4));
}


?>

