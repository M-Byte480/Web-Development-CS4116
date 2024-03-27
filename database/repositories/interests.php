<?php
global $db_host, $db_username, $db_password, $db_database;
require_once(__DIR__ . '/../../secrets.settings.php');

function get_all_interests(): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }


    $query = "SELECT name FROM interests";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return array_column($result->fetch_all(), 0);
}

function get_user_interests($user_id): array
{
    global $db_host, $db_username, $db_password, $db_database;
    $con = mysqli_connect($db_host, $db_username, $db_password, $db_database);

    if (!$con) {
        die('Could not connect: ' . mysqli_error($con));
    }

    $query = "SELECT name
                FROM userinterests JOIN interests ON userinterests.interestId = interests.id
                where userid = '{$user_id}'";

    $result = mysqli_query($con, $query);

    mysqli_close($con);

    return array_column($result->fetch_all(), 0);
}

?>