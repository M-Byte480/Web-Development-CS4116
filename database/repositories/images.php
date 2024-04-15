<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_images_by_user_id($user_id): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT imageIndex as position, imageData as image FROM Pictures WHERE userId = '{$user_id}' ORDER BY position ASC";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return $result->fetch_all(MYSQLI_ASSOC);
}

function remove_all_pictures($user_id)
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "DELETE FROM Pictures WHERE userId = '{$user_id}'";

    mysqli_query($con, $query);

    mysqli_close($con);
}

?>