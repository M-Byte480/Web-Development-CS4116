<?php
require_once('../../validators.php');

function getUserById($id) // SQL Array
{
    if (!validate_user_id($id)) {
        echo 'invalid ID';
        exit();
    }

    global $con;
    $query = "SELECT * FROM user WHERE id = '{$id}'";
    return mysqli_query($con, $query);
}

function getAllUsers() // SQL Array
{
    global $con;
    $query = "SELECT * FROM user";
    return mysqli_query($con, $query);
}

function getUserByCredentials($email, $hashed_password) // SQL Array
{
    if (!validate_email($email)) {
        echo 'invalid email';
        exit();
    }
    if (!validate_hashed_password($hashed_password)) {
        echo 'invalid password';
        exit();
    }
    global $con;
    $query = "SELECT * FROM user WHERE email = '{$email}' AND password = '{$hashed_password}'";

    return mysqli_query($con, $query);
}


?>