<?php
global $db_host, $db_username, $db_password, $db_database, $con;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_user_pfp_from_user_ID(string $user_ID): string|null // base64
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

    $query = "SELECT pfp FROM ProfilePictures WHERE userid = '{$user_ID}'";
    $result = mysqli_query($con, $query)->fetch_assoc();

    mysqli_close($con);
    if ($result) {
        return $result['pfp'];
    }
    return null;
}

function update_user_pfp_from_user_ID($user_ID, $pfp)
{
    global $db_host, $db_username, $db_password, $db_database;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    // Todo: Sanitize both the pfp and the bio;

    // USER BEVERAGES
    $query = "UPDATE ProfilePictures set pfp = '{$pfp}' WHERE userid = '{$user_ID}'";
    mysqli_query($con, $query);

    mysqli_close($con);
}

?>