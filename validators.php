<?php
// We need to check if cookies are tampered with or
// if text entered by users are SQL injections

function validate_email($email) // Boolean
{
    // Regex
    $regex = '/^(?!\.)[A-Za-z0-9.]+@[A-Za-z]+[A-Za-z0-9]*\.[A-Za-z]+$/';
    return preg_match($regex, $email);
}

function validate_uuid($uuid)
{
    // 8-4-4-4-12
    $regex = '/^[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$/';
    return preg_match($regex, $uuid);
}

function validate_user_id($uuid)
{
    return validate_uuid($uuid);
}

function validate_hashed_password($hashed_password)
{
    // 64 alphanumeric characters
    $regex = '/^[a-z0-9]{64}$/';
    return preg_match($regex, $hashed_password);
}

function validate_password($password)
{

}

function validate_unique_result($result)
{
    if ($result->num_rows != 1) {
        echo 'Result is not unique';
        exit();
    }
}

function validate_admin($id)
{
    if (!validate_user_id($id)) {
        echo 'Invalid ID';
        exit();
    }

    $retrieved_user = getUserById($id);

    return $retrieved_user['admin'];
}

?>