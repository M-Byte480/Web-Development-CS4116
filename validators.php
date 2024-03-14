<?php
// We need to check if cookies are tampered with or
// if text entered by users are SQL injections

function validate_email($email) // Boolean
{
    // Regex
    $regex = '^[A-Za-z0-9]+@[A-Za-z]+[A-Za-z0-9]*\.[A-Za-z]+$';
    return preg_match($email, $regex);
}

function validate_uuid($uuid)
{
    // 8-4-4-4-12
    $regex = '^[A-Za-z0-9]{8}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{4}-[A-Za-z0-9]{12}$';
    return preg_match($uuid, $regex);
}

function validate_user_id($uuid)
{
    return validate_uuid($uuid);
}

function validate_hashed_password($hashed_password)
{
    return validate_uuid($hashed_password);
}

function validate_password($password)
{

}


?>