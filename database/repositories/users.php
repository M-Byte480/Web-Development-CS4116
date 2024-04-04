<?php
require_once(__DIR__ . '/../../validator_functions.php');

global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');


function get_user_from_user_ID($user_ID): array
{
    if (!validate_user_id($user_ID)) {
        echo 'invalid ID';
        exit();
    }

    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Users WHERE id = '{$user_ID}'";
    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_assoc();
}

function get_all_users(): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT * FROM Users";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function get_user_by_credentials($email, $hashed_password): mysqli_result
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

    $query = "SELECT * FROM Users WHERE email = '{$email}' AND hashedPassword = '{$hashed_password}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);
    return $result;
}

function ban_user_from_user_ID($user_ID): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "UPDATE Users SET banned = true WHERE id = '{$user_ID}' ";

    mysqli_query($con, $query);

    mysqli_close($con);
}

function delete_user_from_user_ID($user_ID): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    // USER BEVERAGES
    $query = "DELETE FROM Users WHERE id = '{$user_ID}'";
    mysqli_query($con, $query);


    mysqli_close($con);
}

function update_user_bio_from_user_ID($user_ID, $bio): void
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    // USER BEVERAGES
    $query = "UPDATE Users set description = {$bio} WHERE id = '{$user_ID}'";
    mysqli_query($con, $query);


    mysqli_close($con);
}


?>