<?php
require_once(__DIR__ . '/../../validators.php');

global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');


function getUserById($id) // SQL Array
{
    if (!validate_user_id($id)) {
        echo 'invalid ID';
        exit();
    }

    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM users WHERE id = '{$id}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_assoc();
}

function get_all_users() // SQL Array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM users";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result;
}

function getUserByCredentials($email, $hashed_password) // SQL Array
{
    global $db_host, $db_username, $db_password, $db_database;
    if (!validate_email($email)) {
        echo 'invalid email';
        exit();
    }
    if (!validate_hashed_password($hashed_password)) {
        echo 'invalid password';
        exit();
    }

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT * FROM users WHERE email = '{$email}' AND hashedPassword = '{$hashed_password}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);
    return $result;
}


?>