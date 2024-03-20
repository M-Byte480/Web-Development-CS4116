<?php
// We need to check if cookies are tampered with or
// if text entered by users are SQL injections

function validate_email($email): false|int
{
    // Regex
    $regex = '/^(?!\.)[A-Za-z0-9.]+@[A-Za-z]+[A-Za-z0-9]*\.[A-Za-z]+$/';
    return preg_match($regex, $email);
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

function validate_password($password)
{

}

function validate_unique_result($result): void
{
    if ($result->num_rows != 1) {
        echo 'Result is not unique';
        exit();
    }
}

function validate_admin($id): bool
{
    if (!validate_user_id($id)) {
        return false;
    }

    $retrieved_user = get_user_by_id($id);

    return $retrieved_user['admin']; // Returns true or false attribute
}

/**
 * @throws ValidationException
 */
function validate_ban_parameters($POST): void
{
    if (array_key_exists('banned_by_email', $POST) && $POST['banned_by_email']) {
        if (!validate_email($POST['banned_by_email'])) {
            throw new ValidationException('Email Validation -> Ban');
        }
    }

    if (array_key_exists('user_id', $POST) && $POST['user_id']) {
        if (!validate_user_id($POST['user_id'])) {
            throw new ValidationException('User ID Validation -> Ban');
        }
    }
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

?>