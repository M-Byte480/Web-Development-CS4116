<?php

function validate_login_credentials($row, $GET): array
{
    $alerts = [];
    if (!(isset($GET['email']) && isset($GET['password']))) {
        $alerts[] = "No email or password set  \r";
    }

    $email = trim($GET['email']);

    $password = $GET['password'];

    if (empty($email) || empty($password)) {
        $alerts[] = "Email or Password cannot be empty  \r";
    }
    if (!isset($row['hashedPassword'])) {
        $alerts[] = "User does not exist. Please Sign up \r";
        return $alerts;
    }

    if (($row['hashedPassword'] === hash("sha256", $password))) {
        require_once (__DIR__ . '/../encryption/encryption.php');
        setcookie('hashed_password', $row['hashedPassword'], time() + 60 * 60 * 24 * 7, '/');
        setcookie('email', encrypt($row['email']), time() + 60 * 60 * 24 * 7, '/');
    } else {
        $alerts[] = "Invalid Login  \r";
    }

    return $alerts;
}

?>