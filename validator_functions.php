<?php
// We need to check if cookies are tampered with or
// if text entered by users are SQL injections
require_once(__DIR__ . '/exceptions/ValidationException.php');
function validate_email($email, &$errors): bool
{
    if (!isset($email)) {
        $errors[] = "Email is empty \r";
        return false;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format \r";
        return false;
    }
    return true;
}

function validate_encrypted_email($email)
{

}

function validate_uuid($uuid): false|int
{
    // 8-4-4-4-12
    $regex = '/^[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$/';
    return preg_match($regex, $uuid);
}

function validate_user_id($uuid): false|int
{
    return validate_uuid($uuid);
}

function validate_hashed_password($hashed_password): false|int
{
    // 64 alphanumeric characters
    $regex = '/^[a-fA-F0-9]{64}$/';
    return preg_match($regex, $hashed_password);
}

function validate_password($password, &$errors): void
{
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters \r";
    } elseif (strlen($password) > 35) {
        $errors[] = "Password must be less than 35 characters \r";
    }

    if (!preg_match("/[a-zA-Z]/i", $password)) {
        $errors[] = "Password must contain at least one letter \r";
    }

    if (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number \r";
    }

    if (str_contains($password, " ")) {
        $errors[] = "Password must not contain spaces \r";
    }
}

function validate_name(&$name, &$errors, $name_type): void
{
    $regex = '/^(?!.*[0-9@£$%^!€\[\]{}~#:;\\/<>|*+]).*$/';

    $name = trim($name);
    if (!preg_match($regex, $name)) {
        $errors[] = "Invalid {$name_type} \r";
    }

}

function validate_unique_result($result): void
{
    if ($result->num_rows == 0) {
        echo 'User logged in no longer exists';
        exit();
    } elseif ($result->num_rows != 1) {
        echo 'Result is not unique';
        exit();
    }
}

function validate_admin($id)
{
    if (!validate_user_id($id)) {
        return false;
    }

    $retrieved_user = get_user_from_user_ID($id);

    return $retrieved_user['admin']; // Returns true or false attribute
}

/**
 * @throws ValidationException
 */
function validate_ban_parameters($POST): void
{
//    if (array_key_exists('admin_email', $POST) && $POST['admin_email']) {
//        if (!validate_email($POST['admin_email'])) {
//            throw new ValidationException('Email Validation -> Ban');
//        }
//    }
//
//    if (array_key_exists('user_id', $POST) && $POST['user_id']) {
//        if (!validate_user_id($POST['user_id'])) {
//            throw new ValidationException('User ID Validation -> Ban');
//        }
//    }
}

/**
 * @throws ValidationException
 */
function validate_delete_parameters($POST): void
{
    if (array_key_exists('user_id', $POST) && $POST['user_id']) {
        if (!validate_user_id($POST['user_id'])) {
            throw new ValidationException('User ID Validation -> Ban');
        }
    }
}

/**
 * @throws ValidationException
 */
function validate_user_logged_in(): void
{
    if (!(array_key_exists('email', $_COOKIE) && $_COOKIE['email'])) {
        throw new ValidationException('No user_email');
    }

    if (!filter_var($_COOKIE['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException('Invalid user_email');
    }

    if (!(array_key_exists('hashed_password', $_COOKIE) && $_COOKIE['hashed_password'])) {
        throw new ValidationException('No hashed_password');
    }

    if (!validate_hashed_password($_COOKIE['hashed_password'])) {
        throw new ValidationException('Invalid hashed_password');
    }

    require_once(__DIR__ . '/database/repositories/users.php');

    $query_result = get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password']);

    validate_unique_result($query_result);
}

/**
 * @throws ValidationException
 */
function validate_user_is_admin(): void
{
    validate_user_logged_in();

    // Import users, pfp accessor
    require_once(__DIR__ . "/database/repositories/users.php");

    if (!isset($_COOKIE['email']) || !filter_var($_COOKIE['email'], FILTER_VALIDATE_EMAIL)) {
        throw new ValidationException("Not Admin");
    }
    $result = get_user_by_credentials($_COOKIE['email'], $_COOKIE['hashed_password']);
    $user = $result->fetch_assoc();

//     Both these need to be true
    if ($user == null || !validate_admin($user['id'])) {
        throw new ValidationException('Unauthorised');
    }

    // Free the buffer/memory
    mysqli_free_result($result);
}

?>