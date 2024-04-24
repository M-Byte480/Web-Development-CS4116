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

function remove_all_pictures($user_id): void
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

function delete_picture_from_user_ID($user_id, $index): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "DELETE FROM Pictures WHERE userId = '{$user_id}' AND imageIndex = '{$index}'";
    mysqli_query($con, $query);

    $index += 1;
    $query = "SELECT * FROM Pictures WHERE userId = '{$user_id}' AND imageIndex = {$index}";
    $result = mysqli_query($con, $query);

    while ($result->num_rows > 0) {
        $new_index = $index - 1;
        $query = "UPDATE Pictures SET imageIndex = {$new_index} WHERE userId = '{$user_id}' AND imageIndex = {$index}";
        mysqli_query($con, $query);

        $index += 1;
        $query = "SELECT * FROM Pictures WHERE userId = '{$user_id}' AND imageIndex = {$index}";
        $result = mysqli_query($con, $query);
    }
    mysqli_close($con);
}

function add_picture_from_user_ID($user_ID, $picture): void
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }
    $query = "SELECT * FROM Pictures WHERE userId = '{$user_ID}'";
    $index = mysqli_query($con, $query)->num_rows;

    $query = "INSERT INTO Pictures(userId, imageIndex, imageData) VALUES ('{$user_ID}',{$index},'{$picture}')";
    mysqli_query($con, $query);
}

?>